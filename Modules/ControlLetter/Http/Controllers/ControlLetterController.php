<?php

namespace Modules\ControlLetter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\ControlLetter\Services\ControlLetterServiceCrud;

class ControlLetterController extends Controller
{
    /**
     * @var ControlLetterServiceCrud
     */
    private $serviceCrud;

    public function __construct(ControlLetterServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * Retorna os nomes das cartas para mostrar no select
     * @return mixed
     */
    public function getLettersRegistered()
    {
        return $this->serviceCrud->all(false, 0, null, ['id', 'name']);
    }

    public function find($id)
    {
        return $this->serviceCrud->find($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['rp_last_action'] = Auth::user()->id;

        return $this->serviceCrud->update($data, $id);
    }

    /**
     * Retorna o total de cartas registradas no sistema
     * @return mixed
     */
    public function getTotalLettersRegistered()
    {
        return $this->serviceCrud->all()->count();
    }
}
