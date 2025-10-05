<?php

namespace App\Actions\Fortify;

use App\Models\Drugstore;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Services\MailService;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => [
                'required', 
                'string', 
                'email:rfc,dns', 
                'max:255', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => $this->passwordRules(),
            'usertype' => ['required', 'in:customer,drugstore'],
        ], [
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'username.min' => 'Username must be at least 3 characters long.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.regex' => 'Please enter a valid email address format.',
            'usertype.in' => 'Please select a valid user type.',
        ])->validate();

        // Step 1: Create the base user
        $user = User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'usertype' => $input['usertype'],
            'password' => Hash::make($input['password']),
        ]);

        // Step 2: Create related user type info with validation
        if ($input['usertype'] === 'customer') {
            // Validate customer-specific fields
            Validator::make($input, [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'age' => ['required', 'integer', 'min:1', 'max:120'],
                'birthdate' => ['required', 'date', 'before:today'],
                'sex' => ['required', 'in:Male,Female'],
                'address' => ['required', 'string', 'max:500'],
            ], [
                'firstname.required' => 'First name is required.',
                'lastname.required' => 'Last name is required.',
                'age.required' => 'Age is required.',
                'age.min' => 'Age must be at least 1.',
                'age.max' => 'Age cannot exceed 120.',
                'birthdate.required' => 'Birthdate is required.',
                'birthdate.before' => 'Birthdate must be before today.',
                'sex.required' => 'Please select your gender.',
                'sex.in' => 'Please select a valid gender.',
                'address.required' => 'Address is required.',
            ])->validate();

            Customer::create([
                'user_id' => $user->id,
                'firstname' => $input['firstname'],
                'middlename' => $input['middlename'] ?? null,
                'lastname' => $input['lastname'],
                'age' => $input['age'],
                'birthdate' => $input['birthdate'],
                'sex' => $input['sex'],
                'address' => $input['address'],
                'latitude' => $input['latitude'] ?? null,
                'longitude' => $input['longitude'] ?? null,
            ]);
        } elseif ($input['usertype'] === 'drugstore') {
            // Validate drugstore-specific fields
            Validator::make($input, [
                'storename' => ['required', 'string', 'max:255'],
                'storeaddress' => ['required', 'string', 'max:500'],
                'licenseno' => ['required', 'string', 'max:255', 'unique:drugstores,licenseno'],
                'bir_number' => ['required', 'string', 'max:20', 'regex:/^\d{3}-\d{3}-\d{3}-\d{3}$/'],
                'operatingdays' => ['required', 'string', 'max:255'],
            ], [
                'storename.required' => 'Store name is required.',
                'storeaddress.required' => 'Store address is required.',
                'licenseno.required' => 'License number is required.',
                'licenseno.unique' => 'This license number is already registered.',
                'bir_number.required' => 'BIR number is required.',
                'bir_number.regex' => 'BIR number must be in format XXX-XXX-XXX-XXX.',
                'operatingdays.required' => 'Operating days/hours is required.',
            ])->validate();

            Drugstore::create([
                'user_id' => $user->id,
                'storename' => $input['storename'],
                'storeaddress' => $input['storeaddress'],
                'licenseno' => $input['licenseno'],
                'operatingdays' => $input['operatingdays'],
                'bir_number' => $input['bir_number'],
                'latitude' => $input['latitude'] ?? null,
                'longitude' => $input['longitude'] ?? null,
            ]);
        }

        // Send email verification
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            \Log::error("Failed to send verification email: " . $e->getMessage());
            // Don't prevent registration if email fails
        }

        return $user;
    }
}

