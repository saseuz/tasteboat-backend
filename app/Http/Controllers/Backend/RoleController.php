<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\PermissionGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'super-admin')->paginate();

        return Inertia::render('Role/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return Inertia::render('Role/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s_-]+$/|max:250|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);
        
        return redirect()->route(admin_route_name() . 'roles.show', $role->id)
            ->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);

        $groups = PermissionGroup::with(['permissions:id,permission_group_id,name'])
                        ->select(['id', 'name'])->orderBy('id')->get();

        return Inertia::render('Role/Show', [
            'role' => $role,
            'permissions' => $role->permissions()->pluck('id'),
            'groups' => $groups
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions);

        return redirect()->route(admin_route_name() . 'roles.index')
            ->with('success', 'Permissions successfully assigned.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name == 'super-admin') {
            return redirect()->route(admin_route_name() . 'roles.index')
                ->with('error', 'You cannot edit the super-admin role.');
        }
        
        return Inertia::render('Role/Edit', [
            'role' => $role
        ]);
    }

    public function update(Request  $request, $id)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s_-]+$/|max:250|unique:roles,name,'.$id,
        ]);

        $role = Role::findOrFail($id);

        if ($role->name == 'super-admin') {
            return redirect()->route(admin_route_name() . 'roles.index')
                ->with('error', 'You cannot edit the super-admin role.');
        }

        $role->update([
            'name' => $request->name
        ]);

        return redirect()->route(admin_route_name() . 'roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name == 'super-admin') {
            return redirect()->route(admin_route_name() . 'roles.index')
                ->with('error', 'You cannot delete the super-admin role.');
        }

        if(auth('admin')->user()->hasRole($role->name)) {
            return redirect()->route(admin_route_name() . 'roles.index')
                ->with('error', 'You cannot delete self assigned role.');
        }

        $role->delete();

        return redirect()->route(admin_route_name() . 'roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
