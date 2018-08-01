<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\ImmobileType;

/**
 * Class SImmobileTypeRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class ImmobileTypeRepositoryEloquent extends BaseRepository implements ImmobileTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImmobileType::class;
    }

    public function truncate()
    {
        ImmobileType::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
