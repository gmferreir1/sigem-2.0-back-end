<?php

namespace Modules\Termination\Repositories;

use Modules\Termination\Entities\Score;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ScoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ScoreRepositoryEloquent extends BaseRepository implements ScoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Score::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
