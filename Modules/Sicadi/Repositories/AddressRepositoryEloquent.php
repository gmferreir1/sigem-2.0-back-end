<?php

namespace Modules\Sicadi\Repositories;

use Modules\Sicadi\Entities\Address;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AddressRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AddressRepositoryEloquent extends BaseRepository implements AddressRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Address::class;
    }

    public function truncate()
    {
        Address::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
