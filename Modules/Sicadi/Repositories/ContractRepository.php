<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SContractRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ContractRepository extends RepositoryInterface
{
    public function truncate();
}
