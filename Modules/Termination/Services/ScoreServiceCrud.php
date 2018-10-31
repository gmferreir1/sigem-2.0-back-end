<?php

namespace Modules\Termination\Services;

use App\Abstracts\Generic\Crud;
use Modules\Termination\Repositories\ScoreRepository;
use Modules\Termination\Validators\ScoreValidator;

class ScoreServiceCrud extends Crud
{
    /**
     * @var ScoreRepository
     */
    protected $repository;
    /**
     * @var ScoreValidator
     */
    protected $validator;

    public function __construct(ScoreRepository $repository, ScoreValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}