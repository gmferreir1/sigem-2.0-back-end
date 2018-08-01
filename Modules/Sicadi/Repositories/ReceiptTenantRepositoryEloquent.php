<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Sicadi\Entities\ReceiptTenant;

/**
 * Class SReceiptTenantRepositoryEloquent
 * @package namespace Modules\ApiSicadi\Repositories;
 */
class ReceiptTenantRepositoryEloquent extends BaseRepository implements ReceiptTenantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReceiptTenant::class;
    }


    public function truncate()
    {
        ReceiptTenant::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
