<?php

class Mail
{
    private $from;
    private $from_name = 'Виртуальная Хоккейная Лига';
    private $message = '';
    private $subject = '';
    private $to = '';

    public function __construct()
    {
        $this->from = 'noreply@vhol.org';
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

        $message = '<style>
                body {
                    margin: 0 auto;
                    text-align: center;
                }
                
                a, a:active, a:hover, a:focus, a:visited {
                    color: #0008ae;
                }
                
                a, a:visited, a:active {
                    text-decoration: none;
                }
                
                a:hover, a:focus {
                    text-decoration: underline;
                }
                
                .table {
                    border-collapse: collapse;
                    border-spacing: 0;
                    font-family: Arial, sans-serif;
                    font-size: 16px;
                    margin: 0 auto;
                    max-width: 50%;
                    width: 50%;
                }

                .table th,
                .table th a {
                    background-color: #286090;
                    color: #f0f0f0;
                }
                .table-bordered {
                    border: 1px solid #dddddd;
                }
                
                .table-bordered th,
                .table-bordered td {
                    border: 1px solid #dddddd;
                    padding: 20px;
                }

                .grey {
                    color: #777777;
                    font-family: Arial, sans-serif;
                    font-size: 15px;
                    text-align: center;
                }
            </style>
            <img class="logo" src="' . SITE_URL . '/img/logo.png"/>
            <table class="table table-bordered">
            <tr><td>' . $this->message . '</td></tr>
            </table>
            <p class="grey">Администрация <a href="' . SITE_URL . '">Виртуальной Хоккейной Лиги</a></p>';
        mail($this->to, $subject, $message, $headers);
    }
}