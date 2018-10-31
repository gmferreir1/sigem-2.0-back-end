<?php

namespace Modules\ImmobileCaptured\Repositories\ReportList;

use Modules\ImmobileCaptured\Entities\ReportList\ReportList;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ReportListRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReportListRepositoryEloquent extends BaseRepository implements ReportListRepository
{
    protected $fieldSearchable = [
        'owner',
        'immobile_code',
        'address',
        'neighborhood',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReportList::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
