<?php

// 因為select查詢下去要有選過和沒選過 所以我想要分成兩個 sql 查詢結果

$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $Course_ID = $_POST['Course_ID'];
    $User_Name = $_POST['User_Name'];
    $Grade = $_POST['Grade'];

    $modified_User_Name = substr($User_Name, 1);
    $query = "
        SELECT *
        FROM user_favor
        WHERE User_Name = ? AND Course_ID = ? and Grade =?;
    ";

    $stmt = $db->prepare($query);
    $stmt->execute(array($modified_User_Name, $Course_ID, $Grade));

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
