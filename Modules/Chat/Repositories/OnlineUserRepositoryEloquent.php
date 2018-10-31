<?php

namespace Modules\Chat\Repositories;

use Modules\Chat\Entities\OnlineUser;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class OnlineUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OnlineUserRepositoryEloquent extends BaseRepository implements OnlineUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OnlineUser::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
