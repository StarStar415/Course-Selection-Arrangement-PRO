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
    $tmp = '<h3>以下為您的選課清單：</h3><table border="1" style="width: 100%; border-collapse: collapse;">
        <tr style="background-color: #f2f2f2;">
            <th style="padding: 10px;">Course ID</th>
            <th style="padding: 10px;">Course Name</th>
            <th style="padding: 10px;">Dept Name</th>
            <th style="padding: 10px;">Grade</th>
            <th style="padding: 10px;">Teacher Name</th>
            <th style="padding: 10px;">Credit</th>
            <th style="padding: 10px;">Class Type</th>
            <th style="padding: 10px;">Time</th>
        </tr>';

foreach ($result as $row) {
    $tmp .= '<tr style="text-align: center;">';
    $tmp .= '<td style="padding: 10px;">' . $row['Course_ID'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Course_Name'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Dept_Name'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Grade'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Teacher_Name'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Credit'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Class_Type'] . '</td>';
    $tmp .= '<td style="padding: 10px;">' . $row['Time'] . '</td>';
    $tmp .= '</tr>';
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
