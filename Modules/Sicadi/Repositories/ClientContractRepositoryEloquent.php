<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\ClientContract;

/**
 * Class SClientContractRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class ClientContractRepositoryEloquent extends BaseRepository implements ClientContractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientContract::class;
    }

    public function truncate()
    {
        ClientContract::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
