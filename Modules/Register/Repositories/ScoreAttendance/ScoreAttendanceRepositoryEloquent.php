<?php

namespace Modules\Register\Repositories\ScoreAttendances;

use Modules\Register\Entities\ScoreAttendance\ScoreAttendance;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ScoreAttendanceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ScoreAttendanceRepositoryEloquent extends BaseRepository implements ScoreAttendanceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ScoreAttendance::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
