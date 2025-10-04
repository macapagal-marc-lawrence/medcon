<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'roben1578@gmail.com';
            $this->mailer->Password = 'qxwuyspxcpiwpgwc';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
            
            // Enable debug output
            $this->mailer->SMTPDebug = 2; // Enable verbose debug output
            $this->mailer->Debugoutput = function($str, $level) {
                \Log::info("PHPMailer Debug: $str");
            };

            // Default sender
            $this->mailer->setFrom('roben1578@gmail.com', 'MedCon');
            
            // Set charset
            $this->mailer->CharSet = 'UTF-8';
        } catch (Exception $e) {
            throw new Exception("Mail setup failed: " . $e->getMessage());
        }
    }

    public function sendRegistrationEmail($user, $userType)
    {
        try {
            \Log::info("Attempting to send registration email to: " . $user->email);
            $this->mailer->addAddress($user->email, $user->username);
            
            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Welcome to MedCon - Registration Confirmation';
            
            // Different welcome messages based on user type
            if ($userType === 'customer') {
                $name = $user->customer->firstname . ' ' . $user->customer->lastname;
                $body = $this->getCustomerWelcomeTemplate($name);
            } else {
                $name = $user->drugstore->storename;
                $body = $this->getDrugstoreWelcomeTemplate($name);
            }
            
            $this->mailer->Body = $body;
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            \Log::error("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    private function getCustomerWelcomeTemplate($name)
    {
        return '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #2d3748;">Welcome to MedCon, ' . htmlspecialchars($name) . '!</h2>
            <p>Thank you for registering with MedCon - your centralized medicine tracking and management system.</p>
            <p>With your new account, you can:</p>
            <ul>
                <li>Search for medicines across multiple drugstores</li>
                <li>Upload and manage prescriptions</li>
                <li>Track your orders</li>
                <li>Get AI-powered prescription analysis</li>
            </ul>
            <p>If you have any questions, feel free to contact our support team.</p>
            <p style="color: #718096;">Best regards,<br>The MedCon Team</p>
        </div>';
    }

    private function getDrugstoreWelcomeTemplate($storeName)
    {
        return '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #2d3748;">Welcome to MedCon, ' . htmlspecialchars($storeName) . '!</h2>
            <p>Thank you for registering your drugstore with MedCon.</p>
            <p>As a registered drugstore, you can now:</p>
            <ul>
                <li>Manage your medicine inventory</li>
                <li>Process customer orders</li>
                <li>Handle prescriptions</li>
                <li>Track sales and analytics</li>
            </ul>
            <p>If you need any assistance setting up your store, our support team is here to help.</p>
            <p style="color: #718096;">Best regards,<br>The MedCon Team</p>
        </div>';
    }

    public function sendPasswordResetEmail($user, $token)
    {
        try {
            \Log::info("Attempting to send password reset email to: " . $user->email);
            $this->mailer->addAddress($user->email, $user->username);
            
            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Reset Your MedCon Password';
            
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false));
            
            $this->mailer->Body = $this->getPasswordResetTemplate($user->username, $resetUrl);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            \Log::error("Password reset email sending failed: " . $e->getMessage());
            return false;
        }
    }

    private function getPasswordResetTemplate($username, $resetUrl)
    {
        return '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #2d3748;">Reset Your Password</h2>
            <p>Hello ' . htmlspecialchars($username) . ',</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <div style="margin: 30px 0;">
                <a href="' . $resetUrl . '" style="background-color: #4F46E5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Reset Password</a>
            </div>
            <p>This password reset link will expire in 60 minutes.</p>
            <p>If you did not request a password reset, no further action is required.</p>
            <p style="color: #718096;">Best regards,<br>The MedCon Team</p>
            <p style="color: #718096; font-size: 0.875rem; margin-top: 20px;">If you\'re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
            <a href="' . $resetUrl . '" style="color: #4F46E5;">' . $resetUrl . '</a></p>
        </div>';
    }
}
