<?php
// 查詢和使用者輸入有相同子句的課程並回傳

$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $courseName = $_POST['queryValue'];
    $queryType = $_POST['queryType'];
    $query = "SELECT * FROM class WHERE $queryType LIKE :courseName ORDER BY Grade";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':courseName', '%' . $courseName . '%', PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
