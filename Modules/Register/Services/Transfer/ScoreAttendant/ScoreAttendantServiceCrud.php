<?php

namespace Modules\Register\Services\Transfer\ScoreAttendant;


use App\Abstracts\Generic\Crud;
use Modules\Regisrer\Repositories\Transfer\ScoreAttendant\ScoreAttendantRepository;
use Modules\Register\Validators\Transfer\ScoreAttendantValidator;

class ScoreAttendantServiceCrud extends Crud
{
    /**
     * @var ScoreAttendantRepository
     */
    protected $repository;
    /**
     * @var ScoreAttendantValidator
     */
    protected $validator;

    public function __construct(ScoreAttendantRepository $repository, ScoreAttendantValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}