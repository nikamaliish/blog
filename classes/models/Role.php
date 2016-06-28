<?php
namespace models;

class Role extends AbstractModel
{
    public $id;
    public $privs;

    public function getTableName()
    {
        return '';
    }

    public function getAttributes()
    {
        return ['post_view', 'post_edit', 'post_delete', 'post_new'];
    }

    public function __construct()
    {
        $this->privs = array();
    }

    public static function getRolePerms($role_id)
    {
        $role = Role::model();
        $role->id = $role_id;

        $sql = "SELECT `name` FROM `roles&privileges` JOIN `privileges` ON id_privs = id
                WHERE id_role = :id";

        $result = $role->q($sql, [':id' => $role_id])->fetchall();

        foreach ($result as $key => $value) {

            foreach ($value as $key2 => $value2) {
                if (!in_array($key2, static::getAttributes())) {
                    continue;
                }
                $role->privs[$value2] = true;
            }
        }
        return $role;
    }
}

