<?php

namespace Modules\Chat\Services;


use App\Abstracts\Generic\Crud;
use Modules\Chat\Repositories\MessageRepository;
use Modules\Chat\Validators\MessageValidator;

class MessageServiceCrud extends Crud
{
    /**
     * @var MessageRepository
     */
    protected $repository;
    /**
     * @var MessageValidator
     */
    protected $validator;

    public function __construct(MessageRepository $repository, MessageValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}