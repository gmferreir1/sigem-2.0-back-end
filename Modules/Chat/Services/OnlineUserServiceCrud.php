<?php

namespace Modules\Chat\Services;


use App\Abstracts\Generic\Crud;
use Modules\Chat\Repositories\OnlineUserRepository;
use Modules\Chat\Validators\OnlineUserValidator;

class OnlineUserServiceCrud extends Crud
{
    /**
     * @var OnlineUserRepository
     */
    protected $repository;
    /**
     * @var OnlineUserValidator
     */
    protected $validator;

    public function __construct(OnlineUserRepository $repository, OnlineUserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}