<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\Immobile;

/**
 * Class SImmobileRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class ImmobileRepositoryEloquent extends BaseRepository implements ImmobileRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Immobile::class;
    }

    public function truncate()
    {
        Immobile::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
