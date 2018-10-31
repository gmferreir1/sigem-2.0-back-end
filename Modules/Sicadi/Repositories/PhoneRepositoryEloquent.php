<?php

namespace Modules\Sicadi\Repositories;

use Modules\Sicadi\Entities\Phone;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SPhoneRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PhoneRepositoryEloquent extends BaseRepository implements PhoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Phone::class;
    }

    public function truncate()
    {
        Phone::truncate();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
