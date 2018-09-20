<?php

namespace Modules\ControlLetter\Services;

use App\Abstracts\Generic\Crud;
use Modules\ControlLetter\Repositories\ControlLetterRepository;
use Modules\ControlLetter\Validators\ControlLetterValidator;

class ControlLetterServiceCrud extends Crud
{
    /**
     * @var ControlLetterRepository
     */
    protected $repository;
    /**
     * @var null
     */
    protected $validator;

    public function __construct(ControlLetterRepository $repository, ControlLetterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}