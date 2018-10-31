<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SReceiptTenantCompleteRepository.
 *
 * @package namespace App\Repositories;
 */
interface ReceiptTenantCompleteRepository extends RepositoryInterface
{
    public function truncate();
}
