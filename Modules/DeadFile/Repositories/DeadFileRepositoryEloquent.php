<?php

namespace Modules\DeadFile\Repositories;

use Modules\DeadFile\Entities\DeadFile;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DeadFileRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DeadFileRepositoryEloquent extends BaseRepository implements DeadFileRepository
{

    protected $fieldSearchable = [
        'contract',
        'file',
        'cashier'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DeadFile::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
