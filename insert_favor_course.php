<?php
// insert 選擇的課程到 database user_class
$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $Course_ID = $_POST['Course_ID'];
    $Course_Name = $_POST['Course_Name'];
    $Dept_Name = $_POST['Dept_Name'];
    $Grade = $_POST['Grade'];
    $Teacher_Name = $_POST['Teacher_Name'];
    $Credit = $_POST['Credit'];
    $Class_Type = $_POST['Class_Type'];
    $Time = $_POST['Time'];
    $User_Name = $_POST['User_Name'];
    
    $modified_User_Name = substr($User_Name, 1);
    $query = "INSERT INTO user_favor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    $stmt->execute(array($modified_User_Name, $Course_ID, $Course_Name, $Dept_Name, $Grade, $Teacher_Name, $Credit, $Class_Type, $Time));

    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
