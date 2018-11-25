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
    private $type = '';

    public function __construct($name, $id, $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }
}