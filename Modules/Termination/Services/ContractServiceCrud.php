<?php

namespace Modules\Termination\Services;


use App\Abstracts\Generic\Crud;
use Modules\Termination\Criteria\ContractListCriteria;
use Modules\Termination\Presenters\ContractListPrinterPresenter;
use Modules\Termination\Repositories\ContractRepository;
use Modules\Termination\Validators\ContractValidator;
use Modules\Terminaton\Presenters\ContractListPresenter;

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

    public function getAll(array $filter, $printer = false)
    {
        $this->repository->pushCriteria(new ContractListCriteria($filter));
        return parent::all(false, 0, !$printer ? ContractListPresenter::class : ContractListPrinterPresenter::class);
    }
}