<?php

namespace Webhooks\Wrapper\Trello\Api;

/**
 * Trello Organization API
 * @link https://trello.com/docs/api/organization
 *
 * Not implemented.
 */
class Organization extends \Trello\Api\Organization
{

    /**
     * Boards API
     *
     * @return Organization\Boards
     */
    public function boards()
    {
        return new Organization\Boards($this->client);
    }

}
