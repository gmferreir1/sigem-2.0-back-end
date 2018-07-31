<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserServiceCrud;
use Modules\User\Services\ValidadeFieldsService;

class UserController extends Controller
{

    /**
     * @var UserServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ValidadeFieldsService
     */
    private $validadeFieldsService;

    public function __construct(UserServiceCrud $serviceCrud, ValidadeFieldsService $validadeFieldsService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->validadeFieldsService = $validadeFieldsService;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $datToCreate = $request->all();

        return $this->serviceCrud->create($datToCreate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->serviceCrud->find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->serviceCrud->getAll();
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();

        $dataBeforeUpdate = $this->serviceCrud->find($id)->toArray();
        $dataToUpdate = $this->validadeFieldsService->actionUpdate($dataBeforeUpdate, $dataToUpdate);

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * Retorna dados do usuário logado
     * @return array
     */
    public function getDataUserLogged()
    {
        $userData = Auth::user();

        return [
            'id' => $userData->id,
            'name' => $userData->name,
            'last_name' => $userData->last_name,
            'email' => $userData->email,
        ];
    }
}
