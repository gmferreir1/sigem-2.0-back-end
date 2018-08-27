<?php

namespace Modules\Register\Repositories\ReserveHistoric;

use Modules\Register\Entities\ReserveHistoric\ReserveHistoric;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class HistoricRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReserveHistoricRepositoryEloquent extends BaseRepository implements ReserveHistoricRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReserveHistoric::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
