<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SImmobileVisitRepository
 * @package namespace Modules\ApiSicadi\Repositories;
 */
interface ImmobileVisitRepository extends RepositoryInterface
{
    public function truncate();
}
