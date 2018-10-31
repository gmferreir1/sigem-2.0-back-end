<?php

namespace Modules\Register\Repositories\ReserveSendLetter;

use Modules\Register\Entities\ReserveSendLetter\ReserveSendLetter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ReserveSendLetterRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReserveSendLetterRepositoryEloquent extends BaseRepository implements ReserveSendLetterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ReserveSendLetter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
