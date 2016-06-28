<?php
namespace models;

use models\Role;

class User extends AbstractModel
{
    public $id;
    public $login;
    public $password;
    public $role;

    public function getTableName()
    {
        return 'users';
    }

    public function getAttributes()
    {
        return ['id', 'login', 'password', 'role'];
    }

    public static function getPasswordHash($string)
    {
        return md5(md5($string));
    }

    /**
     * @return bool
     */
    public static function isGuest()
    {
        return (!isset($_SESSION) || !isset($_SESSION['user']));
    }

    public function hasPriv($priv)
    {
        $model = Role::getRolePerms($this->id);
        return isset($model->privs[$priv]);
    }
}

