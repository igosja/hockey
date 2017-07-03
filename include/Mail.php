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

        $message = '<html>
                    <head>
                        <style>
                            html, body {
                                height: 100%;
                            }
                    
                            html {
                                background-color: #f5f5f5;
                            }
                    
                            html, body {
                                color: #0f103d;
                                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                                font-size: 13px;
                                -ms-text-size-adjust: 100%;
                                -webkit-text-size-adjust: 100%;
                            }
                    
                            body {
                                display: block;
                                margin: 8px;
                            }
                    
                            img {
                                border: none;
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
                    
                            *, *:before, *:after {
                                box-sizing: border-box;
                                -moz-box-sizing: border-box;
                                -webkit-box-sizing: border-box;
                            }
                    
                            @media (min-width: 768px) {
                                .content {
                                    width: 750px;
                                }
                            }
                    
                            @media (min-width: 992px) {
                                .content {
                                    width: 970px;
                                }
                            }
                    
                            @media (min-width: 1200px) {
                                .content {
                                    width: 1170px;
                                }
                            }
                    
                            .row {
                                margin-right: -2px;
                                margin-left: -2px;
                            }
                    
                            .row:before,
                            .row:after {
                                display: table;
                                content: " ";
                            }
                    
                            .row:after {
                                clear: both;
                            }
                    
                            .col-lg-12 {
                                position: relative;
                                min-height: 1px;
                                padding-right: 2px;
                                padding-left: 2px;
                            }
                    
                            .col-lg-12 {
                                float: left;
                            }
                    
                            .col-lg-12 {
                                width: 100%;
                            }
                    
                            .text-center {
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
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
                    </div>
                    </body>
                    </html>';
        mail($this->to, $subject, $message, $headers);
    }
}