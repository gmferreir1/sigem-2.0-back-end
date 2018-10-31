<?php

namespace Modules\Register\Services\Transfer\Contract;


use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\Transfer\Contract\ContractRepository;
use Modules\Register\Validators\Transfer\Contract\ContractValidator;

class ContractServiceCrud extends Crud
{
    /**
     * @var ContractRepository
     */
    protected $repository;
    /**
     * @var ContractValidator
     */
    protected $validator;

    public function __construct(ContractRepository $repository, ContractValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}