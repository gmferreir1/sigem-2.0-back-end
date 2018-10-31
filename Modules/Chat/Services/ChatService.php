<?php

namespace Modules\Chat\Services;


class ChatService
{
    /**
     * @var OnlineUserServiceCrud
     */
    private $onlineUserServiceCrud;

    public function __construct(OnlineUserServiceCrud $onlineUserServiceCrud)
    {
        $this->onlineUserServiceCrud = $onlineUserServiceCrud;
    }

    /**
     * Verifica se o usuário esta online
     * @param int $userId
     * @return bool
     */
    public function checkIsOnline(int $userId) : bool
    {
        $check = $this->onlineUserServiceCrud->findWhere(['user_id' => $userId]);

        if (!count($check) || !$check[0]['online']) {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @param string $sortBy
     * @return mixed
     */
    public function sort(array $data, string $sortBy)
    {
        $collection = collect($data);
        return $collection->sortBy('name')->values()->all();
    }
}