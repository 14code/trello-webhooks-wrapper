<?php
/**
 * File: Client.php in trello-webhooks-wrapper
 * Author: ___AUTHOR___
 * Date: 30.11.18
 * Version: ___VERSION___
 */

namespace Webhooks\Wrapper\Trello;


class Client extends \Trello\Client
{

    /**
     * Get an API by name
     *
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws InvalidArgumentException if the requested api does not exist
     */
    public function api($name)
    {
        if ($name == "organization") {
            $api = new Api\Organization($this);
            return $api;
        }
        $api = parent::api($name);
        return $api;
    }

}