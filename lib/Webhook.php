<?php
/**
 * File: Webhook.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

namespace Webhooks\Wrapper;


use Webhooks\Wrapper\Service;

class Webhook
{
    private $id;
    private $active = true;
    private $description = '';
    private $service;
    private $token;
    private $url;
    private $model;
    private $action;
    private $conditions = [];

    /**
     * Webhook constructor.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
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
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param array $conditions
     * @return Webhook
     */
    public function setConditions(array $conditions): Webhook
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @param array $conditions
     * @return Webhook
     */
    public function addCondition($condition): Webhook
    {
        array_push($this->conditions, $condition);
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
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     * @return Webhook
     */
    public function setService($service)
    {
        $this->service = $service;
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

    /**
     * @return Webhook
     */
    public function existsOnService()
    {
        $token = $this->getToken();
        try {
            $this->service->getWebhook($token);
        } catch (\Trello\Exception\RuntimeException $e) {
            return false;
        }
        return true;
    }

    /**
     * @return Webhook
     */
    public function pullFromService()
    {
        if ($this->existsOnService()) {
            $token = $this->getToken();
            $webhook = $this->service->getWebhook($token);
            $this->setActive($webhook['active']);
            $this->setModel($webhook['idModel']);
            $this->setDescription($webhook['description']);
            $this->setUrl($webhook['callbackURL']);
        }
        return $this;
    }

    /**
     * @return Webhook
     */
    public function pushToService()
    {
        if ($this->existsOnService()) {
            $token = $this->getToken();
            $parameters = [
                'active' => $this->isActive(),
                'idModel' => $this->getModel(),
                'description' => $this->getDescription(),
                'callbackURL' => $this->getUrl()

            ];
            $webhook = $this->service->updateWebhook($token, $parameters);
        }
    }

    public function verifyModel($modelData)
    {
        if ($modelData->id == $this->getModel()) {
            return true;
        }
        return false;
    }

    public function verify($posted)
    {
        $model = $posted->model;
        if ($this->verifyModel($model)) {
            foreach ($this->getConditions() as $condition) {
                if (!call_user_func_array($condition, [$this, $posted])) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function run($json)
    {
        if ($this->isActive() && is_object($this->action)
                && ($this->action instanceof Action)) {

            $posted = json_decode($json);
            if ($this->verify($posted)) {
                $action = $posted->action;
                return $this->action->execute($action->data);
            }

        }
    }
}