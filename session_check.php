<?php
try {
    session_start();
    if (isset($_SESSION['username'])) {
        $currentUsername = $_SESSION['username'];
        echo '<h1>學途~啟航!<span id="user_block"><span id="user_img" ><img src="img/user.png" alt="User"></span><span id="user_name"> ' . $currentUsername . '</span>&nbsp;&nbsp;<span><button id="logoutButton" class="btn" onclick="handleLogout()" >登出</button></span></span></h1>';
    } else {
        echo '<h1>學途~啟航!</h1>';
    }
} catch (Exception $err) {
    echo '<h1>學途~啟航!</h1>';
}
