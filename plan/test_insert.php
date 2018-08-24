<?php
    session_start();
    include("mysql.php");

    $sql = "INSERT INTO activity (ac_type,ac_hours,ac_spend,ac_name)
        VALUES (1, '景點')";

    $conn->exec($sql);
    $conn=null;
    echo "建立成功";
?>