<?php

$user = 'root';
$password = '01057132';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $Course_ID = $_POST['Course_ID'];
    $User_Name = $_POST['User_Name'];
    $Grade = $_POST['Grade'];

    $query = "DELETE FROM user_class WHERE Course_ID = ? AND User_Name = ? AND Grade =?";
    $stmt = $db->prepare($query);

    $stmt->execute(array($Course_ID, $User_Name, $Grade));

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>