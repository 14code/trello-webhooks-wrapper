<?php
/**
 * File: Action.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

namespace Webhooks\Wrapper;


class Action
{
    private $name = '';
    private $type = '';
    private $target;
    private $function;

    /**
     * Action constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget(Model $target): void
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction(\Closure $function): void
    {
        $this->function = $function;
    }

    public function execute()
    {
        $function = $this->getFunction();
        return $function();
    }
}