<?php

namespace Modules\DeadFile\Services;

use App\Abstracts\Generic\Crud;
use Modules\DeadFile\Repositories\DeadFileRepository;
use Modules\DeadFile\Validators\DeadFileValidator;

class DeadFileServiceCrud extends Crud
{
    /**
     * @var DeadFileRepository
     */
    protected $repository;
    /**
     * @var DeadFileValidator
     */
    protected $validator;

    public function __construct(DeadFileRepository $repository, DeadFileValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}