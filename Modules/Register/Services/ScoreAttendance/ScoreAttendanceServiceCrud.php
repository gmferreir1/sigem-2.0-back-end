<?php

namespace Modules\Register\Services\ScoreAttendance;


use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\ScoreAttendances\ScoreAttendanceRepository;
use Modules\Register\Validators\ScoreAttendance\ScoreAttendanceValidator;

class ScoreAttendanceServiceCrud extends Crud
{
    /**
     * @var ScoreAttendanceRepository
     */
    protected $repository;
    /**
     * @var ScoreAttendanceValidator
     */
    protected $validator;

    public function __construct(ScoreAttendanceRepository $repository, ScoreAttendanceValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}