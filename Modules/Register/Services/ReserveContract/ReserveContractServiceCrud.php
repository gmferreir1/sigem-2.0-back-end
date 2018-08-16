<?php

namespace Modules\Register\Services\ReserveContract;

use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\ReserveContract\ReserveContractRepository;
use Modules\Register\Validators\ReserveContract\ReserveContractValidator;

class ReserveContractServiceCrud extends Crud
{
    /**
     * @var ReserveContractRepository
     */
    protected $repository;
    /**
     * @var ReserveContractValidator
     */
    protected $validator;

    public function __construct(ReserveContractRepository $repository, ReserveContractValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}