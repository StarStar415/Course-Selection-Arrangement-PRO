<?php
// 查詢系所時要加上年級的特別查詢 php


$user = 'root';
$password = '123';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $courseName = $_POST['queryValue'];
    $queryType = $_POST['queryType'];
    $queryGrade = $_POST['queryGrade'];

    $query = "SELECT * FROM class WHERE Dept_Name LIKE :courseName  and Grade LIKE :queryGrade ORDER BY Grade";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':courseName', '%' . $courseName . '%', PDO::PARAM_STR);
    $stmt->bindValue(':queryGrade', '%' . $queryGrade . '%', PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
