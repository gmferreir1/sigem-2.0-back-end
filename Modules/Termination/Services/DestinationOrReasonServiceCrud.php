<?php

namespace Modules\Termination\Services;


use App\Abstracts\Generic\Crud;
use Modules\Termination\Repositories\DestinationOrReasonRepository;
use Modules\Termination\Validators\DestinationOrReasonValidator;

class DestinationOrReasonServiceCrud extends Crud
{

    /**
     * @var DestinationOrReasonRepository
     */
    protected $repository;
    /**
     * @var DestinationOrReasonValidator
     */
    protected $validator;

    public function __construct(DestinationOrReasonRepository $repository, DestinationOrReasonValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}