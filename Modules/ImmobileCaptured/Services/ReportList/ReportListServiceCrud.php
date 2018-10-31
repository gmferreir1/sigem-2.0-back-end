<?php

namespace Modules\ImmobileCaptured\Services\ReportList;


use App\Abstracts\Generic\Crud;
use Modules\ImmobileCaptured\Repositories\ReportList\ReportListRepository;
use Modules\ImmobileCaptured\Validators\ReportList\ReportListValidator;

class ReportListServiceCrud extends Crud
{
    /**
     * @var ReportListRepository
     */
    protected $repository;
    /**
     * @var ReportListValidator
     */
    protected $validator;

    public function __construct(ReportListRepository $repository, ReportListValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}