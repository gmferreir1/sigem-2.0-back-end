<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    protected $mailFrom;
    protected $nameFrom;
    protected $mailTo;
    protected $nameTo;
    protected $subject;
    protected $bodyData;
    protected $configAttachment;

    /**
     * @param string|null $mailFrom
     * @param string $nameFrom
     * @param string $mailTo
     * @param string $nameTo
     * @param string $subject
     * @param array $bodyData
     * @param array $configAttachment
     * @return $this
     */
    public function config(string $mailTo, string $nameTo, string $subject, array $bodyData, string $nameFrom = null, string $mailFrom = null, $configAttachment = [])
    {
        $this->mailFrom = !$mailFrom ? 'sigem@masterimoveis.com.br' : $mailFrom;
        $this->nameFrom = !$nameFrom ? 'Sistema de Gestão Master RSM Imóveis' : $nameFrom;
        $this->mailTo = $mailTo;
        $this->nameTo = $nameTo;
        $this->subject = $subject;
        $this->bodyData = $bodyData;
        $this->configAttachment = $configAttachment;

        return $this;
    }

    /**
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {

        $mail = new PHPMailer();

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->Port = 587;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        if (!isset($this->configAttachment['extract_owner']) || $this->configAttachment['extract_owner'] == true) {
            $mail->AddEmbeddedImage(public_path().'/storage/attachment/extrato_aluguel.png', 'extractOwner');
        }

        if (!isset($this->configAttachment['use_logo']) || $this->configAttachment['use_logo'] == true) {
            $mail->AddEmbeddedImage(public_path().'/storage/images/logo_master.png', 'logoMasterNetImoveis');
        }

        if (isset($this->configAttachment['welcome_tenant']) && $this->configAttachment['welcome_tenant'] == true) {
            $mail->AddEmbeddedImage(public_path().'/storage/images/boas_vindas_locatario.png', 'welcomeTenant');
        }

        if (isset($this->configAttachment['manual_tenant']) && $this->configAttachment['manual_tenant'] == true) {
            $mail->addAttachment(public_path().'/storage/attachment/manual_locatario.pdf', 'Manual Locatário.pdf');
        }

        $mail->AddEmbeddedImage(public_path().'/storage/images/blog.png', 'blogIcon');
        $mail->AddEmbeddedImage(public_path().'/storage/images/facebook.png', 'facebookIcon');
        $mail->AddEmbeddedImage(public_path().'/storage/images/instagram.png', 'instagramIcon');

        $mail->setFrom($this->mailFrom, $this->nameFrom);
        $mail->addAddress($this->mailTo, $this->nameTo);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = $this->subject;
        $mail->Body    = view($this->bodyData['view'], ['data' => $this->bodyData['data']]);

        if($mail->send()) {
            return true;
        }

        return false;
    }
}