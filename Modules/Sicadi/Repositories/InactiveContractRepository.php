<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SInactiveContractRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface InactiveContractRepository extends RepositoryInterface
{
    public function truncate();
}
