<?php

namespace Modules\Sicadi\Services;

use Illuminate\Support\Facades\Storage;

class UploadDatabaseService
{
    public function upload($data)
    {
        $data['upload_file'] = $data[0];
        Storage::disk('local')->deleteDirectory('firebird');
        umask(0);

        $storage_path = storage_path('app');
        $path = 'firebird/';

        mkdir($storage_path . '/' . $path, 0777, true);

        return $this->uploadFile($data['upload_file']);
    }

    /**
     * Faz envio do arquivo
     * @param $file
     * @return mixed
     */
    private function uploadFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $file_original_name = $file->getClientOriginalName();

        $path = storage_path('app/firebird/');

        if($extension != 'zip') {
            $messages[] = 'O sistema so aceita formato .zip';
            return response($messages, 422);
        }

        // limites para o upload
        ini_set('memory_limit', '500000M');
        ini_set('upload_max_filesize', '500000M');
        ini_set('post_max_size', '500000M');
        ini_set('max_input_time', 0);
        ini_set('max_execution_time', 0);

        Storage::disk('local')->put('firebird/'.$file_original_name, file_get_contents($file));

        // verifica e extrai o arquivo
        $new_name_file = md5(date('Y-m-d H:i:s')).'.GDB';

        $zip = new \ZipArchive();

        if ($zip->open($path.$file_original_name) === TRUE) {

            $zip->renameName($zip->getNameIndex(0), $new_name_file);
            $zip->extractTo($path, $new_name_file);
            $zip->close();
            Storage::disk('local')->delete('firebird/'.$file_original_name);
        }

        return [
            'success' => true
        ];
    }
}