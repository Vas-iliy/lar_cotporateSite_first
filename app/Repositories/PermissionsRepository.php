<?php


namespace App\Repositories;


use App\Permission;

class PermissionsRepository extends Repository
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

}
