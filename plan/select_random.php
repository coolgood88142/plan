<?php
    include("mysql.php");

    $sql = "";

    $day = "";
    if(isset($_POST['day'])){
        $day = $_POST['day'];
    }

    $typeid = "";
    if(isset($_POST['typeid'])){
        $typeid = $_POST['typeid'];
    }

    $day_time = "";
    if(isset($_POST['day_time'])){
        $day_time = $_POST['day_time'];
    }

    $time_type = "";
    if(isset($_POST['typeid'])){
        $time_type = $_POST['typeid'];
    }

    echo "time_type: " . var_dump($time_type);

    if($day!="" && $typeid!="" && $day_time!="" && $time_type!=""){
        // $sql = "select * from activity where ac_timetype = " . ;

    }else{
        $sql = "select * from activity_types";

        $query = $conn->query($sql);
        $types = $query->fetchAll(PDO::FETCH_ASSOC);
    
    
        $sql = "select * from time_types";
    
        $query = $conn->query($sql);
        $time = $query->fetchAll(PDO::FETCH_ASSOC);
    }


?>