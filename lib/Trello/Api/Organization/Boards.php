<?php

namespace Webhooks\Wrapper\Trello\Api\Organization;

use \Trello\Api\AbstractApi;

/**
 * Trello Member Boards API
 * @link https://trello.com/docs/api/organization
 *
 * Fully implemented.
 */
class Boards extends AbstractApi
{
    protected $path = 'organizations/#id#/boards';

    /**
     * Get boads related to a given organization
     * @link https://trello.com/docs/api/organization/#get-1-organizations-idorganization-or-username-boards
     *
     * @param string $id     the organization's id or username
     * @param array  $params optional parameters
     *
     * @return array
     */
    public function all($id, array $params = array())
    {
        return $this->get($this->getPath($id), $params);
    }

}
