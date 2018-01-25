<?php

namespace App\Service;

use JsonSerializable;

/**
 * Helps doing default repeatable actions in controllers
 */
class ControllerTemplate implements JsonSerializable
{
    private $table;
    public $class;

    public function __construct($class)
    {
        $this->class = $class;
        $this->table = (new $class)->getTable();
    }

    public function view($name)
    {
        return $this->table . '.' . $name;
    }

    public function jsonSerialize() {
        return [
            'class' => $this->class,
            'table' => $this->table,
        ];
    }
}