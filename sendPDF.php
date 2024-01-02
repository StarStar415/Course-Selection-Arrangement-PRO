<?php

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Passing `true` enables exceptions
$user = 'root';
$password = '123';
$db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);

try {

    $mail->CharSet = 'UTF-8';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $username  = $_POST['username'];

    $query = "SELECT * FROM user WHERE User_Name = ?";

    $stmt = $db->prepare($query);
    $error = $stmt->execute(array($username));
    $result = $stmt->fetchAll();


    $email = $result[0]["Email"];
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = "smtp.gmail.com"; // Specify SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = "01057124@email.ntou.edu.tw"; // SMTP username
    $mail->Password = "say1472580"; // SMTP password
    $mail->SMTPSecure = "tls"; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPOptions = array(
        "ssl" => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    //Recipients
    $mail->setFrom('01057124@email.ntou.edu.tw', "=?UTF-8?B?" . base64_encode('資料庫小組') . "?=");
    $mail->addAddress($email); // Name is optional
    $mail->isHTML(true); // Set email format to HTML

    $subject = "=?UTF-8?B?" . base64_encode('學程~啟航!課表信件') . "?="; //信件標題，解決亂碼問題
    $mail->Subject = $subject;

    $query = "SELECT * FROM user join user_class using(User_Name)";

    $stmt = $db->prepare($query);
    $error = $stmt->execute();
    $result = $stmt->fetchAll();
    $tmp = '';
    for ($i = 0; $i < count($result); $i++) {
        $tmp .= $result[$i]['Course_ID'] . ' ';
        $tmp .= $result[$i]['Course_Name'] . ' ';
        $tmp .= $result[$i]['Dept_Name'] . ' ';
        $tmp .= $result[$i]['Grade'] . ' ';
        $tmp .= $result[$i]['Teacher_Name'] . ' ';
        $tmp .= $result[$i]['Credit'] . ' ';
        $tmp .= $result[$i]['Class_Type'] . ' ';
        $tmp .= $result[$i]['Time'] . ' ';
        $tmp .= "<br/>";
    }
    $tmp .= '</table>';
    $mail->msgHTML($tmp); // Set the HTML body
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send(); // Corrected line to send the email

    $db = null;
} catch (PDOException $e) {
    $errorInfo = $e->errorInfo;
    header("HTTP/1.1 500 Internal Server Error");
    echo "寄送失敗:" . $errorInfo[2];
}
