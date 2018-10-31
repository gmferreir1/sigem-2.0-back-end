<?php

namespace Modules\Register\Repositories\ReserveContract;

use Modules\Register\Entities\ReserveContract\ReserveContract;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ReserveContractRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReserveContractRepositoryEloquent extends BaseRepository implements ReserveContractRepository
{

    protected $fieldSearchable = [
        'contract',
        'immobile_code',
        'address',
        'client_name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReserveContract::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
