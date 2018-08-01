<?php

namespace Modules\Sicadi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Modules\Sicadi\Services\UpdateDataBaseService;
use Modules\Sicadi\Services\UploadDatabaseService;

class SicadiController extends Controller
{
    /**
     * @var UploadDatabaseService
     */
    private $uploadDatabaseService;
    /**
     * @var UpdateDataBaseService
     */
    private $updateDataBaseService;

    public function __construct(UploadDatabaseService $uploadDatabaseService, UpdateDataBaseService $updateDataBaseService)
    {
        $this->uploadDatabaseService = $uploadDatabaseService;
        $this->updateDataBaseService = $updateDataBaseService;
    }

    public function uploadDatabase()
    {
        return $this->uploadDatabaseService->upload(Input::file('attachment'));
    }

    public function readFile()
    {
        $this->updateDataBaseService->initProcessUpdateReadDatabase();
    }
}
