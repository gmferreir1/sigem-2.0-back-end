<?php

namespace Modules\ExternalAccess\Services;


use App\Abstracts\Generic\Crud;
use Modules\ExternalAccess\Repositories\RecoveryPasswordTokenRepository;

class RecoveryPasswordTokenServiceCrud extends Crud
{
    /**
     * @var RecoveryPasswordTokenRepository
     */
    protected $repository;
    /**
     * @var null
     */
    protected $validator;

    public function __construct(RecoveryPasswordTokenRepository $repository, $validator = null)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}