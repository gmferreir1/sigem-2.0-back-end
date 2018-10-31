<?php

namespace Modules\SystemGoal\Repositories;

use Modules\SystemGoal\Entities\SystemGoal;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SystemGoalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SystemGoalRepositoryEloquent extends BaseRepository implements SystemGoalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SystemGoal::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
