<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\ImmobileVisit;

/**
 * Class SImmobileVisitRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class ImmobileVisitRepositoryEloquent extends BaseRepository implements ImmobileVisitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImmobileVisit::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function truncate()
    {
        ImmobileVisit::truncate();
    }
}
