<?php

    //database configuration
    $host       = "sql306.epizy.com";
    $user       = "epiz_33000797";
    $pass       = "NQzgcQuTrS1u";
    $database   = "epiz_33000797_ecommerce_android_app";

    $connect = new mysqli($host, $user, $pass, $database);

  /*   if (!$connect) {
        die ("connection failed: " . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8');
        //echo "connected";
    }
 */
?>