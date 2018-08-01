<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface STennantAllContractRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface TenantAllContractRepository extends RepositoryInterface
{
    public function truncate();
}
