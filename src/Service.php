<?php

namespace ForeverEson\Permission;

use think\Service as thinkService;

class Service extends thinkService
{

    public function register()
    {
        $this->commands([
            'permission:table' => '\\ForeverEson\Permission\\Commands\\Table',
        ]);
    }

}
