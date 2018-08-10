<?php

namespace Modules\Termination\Services;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

class RecordPrinterService
{
    protected  $sourcePath = __DIR__.'/../Resources/views';

    /**
     * @param array $data
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function deliveryKeyPendencieDoc(array $data)
    {
        $replace = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $data['termination']['observation']);

        $controles = null;
        $keys = null;
        $alarm = null;
        $manual_key = null;
        $fair_card = null;

        if ($data['rental_accessory']['control_gate']) {
            $controles = $data['rental_accessory']['control_gate'] . ' controle(s), ';
        }

        if ($data['rental_accessory']['keys_delivery']) {
            $keys = $data['rental_accessory']['keys_delivery'] . ' chaves(s), ';
        }

        if ($data['rental_accessory']['control_alarm']) {
            $alarm = $data['rental_accessory']['control_alarm'] . ' controles(s) alarme, ';
        }

        if ($data['rental_accessory']['key_manual_gate']) {
            $manual_key = $data['rental_accessory']['key_manual_gate'] . ' chave(s) manual portão, ';
        }

        if ($data['rental_accessory']['fair_card']) {
            $fair_card = $data['rental_accessory']['fair_card'] . ' catão feira, ';
        }

        $templateProcessor = new TemplateProcessor("$this->sourcePath/printer/layoutRecordDeliveryKeyPendencies.docx");
        $templateProcessor->setValue('titleHeader', 'TERMO DE ENTREGA DE CHAVES COM RESSALVAS');
        $templateProcessor->setValue(array(
            'contract', 'address', 'tenant', 'owner', 'text', 'pendencies', 'date_extensive'
        ), array(
            $data['termination']['contract'],
            uppercase($data['termination']['address']) . ' ' . uppercase($data['termination']['neighborhood']) . ' - MONTES CLAROS - MG',
            uppercase($data['termination']['tenant']),
            uppercase($data['termination']['owner']),
            'Declaro que estou entregando nesta data, ' .
            $controles . $keys . $alarm . $manual_key . $fair_card .
            'do imóvel supra, após vistoria realizada no dia ' . $data['survey_date'] . ', onde foram constatadas as pendencias abaixo relacionadas, pelo vistoriador da Master RSM Imóveis e das quais não concordo em resolvê - las.',
            $replace,
            dateExtensive(),
        ));

        $file_name = md5(date('Y-m-d H:i:s'. Auth::user()->id.'data_print')) . '_entrega_chaves_ressalva.docx';
        $templateProcessor->saveAs($file_name);

        return ['file_name' => $file_name];
    }

    /**
     * Entrega de chaves antes da vistoria
     * @param array $data
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function deliveryKeyBeforeSurvey(array $data)
    {
        $templateProcessor = new TemplateProcessor("$this->sourcePath/printer/layoutRecordDeliveryKeyBeforeSurvey.docx");
        $templateProcessor->setValue(array(
            'immobile_code', 'address', 'date_extensive', 'client_name', 'client_cpf'
        ), array(
            $data['termination']['immobile_code'],
            uppercase($data['termination']['address']).' '.  uppercase($data['termination']['neighborhood']) . ' - MONTES CLAROS - MG',
            dateExtensive(),
            uppercase($data['client_data']['name']),
            uppercase($data['client_data']['cpf']),
        ));

        $file_name = md5(date('Y-m-d H:i:s'. Auth::user()->id.'data_print')) . '_entrega_chaves_antes_vistoria.docx';

        $templateProcessor->saveAs($file_name);

        return ['file_name' => $file_name];
    }


    public function deliveryKeyAfterSurvey(array $data)
    {
        $templateProcessor = new TemplateProcessor("$this->sourcePath/printer/layoutRecordDeliveryKeyAfterSurvey.docx");
        $templateProcessor->setValue(array(
            'immobile_code', 'address', 'date_extensive', 'client_name', 'client_cpf'
        ), array(
            $data['termination']['immobile_code'],
            uppercase($data['termination']['address']).' '.  uppercase($data['termination']['neighborhood']) . ' - MONTES CLAROS - MG',
            dateExtensive(),
            uppercase($data['client_data']['name']),
            uppercase($data['client_data']['cpf']),
        ));

        $file_name = md5(date('Y-m-d H:i:s'. Auth::user()->id.'data_print')) . '_entrega_chaves_apos_vistoria.docx';

        $templateProcessor->saveAs($file_name);

        return ['file_name' => $file_name];
    }
}