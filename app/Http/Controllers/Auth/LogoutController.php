<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/')->with('success', 'Logged out successfully');
    }
    public function logoutDevice(Request $request, Session $session)
    {
        $session->delete();

        return back()->with('success', 'Device logged out successfully');
    }
        
}
