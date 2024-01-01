<?php
// query_courses.php


$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Get the course name from the AJAX request
    $courseName = $_POST['queryValue'];
    $queryType = $_POST['queryType'];
    $queryGrade = $_POST['queryGrade'];
    // Perform a database query based on the course name
    $query = "SELECT * FROM class WHERE Dept_Name LIKE :courseName  and Grade LIKE :queryGrade ORDER BY Grade";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':courseName', '%' . $courseName . '%', PDO::PARAM_STR);
    $stmt->bindValue(':queryGrade', '%' . $queryGrade . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results (you can format this as needed)
    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
