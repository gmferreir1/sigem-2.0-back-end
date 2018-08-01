<?php

namespace Modules\Sicadi\Repositories;

use Modules\Sicadi\Entities\DjGuide;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DjGuideRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DjGuideRepositoryEloquent extends BaseRepository implements DjGuideRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DjGuide::class;
    }

    public function truncate()
    {
        DjGuide::truncate();
    }

}
