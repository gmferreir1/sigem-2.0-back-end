<?php

namespace Modules\Register\Repositories\Transfer\Contract;

use Modules\Register\Entities\Transfer\Contract\Contract;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ContractRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractRepositoryEloquent extends BaseRepository implements ContractRepository
{
    protected $fieldSearchable = [
        'contract'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contract::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
