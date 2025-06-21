<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\InvalidPassword;
use Kreait\Firebase\Exception\Auth\UserNotFound;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => null,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    // Show login form
    public function showLogin()
    {
        return view('login');
    }

    // Handle login
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     $remember = $request->filled('remember');

    //     if (Auth::attempt($credentials, $remember)) {
    //         $request->session()->regenerate();
    //         return redirect()->route('admin.dashboard');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('email');
    // }


    public function login(Request $request)
    {
        $firebase = app(FirebaseAuth::class);
        $firestore = app('firebase.firestore');

        try {
            $signInResult = $firebase->signInWithEmailAndPassword($request->email, $request->password);
            $firebaseUser = $firebase->getUserByEmail($request->email);

            // Ambil data user dari Firestore
            $userDoc = $firestore->collection('users')->document($firebaseUser->uid)->snapshot();
            $userData = $userDoc->exists() ? $userDoc->data() : [];

            // Simpan data user ke session
            session([
                'firebase_uid' => $firebaseUser->uid,
                'firebase_email' => $firebaseUser->email,
                'firebase_name' => $userData['name'] ?? $firebaseUser->displayName ?? $firebaseUser->email,
                'firebase_role' => $userData['role']
            ]);

            return redirect()->route('admin.dashboard');
        } catch (InvalidPassword | UserNotFound $e) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->onlyInput('email');
        }
    }

public function logout(Request $request)
{
    $request->session()->flush();
    return redirect()->route('home');
}
//     public function logout(Request $request)
//     {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         return redirect()->route('home');
//     }
}
