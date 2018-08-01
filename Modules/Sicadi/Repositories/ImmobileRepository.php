<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SImmobileRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ImmobileRepository extends RepositoryInterface
{
    public function truncate();
}
