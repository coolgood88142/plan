<?php
    include("mysql.php");

    $sql = "select * from activity_types";

    $query = $conn->query($sql);
    $types = $query->fetchAll(PDO::FETCH_ASSOC);


    $sql = "select * from time_types";

    $query = $conn->query($sql);
    $time = $query->fetchAll(PDO::FETCH_ASSOC);

?>