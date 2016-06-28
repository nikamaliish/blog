<?php
namespace models;

abstract class AbstractModel
{
    const DSN = 'mysql:host=localhost;dbname=blog;charset=UTF8';
    /** @var \PDO */
    protected static $connection;
    protected $isNew = true;

    abstract public function getTableName();

    abstract public function getAttributes();

    /**
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * @param boolean $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    public static function getConnection()
    {
        if (is_null(static::$connection)) {
            static::$connection = new \PDO(static::DSN, 'root', '');
        }

        return static::$connection;
    }

    public static function model()
    {
        return new static();
    }

    public function q($query, $params = [])
    {
        $connection = static::getConnection();
        $sth = $connection->prepare($query);
        $sth->execute($params);
        return $sth;
    }

    public function all()
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '`';
        return $this->q($sql)->fetchAll();
    }

    public function one($id)
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE id = :id';
        $result = $this->q($sql, [':id' => $id])->fetch();

        $this->fillModel($result);

        return $this;
    }

    // UPDATE users SET `login` = '23234', `password` = 'zsdfdsfdsf' WHERE `id` = '1'
    public function save()
    {
        $attributes = [];
        $sql_set = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $this->getAttributes())) {
                continue;
            }
            $attributes[':' . $key] = $this->$key;
            $sql_set[] = '`' . $key . '` = :' . $key;
        }

        $sql_set = implode(', ', $sql_set);

        $sql = $this->getIsNew() ? 'INSERT INTO' : 'UPDATE';
        $sql = $sql . " `" . $this->getTableName() . '` SET ' . $sql_set;

        if (!$this->getIsNew()) {
            $sql .=  '  WHERE id = :id';
        }

        if (!$this->q($sql, $attributes)) {
            return false;
        }

        if ($this->getIsNew()) {
            $this->id = static::getConnection()->lastInsertId();
            $this->setIsNew(false);
        }

        return true;
    }


//    DELETE FROM articles WHERE `id` = '1'
    public function delete()
    {
        $sql = 'DELETE FROM `' . $this->getTableName() . '` WHERE id = :id';

        return $this->q($sql, [':id' => $this->id]);
    }


    public function find($params)
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE ';
        $where = [];
        $attributes = [];

        foreach ($params as $key => $value) {
            $where[] = "$key = :$key";
            $attributes[':' . $key] = $value;
        }
        $sql = $sql . implode(' AND ', $where);

        $result = $this->q($sql, $attributes)->fetch();

        if (!$result) {
            return null;
        }

        $this->fillModel($result);

        return $this;
    }

    private function fillModel($result)
    {
        $this->setIsNew(false);

        if (!$result) {
            return;
        }

        foreach ($result as $key => $value) {
            if (!property_exists(static::class, $key) || !in_array($key, $this->getAttributes())) {
                continue;
            }
            $this->$key = $value;
        }
    }
}