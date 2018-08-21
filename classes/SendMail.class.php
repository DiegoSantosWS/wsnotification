<?php

namespace SendEmail;


class SendMail {

    private $accounts = [];
    public $returning;
    private $environment = "development";
    private $host;
    private $user;
    private $pass;
    private $port;

    function __construct(array $accounts, string $environment) {
        $this->accounts = $accounts;
        $this->environment = $environment["type"];
        $this->host = $environment["host"];
        $this->user = $environment["user"];
        $this->pass = $environment["pass"];
        $this->port = $environment["port"];

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
        $m->SMTPSecure = 'ssl';
        $m->IsSMTP();
        $m->Host = $this->host;//"smtp.gmail.com";
        $m->Port = $this->port;
        $m->SMTPAuth = true;
        $m->Username = $this->user;//"tec.infor321@gmail.com";
        $m->Password = $this->pass;//"diegodos";
        $m->IsHTML(true);
        $m->setFrom($email);
        $m->FromName = "PC-LINUX";
        $m->ConfirmReadingTo = $this->user;//"tec.infor321@gmail.com";

    
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
        $m->SMTPSecure = 'ssl';
        $m->IsSMTP();
        $m->Host = $this->host;//"smtp.mailtrap.io";
        $m->Port = $this->port;//2525;
        $m->SMTPAuth = true;
        $m->Username = $this->user;//"456487957d12be";
        $m->Password = $this->pass;//"519aadd5f9195d";
        $m->IsHTML(true);
        $m->setFrom($email);
        $m->FromName = "PC-LINUX";
        $m->ConfirmReadingTo = $this->user;//"diego@wsitebrasil.com.br";

    
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
