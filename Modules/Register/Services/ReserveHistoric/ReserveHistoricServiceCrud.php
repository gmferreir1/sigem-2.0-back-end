<?php

namespace Modules\Register\Services\ReserveHistoric;

use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\ReserveHistoric\ReserveHistoricRepository;
use Modules\Register\Validators\ReserveHistoric\ReserveHistoricValidator;

class ReserveHistoricServiceCrud extends Crud
{
    /**
     * @var ReserveHistoricRepository
     */
    protected $repository;
    /**
     * @var ReserveHistoricValidator
     */
    protected $validator;

    public function __construct(ReserveHistoricRepository $repository, ReserveHistoricValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

}