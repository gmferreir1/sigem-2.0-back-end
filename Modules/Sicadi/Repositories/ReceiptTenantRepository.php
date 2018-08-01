<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SReceiptTenantRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ReceiptTenantRepository extends RepositoryInterface
{
    public function truncate();
}
