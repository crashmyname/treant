<?php

namespace Support;

class Mailer
{
    private $to;
    private $subject;
    private $message;
    private $headers = [];
    private $attachments = [];
    private $smtpSettings = [];
    private $useSMTP = false;

    public function __construct($to = null, $subject = null, $message = null)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers[] = "MIME-Version: 1.0";
        $this->headers[] = "Content-type:text/html;charset=UTF-8";
        $this->headers[] = 'From: no-reply@example.com';
    }

    public function setRecipient($to)
    {
        $this->to = $to;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setFrom($from)
    {
        $this->headers[] = "From: {$from}";
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function addAttachment($filePath, $fileName = null)
    {
        $this->attachments[] = [
            'path' => $filePath,
            'name' => $fileName ?: basename($filePath),
        ];
    }

    public function useSMTP($host, $username, $password, $port = 587, $encryption = 'tls')
    {
        $this->useSMTP = true;
        $this->smtpSettings = [
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'port' => $port,
            'encryption' => $encryption,
        ];
    }

    public function send()
    {
        if ($this->useSMTP) {
            return $this->sendWithSMTP();
        } else {
            $headers = implode("\r\n", $this->headers);
            return mail($this->to, $this->subject, $this->message, $headers);
        }
    }

    private function sendWithSMTP()
    {
        // Penggunaan SMTP
        $smtp = fsockopen($this->smtpSettings['host'], $this->smtpSettings['port']);
        if (!$smtp) {
            throw new \Exception('Could not connect to SMTP server');
        }

        $this->smtpCommand($smtp, 'EHLO ' . $this->smtpSettings['host']);
        $this->smtpCommand($smtp, 'AUTH LOGIN');
        $this->smtpCommand($smtp, base64_encode($this->smtpSettings['username']));
        $this->smtpCommand($smtp, base64_encode($this->smtpSettings['password']));
        $this->smtpCommand($smtp, 'MAIL FROM: <' . $this->headers['From'] . '>');
        $this->smtpCommand($smtp, 'RCPT TO: <' . $this->to . '>');
        $this->smtpCommand($smtp, 'DATA');

        $message = "To: {$this->to}\r\n";
        $message .= "Subject: {$this->subject}\r\n";
        $message .= implode("\r\n", $this->headers) . "\r\n";
        $message .= "\r\n" . $this->message . "\r\n.\r\n";

        $this->smtpCommand($smtp, $message);
        $this->smtpCommand($smtp, 'QUIT');
        
        fclose($smtp);

        return true;
    }

    private function smtpCommand($smtp, $command)
    {
        fputs($smtp, $command . "\r\n");
        $response = fgets($smtp, 515);

        if (substr($response, 0, 3) != '250' && substr($response, 0, 3) != '334' && substr($response, 0, 3) != '354') {
            throw new \Exception('SMTP Error: ' . $response);
        }

        return $response;
    }
}
?>
