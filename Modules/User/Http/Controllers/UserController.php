<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Modules\User\Services\UserService;
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
    /**
     * @var UserService
     */
    private $service;

    public function __construct(UserServiceCrud $serviceCrud, ValidadeFieldsService $validadeFieldsService, UserService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->validadeFieldsService = $validadeFieldsService;
        $this->service = $service;
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
            'image_profile' => $userData->image_profile,
        ];
    }

    public function getTotalUsersRegistered()
    {
        return $this->serviceCrud->all()->count();
    }


    /**
     * @param $userId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function changeProfileImage($userId = null)
    {
        if (!$userId) {
            $userId = Auth::user()->id;
        }

        return $this->service->changeAvatar(Input::file('attachment'), $userId);
    }

    /**
     * Define a imagem padrão para o usuário
     * @param null $userId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function setDefaultImageProfile($userId = null)
    {
        if (!$userId) {
            $userId = Auth::user()->id;
        }

        return $this->serviceCrud->update(['image_profile' => null], $userId, false)->image_profile;
    }
}
