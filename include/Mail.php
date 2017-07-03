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
        $from = "=?utf-8?B?" . base64_encode($this->from_name) . "?=" . " <" . $this->from . ">";
        $headers = "From: " . $from . "\r\nReply-To: " . $from . "\r\nContent-type: text/html; charset=utf-8\r\n";
        $subject = "=?utf-8?B?" . base64_encode($this->subject) . "?=";

        $message = '<table style="width: 100%; background-color: #f5f5f5; color: #0f103d; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <tr>
                            <td style="text-align: center;">
                                <img src="https://vhol.org/img/logo.png" style="border: none;"/>
                            </td>
                        </tr>
                        <tr>
                            <td>' . $this->message . '</td>
                        </tr>
                        <tr>
                            <td>Администрация Виртуальной Хоккейной Лиги</td>
                        </tr>
                    </table>';
        mail($this->to, $subject, $message, $headers);
    }
}