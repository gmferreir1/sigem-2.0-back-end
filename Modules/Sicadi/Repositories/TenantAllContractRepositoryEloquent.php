<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\TenantAllContract;

/**
 * Class STennantAllContractRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class TenantAllContractRepositoryEloquent extends BaseRepository implements TenantAllContractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TenantAllContract::class;
    }

    public function truncate()
    {
        TenantAllContract::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
