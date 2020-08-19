<?php


namespace ForeverEson\Permission\Traits;


trait Permission
{

    public function roles()
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_permission'),
            config('permission.column_names.role'),
            config('permission.column_names.permission')
        );
    }
}
