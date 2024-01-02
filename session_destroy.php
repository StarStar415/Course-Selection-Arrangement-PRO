<?php
try {
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
        echo ("刪除session成功");
    }
} catch (Exception $e) {
    echo
    "Error: " . $e->getMessage();
}
