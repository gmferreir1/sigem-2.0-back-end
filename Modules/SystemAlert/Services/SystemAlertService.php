<?php

namespace Modules\SystemAlert\Services;

class SystemAlertService
{

    /**
     * @var SystemAlertServiceCrud
     */
    private $serviceCrud;

    public function __construct(SystemAlertServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }
}