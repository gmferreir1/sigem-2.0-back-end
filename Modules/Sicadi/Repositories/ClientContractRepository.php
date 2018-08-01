<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SClientContractRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ClientContractRepository extends RepositoryInterface
{
    public function truncate();
}
