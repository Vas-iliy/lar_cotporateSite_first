<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users() {
        return $this->belongsToMany('App\User', 'role_user');
    }

    public function permissions() {
        return $this->belongsToMany('App\Permission', 'permission_role');
    }

    public function hasPermission($name, $require = false) {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);
                if ($permissionName && !$require) {
                    return true;
                }
                elseif (!$permissionName && $require) {
                    return false;
                }
            }
            return $require;
        }
        else {
            foreach ($this->permissions()->get() as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }
    }
}
