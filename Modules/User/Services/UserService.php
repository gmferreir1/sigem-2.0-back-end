<?php

namespace Modules\User\Services;


use Illuminate\Support\Facades\Auth;

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

    public function getNameById(int $id = null)
    {
        $idUSer = !$id ? Auth::user()->id : $id;

        $userData = $this->serviceCrud->find($idUSer);

        return "$userData->name $userData->last_name";
    }
}