<?php

namespace Modules\SystemAlert\Services;

use App\Abstracts\Generic\Crud;
use Modules\SystemAlert\Repositories\SystemAlertRepository;

class SystemAlertServiceCrud extends Crud
{

    /**
     * @var SystemAlertRepository
     */
    protected $repository;
    /**
     * @var null
     */
    protected $validator;

    public function __construct(SystemAlertRepository $repository, $validator = null)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}