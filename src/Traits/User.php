<?php


namespace ForeverEson\Permission\Traits;


use think\facade\Cache;

trait User
{

    public function roles()
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.user_role'),
            config('permission.column_names.role'),
            config('permission.column_names.user')
        );
    }

    /**
     * 判断是否有权限
     *
     * @param string $permission 权限名称
     * @return bool
     * @throws \Throwable
     */
    public function can(string $permission)
    {
        foreach ($this->cachedRoles() as $role) {
            foreach ($role->cachedPermissions() as $perm) {
                if ($permission == strtolower($perm['name'])) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 缓存用户角色
     *
     * @return mixed
     * @throws \Throwable
     */
    public function cachedRoles()
    {
        $expireTime = config('permission.cache.expiration_time');
        return Cache::remember($this->cacheKey(), $this->roles, $expireTime);
    }

    /**
     * 删除缓存用户角色
     *
     * @return mixed
     */
    public function deleteCachedRoles()
    {
        return Cache::delete($this->cacheKey());
    }

    /**
     * 角色缓存Key
     *
     * @return string
     */
    public function cacheKey()
    {
        return config('permission.cache.role') . $this[$this->pk];
    }

    /**
     * 同步用户角色
     *
     * @param array $roles 角色ID数组
     */
    public function syncRoles(array $roles)
    {
        $this->roles()->sync($roles);
        $this->deleteCachedRoles();
    }

}
