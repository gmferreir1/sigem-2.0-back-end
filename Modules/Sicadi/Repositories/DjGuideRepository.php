<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DjGuideRepository.
 *
 * @package namespace App\Repositories;
 */
interface DjGuideRepository extends RepositoryInterface
{
    public function truncate();
}
