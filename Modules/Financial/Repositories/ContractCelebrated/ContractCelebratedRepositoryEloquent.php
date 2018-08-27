<?php

namespace Modules\Financial\Repositories\ContractCelebrated;

use Modules\Financial\Entities\ContractCelebrated\ContractCelebrated;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ContractCelebratedRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractCelebratedRepositoryEloquent extends BaseRepository implements ContractCelebratedRepository
{

    protected $fieldSearchable = [
        'contract',
        'immobile_code',
        'address',
        'neighborhood',
        'owner_name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContractCelebrated::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
