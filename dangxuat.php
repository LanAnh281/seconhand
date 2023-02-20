<?php
    session_start();
    session_destroy();
    echo 'đã đăng xuất';
    header('Location: trangchu.php');