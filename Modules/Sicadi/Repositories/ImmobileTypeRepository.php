<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SImmobileTypeRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ImmobileTypeRepository extends RepositoryInterface
{
    public function truncate();
}
