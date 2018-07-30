<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request)
    {

    }

    public function find($id)
    {

    }

    public function all()
    {

    }

    public function update(Request $request, $id)
    {

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
