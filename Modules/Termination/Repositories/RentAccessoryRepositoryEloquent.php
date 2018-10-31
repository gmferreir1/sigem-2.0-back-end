<?php

namespace Modules\Termination\Repositories;

use Modules\Termination\Entities\RentAccessory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RentAccessoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RentAccessoryRepositoryEloquent extends BaseRepository implements RentAccessoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RentAccessory::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
