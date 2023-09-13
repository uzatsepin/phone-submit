<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.razdev.online';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@razdev.online';
    $mail->Password = 'password';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->CharSet = 'utf-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->isHTML(true);
    $mail->setFrom('admin@razdev.online', 'Номер телефона клиента');
    $mail->addAddress('valhala5051@gmail.com');
    $mail->Subject = 'Новый номер телефона';
    $body = '';
    if (isset($_POST['clientPhoneNumber']) && !empty($_POST['clientPhoneNumber'])) {
        $body .= '<p>Номер телефона клиента: ' . $_POST['clientPhoneNumber'] . '</p>';
    } else {
        $message = 'Ошибка: Номер телефона не был передан.';
        $response = ['message' => $message];
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
    }

    $mail->Body = $body;
    $mail->send();

    $message = 'success';
    $response = ['message' => $message];
    header('Content-type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    $message = 'Ошибка отправки номера телефона: ' . $mail->ErrorInfo;
    $response = ['message' => $message];
    header('Content-type: application/json');
    echo json_encode($response);
    exit();
}
?>
