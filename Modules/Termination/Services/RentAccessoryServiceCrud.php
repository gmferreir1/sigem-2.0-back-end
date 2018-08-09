<?php

namespace Modules\Termination\Services;

use App\Abstracts\Generic\Crud;
use Modules\Termination\Repositories\RentAccessoryRepository;

class RentAccessoryServiceCrud extends Crud
{
    /**
     * @var RentAccessoryRepository
     */
    protected $repository;
    /**
     * @var null
     */
    protected $validator;

    public function __construct(RentAccessoryRepository $repository, $validator = null)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}