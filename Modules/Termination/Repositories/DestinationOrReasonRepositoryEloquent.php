<?php

namespace Modules\Termination\Repositories;

use Modules\Termination\Entities\DestinationOrReason;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DestinationOrReasonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DestinationOrReasonRepositoryEloquent extends BaseRepository implements DestinationOrReasonRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DestinationOrReason::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
