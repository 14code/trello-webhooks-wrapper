<?php
/**
 * File: Webhook.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

namespace Webhooks\Wrapper;


use Webhooks\Wrapper\Wrapper;

class Webhook
{
    private $id;
    private $active = true;
    private $wrapper;
    private $description = '';
    private $token;
    private $url;
    private $model;
    private $action;

    /**
     * Webhook constructor.
     */
    public function __construct(Wrapper $wrapper)
    {
        $this->wrapper = $wrapper;
        $this->id = md5(time());
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Webhook
     */
    public function setActive(bool $active): Webhook
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Webhook
     */
    public function setDescription(string $description): Webhook
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Webhook
     */
    public function setAction(Action $action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * @param mixed $wrapper
     * @return Webhook
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Webhook
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Webhook
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return Webhook
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return Webhook
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}