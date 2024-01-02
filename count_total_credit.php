<?php
// 刪除課程
$user = 'root';
$password = 'D223084117980141';

try {
    $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $User_Name = $_POST['User_Name'];
    $modified_User_Name = substr($User_Name, 1);
    $query = "SELECT sum(credit) FROM user_class WHERE  User_Name = ? ";
    $stmt = $db->prepare($query);

    $stmt->execute(array($modified_User_Name));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
    $db = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>