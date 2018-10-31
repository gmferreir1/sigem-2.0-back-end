<?php

namespace Modules\Sicadi\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SPhoneRepository.
 *
 * @package namespace App\Repositories;
 */
interface PhoneRepository extends RepositoryInterface
{
    public function truncate();
}
