<?php


namespace ForeverEson\Permission\Contracts;


interface Role
{
    public function permissions();

    public function users();
}
