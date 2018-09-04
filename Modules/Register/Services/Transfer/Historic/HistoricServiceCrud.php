<?php


namespace Modules\Register\Services\Transfer\Historic;


use App\Abstracts\Generic\Crud;
use Modules\Register\Repositories\Transfer\Historic\HistoricRepository;
use Modules\Register\Validators\Transfer\Historic\HistoricValidator;

class HistoricServiceCrud extends Crud
{
    /**
     * @var HistoricRepository
     */
    protected $repository;
    /**
     * @var HistoricValidator
     */
    protected $validator;

    public function __construct(HistoricRepository $repository, HistoricValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}