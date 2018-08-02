<?php

namespace Modules\Termination\Services;


class DestinationOrReasonService
{
    /**
     * @var DestinationOrReasonServiceCrud
     */
    private $serviceCrud;

    public function __construct(DestinationOrReasonServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * verifica de tem cadastrado o destino ou motivo
     * @param string $type
     * @param string $text
     * @return mixed
     */
    public function checkExists(string $type, string $text)
    {
        $check = $this->serviceCrud->findWhere(['type' => $type, 'text' => $text]);

        if ($check->count()) {
            $message[] = "Ja cadastrado no sistema";
            return response($message, 422);
        }
    }

    /**
     * verifica se esta cadastrado no sistema (excluindo o id que esta fazendo o update)
     * @param string $type
     * @param string $text
     * @param $id
     * @return mixed
     */
    public function checkExistsToUpdate(string $type, string $text, $id)
    {
        $closure = function ($query) use ($type, $text, $id) {
            return $query->where('id', '!=', $id)
                    ->where('type', $type)
                    ->where('text', $text);
        };

        $check = $this->serviceCrud->scopeQuery($closure);

        if ($check->count()) {
            $message[] = "Ja cadastrado no sistema";
            return response($message, 422);
        }
    }
}