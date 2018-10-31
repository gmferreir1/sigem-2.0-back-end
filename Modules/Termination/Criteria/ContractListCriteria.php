<?php

namespace Modules\Termination\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ContractListCriteria.
 *
 * @package namespace App\Criteria;
 */
class ContractListCriteria implements CriteriaInterface
{

    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {

        if (!$this->filter['date_conclusion']) {
            return $model->whereIn('status', $this->filter['status'])
                ->whereIn('type_register', $this->filter['type_register'])
                ->whereIn('rp_per_inactive', $this->filter['responsible'])
                ->orderBy($this->filter['sort_by'], $this->filter['sort_order'])
                ->whereBetween('termination_date', [$this->filter['init_date'], $this->filter['end_date']]);
        }

        if ($this->filter['date_conclusion']) {
            return $model->whereIn('status', $this->filter['status'])
                ->whereIn('type_register', $this->filter['type_register'])
                ->whereIn('rp_per_inactive', $this->filter['responsible'])
                ->orderBy($this->filter['sort_by'], $this->filter['sort_order'])
                ->whereBetween('end_process', [$this->filter['init_date'], $this->filter['end_date']]);
        }
    }
}
