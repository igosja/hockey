<?php

class Mail
{
    private $from;
    private $from_name = 'Виртуальная Хоккейная Лига';
    private $message = "";
    private $subject = "";
    private $to = "";

    public function __construct()
    {
        $this->from = 'noreply@' . $_SERVER['HTTP_HOST'];
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setFromName($from_name)
    {
        $this->from_name = $from_name;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setHtml($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $from       = "=?utf-8?B?" . base64_encode($this->from_name) . "?=" . " <" . $this->from . ">";
        $headers    = "From: " . $from . "\r\nReply-To: " . $from . "\r\nContent-type: text/html; charset=utf-8\r\n";
        $subject    = "=?utf-8?B?" . base64_encode($this->subject) . "?=";

        $message = '<link rel="stylesheet" href="https://vhol.org/css/style.css">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <img src="https://vhol.org/img/logo.png"/>
                            </div>
                        </div>
                        <div class="row margin-top">
                            <div class="col-lg-12">
                                ' . $this->message . '
                            </div>
                        </div>
                        <div class="row margin-top">
                            <div class="col-lg-12">
                                Администрация Виртуальной Хоккейной Лиги
                            </div>
                        </div>
                    </div>';
        mail($this->to, $subject, $message, $headers);
    }
}