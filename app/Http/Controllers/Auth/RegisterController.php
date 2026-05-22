<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $redirectTo = '/client/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * STEP 1: Tampilkan form register (name + email)
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // pastikan ini ada
    }

    /**
     * STEP 1: Proses nama + email -> simpan session + kirim OTP
     */
   public function registerStepOne(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
    ]);

    try {

        $otp = rand(100000, 999999);

        // Simpan ke session
        session([
            'register.name' => $request->name,
            'register.email' => $request->email,
            'register.otp' => $otp,
            'register.otp_expires' => now()->addMinutes(10),
        ]);

        // Kirim OTP
        Mail::raw("Your OTP code is: $otp (valid for 10 minutes)", function ($message) use ($request) {

            $message->to($request->email)
                    ->subject('Verify Your Email');

        });

        return redirect()->route('verify.otp.form', [
            'email' => $request->email
        ])->with('success', 'OTP has been sent to your email.');

    } catch (\Exception $e) {

        return back()->withErrors([
            'email' => 'Mail Error: ' . $e->getMessage()
        ]);
    }
}
    /**
     * STEP 2: Tampilkan halaman verifikasi OTP
     */
    public function showOtpForm(Request $request)
    {
        $email = $request->query('email') ?? session('register.email');

        if (! $email) {
            return redirect()->route('register')->withErrors(['email' => 'Email not provided.']);
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * STEP 2: Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $sessionEmail = session('register.email');
        $sessionOtp = session('register.otp');
        $otpExpires = session('register.otp_expires');

        if ($request->email != $sessionEmail || $request->otp != $sessionOtp || now()->gt($otpExpires)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        // OTP valid, redirect ke set password
        return redirect()->route('set.password.form', ['email' => $sessionEmail])
                         ->with('success', 'OTP verified, please set your password.');
    }

    /**
     * STEP 3: Tampilkan halaman set password
     */
    public function showPasswordForm(Request $request)
    {
        $email = $request->query('email');

        // pastikan email sesuai session
        if (! session('register.email') || $email !== session('register.email')) {
            return redirect()->route('register')
                             ->withErrors(['email' => 'Access denied. Complete OTP verification first.']);
        }

        return view('auth.set-password', compact('email'));
    }


    /**
     * STEP 3: Simpan password -> buat user di DB
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $name = session('register.name');
        $email = session('register.email');

        if (!$name || $email != $request->email) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

    User::create([
        'name' => $name,
        'email' => $email,
        'role' => 'user', 
        'password' => Hash::make($request->password),
        'is_verified' => true,
    ]);

        session()->forget('register');

        return redirect()->route('login')->with('success', 'Account created successfully, please login.');
    }
}
