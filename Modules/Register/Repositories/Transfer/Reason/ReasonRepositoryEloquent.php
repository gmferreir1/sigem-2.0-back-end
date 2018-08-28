<?php

namespace Modules\Register\Repositories\Transfer\Reason;

use Modules\Register\Entities\Transfer\Reason\Reason;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ReasonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReasonRepositoryEloquent extends BaseRepository implements ReasonRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reason::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
