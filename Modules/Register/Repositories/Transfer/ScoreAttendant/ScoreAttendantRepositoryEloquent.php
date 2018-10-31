<?php

namespace Modules\Register\Repositories\Transfer\ScoreAttendant;

use Modules\Register\Entities\Transfer\ScoreAttendant\ScoreAttendant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ScoreAttendantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ScoreAttendantRepositoryEloquent extends BaseRepository implements ScoreAttendantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ScoreAttendant::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
