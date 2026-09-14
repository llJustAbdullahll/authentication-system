<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        $user = User::find(Auth::id());

        $data = $request->validated();
        $data['logout_other_devices'] = $request->has('logout_other_devices') ? true : false;
        $user->update($data);

        return back()->with('success', 'Profile updated successfully');
    }
}
    