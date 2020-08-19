<?php

if (!function_exists('auth')) {

    /**
     * 实例化权限验证类
     *
     * @return \ForeverEson\Permission\Auth
     */
    function auth()
    {
        return \ForeverEson\Permission\Auth::guard();
    }
}

if (!function_exists('password')) {

    /**
     * 密码加密算法
     *
     * @param string $value 需要加密的值
     * @return string
     */
    function password($value)
    {
        $value = sha1('eson_') . md5($value) . md5('_encrypt') . sha1($value);
        return sha1($value);
    }

}

