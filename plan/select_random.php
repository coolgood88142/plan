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
    $time_count = "";
    if(isset($_POST['typeid'])){
        $time_type = $_POST['typeid'];
        $time_count = count($time_type);
    }

    if($day!="" && $typeid!="" && $day_time!="" && $time_type!=""){
        $sql = "select * from activity ";
        if($time_count>0){
            $sql = $sql . "where ac_type in (";
            for($i=0;$i<$time_count;$i++){
                $sql = $sql . "'" . $time_type[$i] . "',";
            }
            $sql = substr($sql,0,-1) . ")";
        }
        // $plans = $query->fetchAll(PDO::FETCH_ASSOC);
        // $data = array_rand($plans,2);
        echo $sql;
    }else{
        $sql = "select * from activity_types";

        $query = $conn->query($sql);
        $types = $query->fetchAll(PDO::FETCH_ASSOC);
    
    
        $sql = "select * from time_types";
    
        $query = $conn->query($sql);
        $time = $query->fetchAll(PDO::FETCH_ASSOC);
    }


?>