<?php

namespace Modules\User\Services;


class UserService
{
    /**
     * @var UserServiceCrud
     */
    private $serviceCrud;

    public function __construct(UserServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    public function getNameById(int $id)
    {
        $userData = $this->serviceCrud->find($id);

        return "$userData->name $userData->last_name";
    }
}