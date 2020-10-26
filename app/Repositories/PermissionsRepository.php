<?php


namespace App\Repositories;


use App\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionsRepository extends Repository
{
    protected $role_rep;
    public function __construct(Permission $permission, RolesRepository $role_rep)
    {
        $this->model = $permission;
        $this->role_rep = $role_rep;
    }

    public function changePermissions($request) {
        if (Gate::denies('change', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token');
        $roles = $this->role_rep->get();
        foreach ($roles as $role) {
            if (isset($data[$role->id])) {
                $role->savePermissions($data[$role->id]);
            }
            else {
                $role->savePermissions([]);
            }
        }
        return ['status' => 'Права успешно обновлены'];
    }

}
