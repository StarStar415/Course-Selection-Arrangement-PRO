<?php session_start();

$user = 'root';
$password = '01057132';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Get the user information from the AJAX request
    $regUsername = $_POST['username'];
    $regPassword = $_POST['password'];

    // Perform a database query based on the user information
    $query = "SELECT User_Name,Password FROM user WHERE User_Name = ? AND Password = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($regUsername, $regPassword));
    $result = $stmt->fetchAll();

    if (!$result)
        throw new PDOException("登入資訊錯誤");

    //設定session
    $_SESSION['username'] = $result[0][0];

    $db = null;
} catch (PDOException $e) {

    $errorInfo = $e->errorInfo;
    header("HTTP/1.1 500 Internal Server Error");
    echo "登入帳號失敗：" . $errorInfo[2];
}
