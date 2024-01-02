<?php

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Passing `true` enables exceptions
$user = 'root';
$password = '01057132';
$db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);

try {

    //嘗試建立使用者驗證碼table
    create_table();


    $mail->CharSet = 'UTF-8';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $username  = $_POST['username'];
    $query = "SELECT * FROM user WHERE User_Name = ?";
    $stmt = $db->prepare($query);

    $error = $stmt->execute(array($username));
    $result = $stmt->fetchAll();

    if (!$result) {
        throw new PDOException("輸入帳號不存在");
    } else {
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
        $subject = "=?UTF-8?B?" . base64_encode('學程~啟航!驗證碼信件') . "?="; //信件標題，解決亂碼問題
        $mail->Subject = $subject;
        $prefix = '您的驗證碼為:';
        $postfix = generateRandomString();
        $mail->Body = $prefix . $postfix;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //將使用者驗證碼插入到table中
        if (insertValidCode($username, $postfix)) {
            echo "已成功寄送驗證碼";
        } else {
            updateValidCode($username, generateRandomString());
            echo "已重新寄送驗證碼";
        }
    }



    $db = null;
} catch (PDOException $e) {
    $errorInfo = $e->errorInfo;
    header("HTTP/1.1 500 Internal Server Error");
    echo "不存在帳號:" . $errorInfo[2];
}
function generateRandomString($length = 5)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_table()
{
    try {
        $user = 'root';
        $password = '01057132';
        $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = "CREATE TABLE userValidCode(
            username VARCHAR(100) PRIMARY KEY,
            validCode VARCHAR(10) NOT NULL
        )";
        $stmt = $db->prepare($query);
        $error = $stmt->execute();
    } catch (PDOException $err) {
        return;
    }
}
function insertValidCode($username, $validCode)
{
    $error = '';
    try {
        $user = 'root';
        $password = '01057132';
        $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = "INSERT INTO uservalidcode values(?,?)";
        $stmt = $db->prepare($query);
        $error = $stmt->execute(array($username, $validCode));
    } catch (PDOException $err) {
        $error = false;
    }


    return $error;
}
function updateValidCode($username, $validCode)
{
    $error = '';
    try {
        $user = 'root';
        $password = '01057132';
        $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = "UPDATE uservalidcode SET validCode = ? WHERE username = ?";
        $stmt = $db->prepare($query);
        $error = $stmt->execute(array($validCode, $username));
    } catch (PDOException $err) {
        $error = false;
    }


    return $error;
}
