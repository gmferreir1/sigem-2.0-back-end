<?php

namespace Modules\User\Services;


class ValidadeFieldsService
{


    /**
     * Verifica valores como:
     * 1 - Senha (se o usuário esta alterando a senha para encriptar)
     * @param array $dataBeforeUpdate
     * @param array $dataToUpdate
     * @return array
     */
    public function actionUpdate(array $dataBeforeUpdate, array $dataToUpdate)
    {
        if ($dataToUpdate['password'] && $dataBeforeUpdate['password'] != 'no_change_password') {
            $dataToUpdate['password'] = bcrypt($dataToUpdate['password']);
        }

        /*
         * se o usuário não passar a senha, elminia o campo para não passar o valor em branco
         */
        if (!$dataToUpdate['password'] || $dataToUpdate['password'] == 'no_change_password') {
            unset($dataToUpdate['password']);
        }

        return $dataToUpdate;
    }

}