<?php

namespace Modules\Register\Services\ReserveReasonCancel;

use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\ReserveReasonCancel\ReserveReasonCancelRepository;
use Modules\Register\Validators\ReserveReasonCancel\ReserveReasonCancelValidator;

class ReserveReasonCancelServiceCrud extends Crud
{

    /**
     * @var ReserveReasonCancelRepository
     */
    protected $repository;
    /**
     * @var ReserveReasonCancelValidator
     */
    protected $validator;

    public function __construct(ReserveReasonCancelRepository $repository, ReserveReasonCancelValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}