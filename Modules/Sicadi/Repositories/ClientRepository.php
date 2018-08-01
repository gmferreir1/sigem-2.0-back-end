<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SCompleteClientRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ClientRepository extends RepositoryInterface
{
    public function truncate();
}
