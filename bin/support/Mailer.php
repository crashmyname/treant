<?php

namespace Support;

class Mailer
{
    private $to;
    private $subject;
    private $message;
    private $headers;

    public function __construct($to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $this->headers .= 'From: <no-reply@example.com>' . "\r\n";
    }

    public function send()
    {
        return mail($this->to, $this->subject, $this->message, $this->headers);
    }
}
?>