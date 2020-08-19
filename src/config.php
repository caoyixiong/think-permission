<?php

return [

    'models' => [

        /*
         * 用户model
         */
        'user' => ForeverEson\Permission\Models\User::class,

        /*
         * 角色model
         */
        'role' => ForeverEson\Permission\Models\Role::class,

        /*
         * 权限model
         */
        'permission' => ForeverEson\Permission\Models\Permission::class,

    ],

    'table_names' => [

        /*
         * 用户表名
         */
        'user' => 'user',

        /*
         * 角色表名
         */
        'role' => 'role',

        /*
         * 权限表名
         */
        'permission' => 'permission',

        /*
         * 用户角色表名
         */
        'user_role' => 'user_role',

        /*
         * 角色权限表名
         */
        'role_permission' => 'role_permission',

    ],

    'column_names' => [

        /*
         * 用户表外键关联字段
         */
        'user' => 'user_id',

        /*
         * 角色表外键关联字段
         */
        'role' => 'role_id',

        /*
         * 权限表外键关联字段
         */
        'permission' => 'permission_id',

    ],

    'cache' => [

        /*
         * 缓存时间
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * 角色Cache缓存Key
         */

        'role' => 'forever.eson.permission.cache.role',

        /*
         * 权限Cache缓存Key
         */
        'permission' => 'forever.eson.permission.cache.permission',

        /*
         * 用户Session缓存Key
         */
        'user' => 'forever.eson.permission.cache.user',

    ],
];
