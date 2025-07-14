<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Saseuz\LaravelAuthRdy\Models\PermissionGroup;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $viewPath = 'backend.role.';

    public function __construct()
    {
        $this->middleware('permission:view-role,admin')->only(['index', 'show']);
        $this->middleware('permission:create-role,admin')->only(['create', 'store']);
        $this->middleware('permission:assign-permissions,admin')->only(['show', 'updatePermissions']);
        $this->middleware('permission:update-role,admin')->only(['edit', 'update']);
        $this->middleware('permission:delete-role,admin')->only(['destroy']);
    }
    
    public function index()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view($this->viewPath . 'index', compact('roles'));
    }
    
    public function create()
    {
        return view($this->viewPath . 'create');
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
        
        return view($this->viewPath . 'show', compact('role', 'groups'));
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
        
        return view($this->viewPath . 'edit', compact('role'));
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
