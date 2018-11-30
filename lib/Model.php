<?php
/**
 * File: Model.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 25.11.18
 * Version: ___VERSION___
 */

namespace Webhooks\Wrapper;


class Model
{
    private $name = '';
    private $id = '';
    private $parent = '';
    private $children = [];
    private $type = '';

    public function __construct($name, $id, $type, $parent = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getParentId()
    {
        return $this->parent;
    }

}