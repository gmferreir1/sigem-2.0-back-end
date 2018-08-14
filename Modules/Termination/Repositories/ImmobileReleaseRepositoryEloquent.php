<?php

namespace Modules\Termination\Repositories;

use Modules\Termination\Entities\ImmobileRelease;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ImmobileReleaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ImmobileReleaseRepositoryEloquent extends BaseRepository implements ImmobileReleaseRepository
{

    protected $fieldSearchable = [
        'immobile_code'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImmobileRelease::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
