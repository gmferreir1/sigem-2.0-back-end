<?php

namespace Modules\Sicadi\Repositories;

use Modules\Sicadi\Entities\ReceiptTenantComplete;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SReceiptTenantCompleteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReceiptTenantCompleteRepositoryEloquent extends BaseRepository implements ReceiptTenantCompleteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReceiptTenantComplete::class;
    }

    public function truncate()
    {
        ReceiptTenantComplete::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
