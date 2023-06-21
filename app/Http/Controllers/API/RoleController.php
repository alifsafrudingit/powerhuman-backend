<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);
        $with_repsonsibilities = $request->input('with_responsibilities', false);

        $roleQuery = Role::query();

        if ($id) {
            $role = $roleQuery->with('responsibilities')->find($id);

            if ($role) {
                return ResponseFormatter::success($role, 'Role found');
            }

            return ResponseFormatter::error('Role not found', 404);
        }

        $roles = $roleQuery->where('company_id', $request->company_id);

        if ($name) {
            $roles->where('name', 'like', '%'.$name.'%');
        }

        if ($with_repsonsibilities) {
            $roles->with('responsibilities');
        }

        return ResponseFormatter::success(
            $roles->paginate($limit), 'Roles found'
        );
    }

    public function create(CreateRoleRequest $request)
    {
        try {
            $role = Role::create([
                'name' => $request->name,
                'company_id' => $request->company_id
            ]);

            if (!$role) {
                throw new Exception('Role not created');
            }

            $role->load('companies');

            return ResponseFormatter::success($role, 'Role Created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            // Get role
            $role = Role::find($id);

            // Check if role not exists
            if (!$role) {
                throw new Exception('Role not update');
            }
    
            // Create role
            $role->update([
                'name' => $request->name,
                'company_id' => $request->company_id,
            ]);

            return ResponseFormatter::success($role, 'role updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Get role
            $role = Role::find($id);

            // TODO: Check if role is owned by user
        
            // Check if role exists
            if (!$role) {
                throw new Exception('Role not found');
            }

            // Delete role
            $role->delete();

            return ResponseFormatter::success('Role deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
