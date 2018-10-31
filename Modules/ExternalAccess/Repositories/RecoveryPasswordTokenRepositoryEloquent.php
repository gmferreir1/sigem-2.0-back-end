<?php

namespace Modules\ExternalAccess\Repositories;

use Modules\ExternalAccess\Entities\RecoveryPasswordToken;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RecoveryPasswordTokenRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RecoveryPasswordTokenRepositoryEloquent extends BaseRepository implements RecoveryPasswordTokenRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RecoveryPasswordToken::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
