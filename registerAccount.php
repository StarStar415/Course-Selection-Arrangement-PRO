<?php

$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Get the user information from the AJAX request
    $regUsername = $_POST['username'];
    $regPassword = $_POST['password'];
    $regEmail = $_POST['email'];

    // Perform a database query based on the user information
    $query = "INSERT INTO user VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);

    $stmt->execute(array($regUsername, $regPassword, $regEmail));

    $db = null;
} catch (PDOException $e) {

    $errorInfo = $e->errorInfo;
    header("HTTP/1.1 500 Internal Server Error");
    echo "註冊帳號失敗：" . $errorInfo[2];
}
