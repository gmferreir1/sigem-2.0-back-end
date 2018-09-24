<?php

namespace Modules\User\Services;


use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var UserServiceCrud
     */
    private $serviceCrud;

    public function __construct(UserServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    public function getNameById(int $id = null)
    {
        $idUSer = !$id ? Auth::user()->id : $id;

        $userData = $this->serviceCrud->find($idUSer);

        return "$userData->name $userData->last_name";
    }

    /**
     * Troca de avatar
     * @param $file
     * @param $userId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function changeAvatar($file, $userId)
    {
        $file = $file[0];
        $extension = $file->getClientOriginalExtension();

        if($extension != 'jpg' and $extension != 'bmp' and $extension != 'png') {
            $messages[] = 'O sistema so aceita formato .jpg, bmp ou png';
            return response($messages, 422);
        }

        $fileSize  = filesize($file);

        if (round(($fileSize / 1048576), 2) > 1) {
            $messages[] = 'Permitido imagem ate 1MB';
            return response($messages, 422);
        }

        $data = file_get_contents($file);

        $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($data);

        // grava na base de dados o base_64 do avatar
        return $this->serviceCrud->update(['image_profile' => $base64], $userId, false)->image_profile;
    }
}