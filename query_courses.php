<?php
// query_courses.php

// Assuming you have a database connection already established
$user = 'root';
$password = '01057132';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Get the course name from the AJAX request
    $courseName = $_POST['courseName'];

    // Perform a database query based on the course name
    $query = "SELECT * FROM class WHERE Course_Name LIKE :courseName";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':courseName', '%' . $courseName . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results (you can format this as needed)
    echo json_encode($results);

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
