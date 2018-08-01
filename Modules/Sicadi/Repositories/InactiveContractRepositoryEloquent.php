<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\InactiveContract;

/**
 * Class SInactiveContractRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class InactiveContractRepositoryEloquent extends BaseRepository implements InactiveContractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InactiveContract::class;
    }

    public function truncate()
    {
        InactiveContract::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
