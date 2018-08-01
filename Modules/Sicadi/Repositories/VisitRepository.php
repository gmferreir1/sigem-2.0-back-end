<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SVisitRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface VisitRepository extends RepositoryInterface
{
    public function truncate();
}
