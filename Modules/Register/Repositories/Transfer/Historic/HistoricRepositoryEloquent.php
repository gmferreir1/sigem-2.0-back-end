<?php

namespace Modules\Register\Repositories\Transfer\Historic;

use Modules\Register\Entities\Transfer\Historic\Historic;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class HistoricRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HistoricRepositoryEloquent extends BaseRepository implements HistoricRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Historic::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
