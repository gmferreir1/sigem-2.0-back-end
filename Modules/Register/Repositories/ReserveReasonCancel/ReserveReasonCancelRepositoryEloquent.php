<?php

namespace Modules\Register\Repositories\ReserveReasonCancel;

use Modules\Register\Entities\ReserveReasonCancel\ReserveReasonCancel;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RegisterReasonCancelRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReserveReasonCancelRepositoryEloquent extends BaseRepository implements ReserveReasonCancelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReserveReasonCancel::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
