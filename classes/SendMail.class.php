<?php

namespace SendEmail;


class SendMail {

    private $accounts = [];
    public $returning;
    private $environment = "development";

    function __construct(array $accounts, string $environment) {
        $this->accounts = $accounts;
        $this->environment = $environment;

        return self::running();
    }
    /**
     * 
     */
    private function setEnvironment(): string {
        return $this->environment;
    }
    /**
     * send email in production mode
     */
    private function sendEmail(string $email, string $message, string $subject, string $anexo) {
        $m = new PHPMailer\PHPMailer\PHPMailer();

        $m->Charset = 'UTF8-8';
        $m->SMTPSecure = 'plain';
        $m->IsSMTP();
        $m->Host = "smtp.mailtrap.io";
        $m->Port = 2525;
        $m->SMTPAuth = true;
        $m->Username = "456487957d12be";
        $m->Password = "519aadd5f9195d";
        $m->IsHTML(true);
        $m->setFrom("diego@wsitebrasil.com.br");
        $m->FromName = "PC-LINUX";
        $m->ConfirmReadingTo = "diego@wsitebrasil.com.br";

    
        $m->AddAddress($email);//email
    
        if (is_array($anexo)) {
            foreach ($anexo as $key => $a) {
                $m->addAttachment($a);//anexo
            }
        } else {
            $m->addAttachment($anexo);//anexo
        }


        $m->Subject = utf8_decode($subject);

        $m->Body = utf8_decode($message);
    
        if (!$m->Send()) {
            #$err["error"] = $m->ErrorInfo;
            return false;
        } else {
            #$err["error"] = false;
            return true;
        }
    }
    /**
     * send email in development mode
     */
    private function sendEmailTest(string $email, string $message, string $subject, array $anexo) {
        $m = new \PHPMailer\PHPMailer\PHPMailer();

        $m->Charset = 'UTF8-8';
        $m->SMTPSecure = 'plain';
        $m->IsSMTP();
        $m->Host = "smtp.mailtrap.io";
        $m->Port = 2525;
        $m->SMTPAuth = true;
        $m->Username = "456487957d12be";
        $m->Password = "519aadd5f9195d";
        $m->IsHTML(true);
        $m->setFrom("diego@wsitebrasil.com.br");
        $m->FromName = "PC-LINUX";
        $m->ConfirmReadingTo = "diego@wsitebrasil.com.br";

    
        $m->AddAddress($email);//email

        if (is_array($anexo)) {
            foreach ($anexo as $key => $a) {
                $m->addAttachment($a);//anexo
            }
        } else {
            $m->addAttachment($anexo);//anexo
        }


        $m->Subject = utf8_decode($subject);

        $m->Body = utf8_decode($message);
    
        if (!$m->Send()) {
            return array("error" => $m->ErrorInfo, "enviado" => false);
        } else {
            return array("error" => "", "enviado" => true);
        }
    }
    /**
     * execuiting the send of the message
     */
    private function running() {
        $env = self::setEnvironment();

        if ($env == "development") {
            foreach ($this->accounts["accounts"] as $key => $value) {
                $this->returning = self::sendEmailTest($value, $this->accounts["message"], $this->accounts["subject"], $this->accounts["anexo"]);
            }
        } else {
            foreach ($this->accounts["accounts"] as $key => $value) {
                $this->returning = self::sendEmail($value, $this->accounts["message"], $this->accounts["subject"], $this->accounts["anexo"]);
            }
        }

        return $this->returning;
    }
}
