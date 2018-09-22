<?php

namespace Modules\Register\Services\ReserveSendLetter;


use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\ReserveSendLetter\ReserveSendLetterRepository;
use Modules\Register\Validators\ReserveSendLetter\ReserveSendLetterValidator;

class ReserveSendLetterServiceCrud extends Crud
{
    /**
     * @var ReserveSendLetterRepository
     */
    protected $repository;
    /**
     * @var ReserveSendLetterValidator
     */
    protected $validator;

    public function __construct(ReserveSendLetterRepository $repository, ReserveSendLetterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}