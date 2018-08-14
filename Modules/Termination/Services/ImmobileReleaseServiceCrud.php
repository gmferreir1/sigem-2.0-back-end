<?php

namespace Modules\Termination\Services;


use App\Abstracts\Generic\Crud;
use Modules\Termination\Repositories\ImmobileReleaseRepository;
use Modules\Termination\Validators\ImmobileReleaseValidator;

class ImmobileReleaseServiceCrud extends Crud
{
    /**
     * @var ImmobileReleaseRepository
     */
    protected $repository;
    /**
     * @var ImmobileReleaseValidator
     */
    protected $validator;

    public function __construct(ImmobileReleaseRepository $repository, ImmobileReleaseValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}