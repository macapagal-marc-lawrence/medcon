<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\Drugstore;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Redirects user to their appropriate dashboard after login.
     */
    public function index()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            switch ($usertype) {
                case 'admin':
                    // Get summary counts
                    $totalUsers = \App\Models\User::count();
                    $totalDrugstores = \App\Models\Drugstore::count();
                    $totalOrders = \App\Models\Order::count();

                    // Get recent users
                    $recentUsers = \App\Models\User::orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    // Get recent drugstores
                    $recentDrugstores = \App\Models\Drugstore::with('user')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    // Get recent orders
                    $recentOrders = \App\Models\Order::with(['customer.user', 'store'])
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    // Get notifications
                    $notifications = collect([
                        // New user registrations in last 24 hours
                        'new_users' => \App\Models\User::where('created_at', '>=', now()->subDay())->count(),
                        
                        // New drugstore registrations in last 24 hours
                        'new_drugstores' => \App\Models\Drugstore::where('created_at', '>=', now()->subDay())->count(),
                        
                        // Pending orders
                        'pending_orders' => \App\Models\Order::where('status', 'pending')->count()
                    ]);

                    $totalNotifications = $notifications->sum();

                    return view('admin.index', compact(
                        'totalUsers',
                        'totalDrugstores',
                        'totalOrders',
                        'recentUsers',
                        'recentDrugstores',
                        'recentOrders',
                        'notifications',
                        'totalNotifications'
                    ));
                case 'drugstore':
                    $drugstore = \App\Models\Drugstore::where('user_id', Auth::id())->first();
                    $store_id = $drugstore->id ?? null;

                    // Get total medicines count
                    $totalMedicines = \App\Models\Medicine::where('store_id', $store_id)->count();

                    // Get low stock medicines (less than 20 units)
                    $lowStockMedicines = \App\Models\Medicine::where('store_id', $store_id)
                        ->where('quantity', '<', 20)
                        ->orderBy('quantity', 'asc')
                        ->take(5)
                        ->get();

                    $lowStockCount = \App\Models\Medicine::where('store_id', $store_id)
                        ->where('quantity', '<', 20)
                        ->count();

                    // Get pending orders count
                    $pendingOrders = \App\Models\Order::where('store_id', $store_id)
                        ->where('status', 'pending')
                        ->count();

                    // Get today's revenue
                    $todayRevenue = \App\Models\Order::where('store_id', $store_id)
                        ->where('status', 'completed')
                        ->whereDate('created_at', today())
                        ->sum('total_amount');

                    // Get recent orders
                    $recentOrders = \App\Models\Order::where('store_id', $store_id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    return view('drugstore.index', compact(
                        'totalMedicines',
                        'lowStockMedicines',
                        'lowStockCount',
                        'pendingOrders',
                        'todayRevenue',
                        'recentOrders'
                    ));
                case 'customer':
                    $drugstores = Drugstore::with(['medicines' => function($query) {
                        $query->select('id', 'store_id', 'medicine_name', 'generic_name', 'description', 'medicine_price', 'quantity', 'medicine_img', 'manufactured_date', 'expiration_date');
                    }])->get();
                    
                    // Get cart data from database
                    $customer = \App\Models\Customer::where('user_id', Auth::id())->first();
                    $cartItems = [];
                    
                    if ($customer) {
                        $cartItems = \App\Models\Cart::where('customer_id', $customer->id)
                            ->whereNull('order_id')
                            ->with(['medicine' => function($query) {
                                $query->select('id', 'store_id', 'medicine_name', 'generic_name', 'description', 'medicine_price', 'quantity', 'medicine_img', 'manufactured_date', 'expiration_date');
                            }, 'store'])
                            ->get()
                            ->map(function($cartItem) {
                                return [
                                    'medicine' => $cartItem->medicine,
                                    'store' => $cartItem->store,
                                    'quantity' => $cartItem->quantity
                                ];
                            })
                            ->toArray();
                    }
                    
                    return view('customer.index', compact('drugstores', 'cartItems'));
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Invalid user type.']);
            }
        }

        return redirect()->route('login');
    }

    /**
     * Landing page (/) logic.
     * Show landing page for everyone, with different content for logged in users.
     */
    public function home()
    {
        // Always show the landing page, but pass user data if logged in
        $user = Auth::user();
        $userData = null;
        
        if ($user) {
            // Get user-specific data for the landing page
            $userData = [
                'user' => $user,
                'usertype' => $user->usertype,
                'name' => $user->username,
                'email' => $user->email,
            ];
            
            // Add specific data based on user type
            if ($user->usertype === 'customer' && $user->customer) {
                $userData['customer'] = $user->customer;
            } elseif ($user->usertype === 'drugstore' && $user->drugstore) {
                $userData['drugstore'] = $user->drugstore;
            }
        }
        
        return view('home.index', compact('userData'));
    }

    public function createCustomer()
    {
        return view('admin.add_customer');
    }

    public function storeCustomer(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'birthdate' => 'required|date',
            'sex' => 'required|in:male,female',
            'address' => 'required|string',
            'age' => 'required|integer',
        ]);

        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'usertype' => 'customer',
        ]);

        Customer::create([
            'user_id' => $user->id,
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'birthdate' => $validatedData['birthdate'],
            'age' => $validatedData['age'],
            'sex' => $validatedData['sex'],
            'address' => $validatedData['address'],
        ]);

        return redirect()->route('admin.create')->with('success', 'Customer created successfully.');
    }

    public function viewCustomers()
    {
        $customers = Customer::with('user')->get();
        return view('admin.view_customer', compact('customers'));
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $user = $customer->user;
        $customer->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.view')->with('success', 'Customer deleted successfully.');
    }

    public function createDrugstore()
    {
        return view('admin.drugstore.create');
    }

    public function storeDrugstore(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'storename' => 'required|string|max:255',
            'storeaddress' => 'required|string',
            'licenseno' => 'required|string|unique:drugstores',
            'bir_number' => 'required|string|unique:drugstores',
            'operatingdays' => 'required|string',
        ]);

        // Create user account
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'usertype' => 'drugstore',
        ]);

        // Create drugstore profile
        Drugstore::create([
            'user_id' => $user->id,
            'storename' => $validatedData['storename'],
            'storeaddress' => $validatedData['storeaddress'],
            'licenseno' => $validatedData['licenseno'],
            'bir_number' => $validatedData['bir_number'],
            'operatingdays' => $validatedData['operatingdays'],
        ]);

        return redirect()->route('admin.drugstore.create')
            ->with('success', 'Drugstore created successfully!');
    }
}