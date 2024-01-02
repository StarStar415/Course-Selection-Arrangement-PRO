<?php session_start();

$user = 'root';
$password = '01057132';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Get the user information from the AJAX request
    $regUsername = $_POST['username'];
    $regCode = $_POST['validCode'];
    $regPass = $_POST['password'];

    // Perform a database query based on the user information
    $query = "SELECT * FROM uservalidcode WHERE username = ? ";
    $stmt = $db->prepare($query);
    $stmt->execute(array($regUsername));
    $result = $stmt->fetchAll();

    if (!$result)
        throw new PDOException("此帳戶尚未計送驗證碼");
    //若驗證碼正確
    if ($result[0]['validCode'] == $regCode) {

        //更新使用者密碼
        $query = "UPDATE user SET Password = ? WHERE User_Name = ? ";
        $stmt = $db->prepare($query);
        $error = $stmt->execute(array($regPass, $regUsername));

        //刪除使用者驗證碼
        $query = "DELETE FROM uservalidcode WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(array($regUsername));
    } else
        throw new PDOException("驗證碼錯誤");
    $db = null;
} catch (PDOException $e) {

    $errorInfo = $e->errorInfo;
    header("HTTP/1.1 500 Internal Server Error");
    echo "驗證碼驗證過程錯誤：" . $errorInfo[2];
}
