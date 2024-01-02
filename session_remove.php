<?php session_start();


try {

    if (isset($_SESSION['username'])) {
        session_destroy();
        echo "刪除session成功";
    } else
        echo "session已不存在";
} catch (PDOException $e) {
    echo "session已不存在";
}
