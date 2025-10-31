<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HasImageUpload;

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image',
        ];

        // Password update check
        if ($request->filled('old_password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $user = auth()->user();

        $hashChecked = !Hash::check($request->old_password, $user->password);

        // Update password check
        if ($request->filled('old_password') && $hashChecked) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update avatar
        if ($request->hasFile('avatar')) {

            $this->deleteOldImage($user->getRawOriginal('avatar'), 'users');

            $validated['avatar'] = $this->saveImage($request->file('avatar'), 'users', 600, 600);
        }

        $user->update($validated);

        return response()->json([
                'status' => 'success',
                'response_code' => 200,
                'message' => 'User has been updated',
                'data' => $user,
            ], 200);
    }
}
