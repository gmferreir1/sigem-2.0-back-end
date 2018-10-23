<?php

namespace Modules\SystemAlert\Repositories;

use Modules\SystemAlert\Entities\SystemAlert;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SystemAlertRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SystemAlertRepositoryEloquent extends BaseRepository implements SystemAlertRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SystemAlert::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
