<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\Visit;
/**
 * Class SVisitRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class VisitRepositoryEloquent extends BaseRepository implements VisitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Visit::class;
    }

    public function truncate()
    {
        Visit::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
