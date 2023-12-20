<?php
    $urllogin = 'login';

    $redirect_url = "http://$_SERVER[192.168.141.*]/$urllogin";
    
    header("Location: $redirect_url");
    exit();