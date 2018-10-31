<?php

namespace Modules\ManagerAction\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\ManagerAction\Entities\ActionDatabase;

/**
 * Class ActionDatabaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ActionDatabaseRepositoryEloquent extends BaseRepository implements ActionDatabaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ActionDatabase::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
