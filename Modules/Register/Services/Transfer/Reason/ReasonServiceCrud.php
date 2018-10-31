<?php

namespace Modules\Register\Services\Transfer\Reason;


use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\Transfer\Reason\ReasonRepository;
use Modules\Register\Validators\Transfer\Reason\ReasonValidator;

class ReasonServiceCrud extends Crud
{
    /**
     * @var ReasonRepository
     */
    protected $repository;
    /**
     * @var ReasonValidator
     */
    protected $validator;

    public function __construct(ReasonRepository $repository, ReasonValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}