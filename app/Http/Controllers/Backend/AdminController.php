<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Admin;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use HasImageUpload;

    public function __construct()
    {
        $this->middleware('permission:view-admin,admin')->only(['index', 'show']);
        $this->middleware('permission:create-admin,admin')->only(['create', 'store']);
        $this->middleware('permission:update-admin,admin')->only(['edit', 'update']);
        $this->middleware('permission:delete-admin,admin')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('roles')->orderBy('created_at', 'desc')->paginate();
        return Inertia::render('Admin/Index', [
            'admins' => $admins
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')
                    ->where('name', '!=', 'super-admin')
                    ->pluck('name', 'id');

        return Inertia::render('Admin/Create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'profile' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
            'role' => 'required',
        ]);

        $admin = Admin::create($validated);
        $admin->assignRole($validated['role']);

        if ($request->hasFile('profile')) {
            $profile = $this->saveImage($request->file('profile'), 'admins', 400, 400);
            $admin->update(['profile' => $profile]);
        }

        return redirect()->route(admin_route_name() . 'admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::with('roles')->findOrFail($id);
        $roles = Role::where('guard_name', 'admin')
                    ->where('name', '!=', 'super-admin')
                    ->pluck('name', 'id');

        return Inertia::render('Admin/Edit',[
            'admin' => $admin,
            'current_role' => $admin->roles->pluck('name')->first(),
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'required|email|unique:admins,email,' . $id,
            'name' => 'required|string|max:255',
            'role' => 'required',
            'profile' => 'nullable|image',
            'bio' => 'nullable|string',
        ];

        if ($request->filled('old_password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $admin = Admin::findOrFail($id);

        // Check if the old password is correct
        $hashChecked = !Hash::check($request->old_password, $admin->password);
        $auth = auth('admin')->user();
        $superAuth = $auth->hasRole('super-admin');

        if ($superAuth) {
            $superPass = !Hash::check($request->old_password, $auth->password);
            $hashChecked = !Hash::check($request->old_password, $admin->password) && $superPass;
        }
        
        if ($request->filled('old_password') && $hashChecked) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        if ($request->hasFile('profile')) {
            
            $this->deleteOldImage($admin->getRawOriginal('profile'), 'admins');

            $validated['profile'] = $this->saveImage($request->file('profile'), 'admins', 400, 400);
        }

        $admin->update($validated);
        $admin->syncRoles($validated['role']);

        return redirect()->route(admin_route_name() . 'admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->hasRole('super-admin')) {
            return redirect()->route(admin_route_name() . 'admins.index')
                ->with('error', 'You cannot delete the super-admin admin.');
        }

        $authAdmin = auth('admin')->user();

        if($authAdmin->hasRole($admin->roles()->get())) {
            return redirect()->route(admin_route_name() . 'admins.index')
                ->with('error', 'You cannot delete yourself. or same role as you.');
        }

        $admin->delete();

        return redirect()->route(admin_route_name() . 'admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
}
