<?php
namespace models;

class Post extends AbstractModel
{
    public $id;
    public $title;
    public $content;
    public $date;

    public function getTableName()
    {
        return 'articles';
    }

    public function getAttributes()
    {
        return ['id', 'title', 'content'];
    }
}