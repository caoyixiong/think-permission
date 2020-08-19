<?php


namespace ForeverEson\Permission\Models;


use think\Model;
use ForeverEson\Permission\Contracts\Permission as PermissionContract;
use ForeverEson\Permission\Traits\Permission as PermissionTrait;

class Permission extends Model implements PermissionContract
{
    use PermissionTrait;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->name = config('permission.table_names.permission');
    }

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
