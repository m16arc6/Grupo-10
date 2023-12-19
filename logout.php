<?php
    session_start();
    session_destroy();
    $urllogin = 'login';
    header('Location: '.$urllogin);
?>