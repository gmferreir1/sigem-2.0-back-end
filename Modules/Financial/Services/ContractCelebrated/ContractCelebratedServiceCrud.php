<?php

namespace Modules\Financial\Services\ContractCelebrated;

use App\Abstracts\Generic\Crud;
use Modules\Financial\Repositories\ContractCelebrated\ContractCelebratedRepository;
use Modules\Validators\ContractCelebrated\ContractCelebratedValidator;

class ContractCelebratedServiceCrud extends Crud
{
    /**
     * @var ContractCelebratedRepository
     */
    protected $repository;
    /**
     * @var ContractCelebratedValidator
     */
    protected $validator;

    public function __construct(ContractCelebratedRepository $repository, ContractCelebratedValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}