<?php


namespace ForeverEson\Permission\Models;


use think\facade\Cache;
use think\Model;
use ForeverEson\Permission\Contracts\Role as RoleContract;
use ForeverEson\Permission\Traits\Role as RoleTrait;

class Role extends Model implements RoleContract
{
    use RoleTrait;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->name = config('permission.table_names.role');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_permission'),
            config('permission.column_names.permission'),
            config('permission.column_names.role')
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            config('permission.models.user'),
            config('permission.table_names.user_role'),
            config('permission.column_names.user'),
            config('permission.column_names.role')
        );
    }

    /**
     * 缓存角色权限
     *
     * @return mixed
     * @throws \Throwable
     */
    public function cachedPermissions()
    {
        $expireTime = config('permission.cache.expiration_time');
        return Cache::remember($this->cacheKey(), $this->permissions, $expireTime);
    }

    /**
     * 删除缓存角色权限
     *
     * @return mixed
     */
    public function deleteCachedPermissions()
    {
        return Cache::delete($this->cacheKey());
    }

    /**
     * 权限缓存Key
     *
     * @return string
     */
    public function cacheKey()
    {
        return config('permission.cache.permission') . $this[$this->pk];
    }

    /**
     * 同步角色权限
     *
     * @param array $permissions 权限ID数组
     *
     * @return void
     */
    public function syncPermissions(array $permissions)
    {
        $this->permissions()->sync($permissions);
        $this->deleteCachedPermissions();
    }

}
