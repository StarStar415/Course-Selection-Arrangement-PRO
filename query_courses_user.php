<?php

// 因為select查詢下去要有選過和沒選過 所以我想要分成兩個 sql 查詢結果
$user = 'root';
$password = '01057132';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $courseName = $_POST['queryValue'];
    $queryType = $_POST['queryType'];
    $User_Name = $_POST['User_Name'];

    $query = "
        SELECT class.*
        FROM user_class
        INNER JOIN class ON user_class.Course_ID = class.Course_ID
        WHERE user_class.User_Name = :userName AND class.$queryType LIKE :courseName
        ORDER BY class.Grade;
    ";

    $stmt = $db->prepare($query);
    $stmt->bindValue(':userName', $User_Name, PDO::PARAM_STR);
    $stmt->bindValue(':courseName', '%' . $courseName . '%', PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
