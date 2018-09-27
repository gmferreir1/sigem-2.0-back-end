<?php

namespace Modules\SystemGoal\Services;


use App\Abstracts\Generic\Crud;
use Modules\SystemGoal\Repositories\SystemGoalRepository;
use Modules\SystemGoal\Validators\SystemGoalValidator;

class SystemGoalServiceCrud extends Crud
{
    /**
     * @var SystemGoalRepository
     */
    protected $repository;
    /**
     * @var SystemGoalValidator
     */
    protected $validator;

    public function __construct(SystemGoalRepository $repository, SystemGoalValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}