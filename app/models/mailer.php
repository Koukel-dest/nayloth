<?php
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../env.php";

use PHPMailer\PHPMailer\PHPMailer;

function sendMail(string $to, string $subject, string $body): bool
{
    global $smtp_host, $smtp_port, $smtp_from, $smtp_from_name;

    $mail = new PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;

        $mail->setFrom($smtp_from, $smtp_from_name);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
