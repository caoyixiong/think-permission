<?php


namespace ForeverEson\Permission;


class Auth
{
    /**
     * @var mixed 用户model
     */
    protected $userClass;

    /**
     * @var mixed 角色model
     */
    protected $roleClass;

    /**
     * @var mixed 权限model
     */
    protected $permissionClass;

    /**
     * @var mixed 用户缓存Key
     */
    protected $cacheKey;


    public function __construct()
    {
        $this->setUserClass(config('permission.models.user'));
        $this->setRoleClass(config('permission.models.role'));
        $this->setPermissionClass(config('permission.models.permission'));
        $this->setCacheKey(config('permission.cache.user'));
    }

    /**
     * 检查登录
     *
     * @return bool|void
     */
    public function check()
    {
        if (is_null($this->user())) return false; // 用户session为空返回false
        if ($this->expireTime() !== true && time() > $this->expireTime()) return false; // session过期返回false
        return true;
    }

    /**
     * 判断是否游客
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * 登录用户信息
     *
     * @return mixed
     */
    public function user()
    {
        return session($this->cacheKey . '.user');
    }

    /**
     * session过期时间
     *
     * @return mixed
     */
    public function expireTime()
    {
        return session($this->cacheKey . '.expire_time');
    }

    /**
     * 用户ID
     *
     * @return mixed
     */
    public function id()
    {
        return $this->user()->id;
    }

    /**
     * 实例化验证类
     *
     * @return Auth
     */
    public static function guard()
    {
        return new self();
    }

    /**
     * 登录验证
     *
     * @param string $username
     * @param string $password
     * @param int $remember
     * @return bool
     */
    public function login(string $username, string $password, int $remember)
    {
        $user = $this->getUserClass()->where(['name' => $username])->find();
        if (!$user) return false; // 用户不存在返回false
        if ($user->password != password($password)) return false; // 密码错误返回false

        $user->last_login_time = date('Y-m-d H:i:s');
        $user->save();
        $store = ['user' => $user, 'expire_time' => $remember == 1 ? true : time() + 7200];
        session($this->cacheKey, $store);
        return true; // 登录成功返回true
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session($this->cacheKey, null);
    }

    /**
     * 实例化用户model
     *
     * @return object|\think\App
     */
    public function getUserClass()
    {
        return app(config('permission.models.user'));
    }

    /**
     * 设置用户model
     *
     * @param $userClass
     */
    public function setUserClass($userClass)
    {
        $this->userClass = $userClass;
    }

    /**
     * 实例化权限model
     *
     * @return object|\think\App
     */
    public function getPermissionClass()
    {
        return app($this->permissionClass);
    }

    /**
     * 设置权限model
     *
     * @param $permissionClass
     */
    public function setPermissionClass($permissionClass)
    {
        $this->permissionClass = $permissionClass;
    }

    /**
     * 实例化角色model
     *
     * @return object|\think\App
     */
    public function getRoleClass()
    {
        return app($this->roleClass);
    }

    /**
     * 设置角色model
     *
     * @param $roleClass
     */
    public function setRoleClass($roleClass)
    {
        $this->roleClass = $roleClass;
    }

    /**
     * 获取用户缓存Key
     *
     * @return mixed
     */
    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    /**
     * 设置用户缓存Key
     *
     * @param $cacheKey
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;
    }

}
