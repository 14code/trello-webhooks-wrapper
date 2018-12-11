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
    private $arguments = [];
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
    public function setName(string $name): Action
    {
        $this->name = $name;
        return $this;
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
    public function setType(string $type): Action
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param mixed $arguments
     */
    public function setArguments(array $arguments): Action
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @param string $argumentName
     * @param void $argumentValue
     */
    public function addArgument(string $argumentName, $argumentValue): Action
    {
        $this->arguments[$argumentName] = $argumentValue;
        return $this;
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
    public function setFunction(\Closure $function): Action
    {
        $this->function = $function;
        return $this;
    }

    public function execute($posted = null)
    {
        $function = $this->getFunction();
        $arguments = $this->getArguments();
        $arguments['data'] = $posted;
        $arguments['this'] = $this;
        return call_user_func_array($function, $arguments);
    }

    public function verify($actionData)
    {
        if ($this->getType() == $actionData->display->translationKey) {
            return true;
        }
        return false;
    }
}