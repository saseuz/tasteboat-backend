<?php

namespace App\Http\Controllers\Backend;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate();

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('User/Show', [
            'user' => $user,
            'user_status' => $user->status->label()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, User $user)
    {
        if ($request->status == UserStatus::ACTIVE->value) {
            $status = UserStatus::INACTIVE;
        } else {
            $status = UserStatus::ACTIVE;
        }

        $user->update([
            'status' => $status
        ]);

        return redirect()->route(admin_route_name() . 'users.index')
            ->with('success', 'User ' . $status->label() . ' successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route(admin_route_name() . 'users.index')
            ->with('success', 'User deleted successfully.');
    }
}
