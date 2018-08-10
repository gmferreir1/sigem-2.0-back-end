<?php

namespace App\Traits\Generic;

use Illuminate\Support\Facades\Auth;

trait Printer
{
    /**
     * @var
     */
    private $data;

    /**
     * @var
     */
    private $viewName;

    /**
     * @var
     */
    private $orientation;

    public function printer(array $data, string $viewName, string $orientation = 'portrait')
    {
        $this->data = $data;
        $this->viewName = $viewName;
        $this->orientation = $orientation;

        return $this->generate();
    }


    /**
     * @return array
     */
    private function generate()
    {
        $fileName = md5(date('Y-m-d H:i:s'. Auth::user()->id.'data_print')).'.pdf';

        \PDF::loadHTML(view($this->viewName,
            [
                'data' => $this->data,
            ]))
            ->setPaper('a4')
            ->setOrientation($this->orientation)
            ->setOption('margin-bottom', 3)
            ->setOption('margin-top', 5)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('encoding', 'utf-8')->save($fileName);

        return ['file_name' => $fileName];
    }

}