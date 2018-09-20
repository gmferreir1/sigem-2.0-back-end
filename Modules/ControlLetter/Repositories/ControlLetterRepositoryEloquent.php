<?php

namespace Modules\ControlLetter\Repositories;

use Modules\ControlLetter\Entities\ControlLetter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ControlLetterRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ControlLetterRepositoryEloquent extends BaseRepository implements ControlLetterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ControlLetter::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
