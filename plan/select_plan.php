<?php
    include("mysql.php");
    
    $us_account = $_SESSION['us_account'];
    $sql = "SELECT us_id,us_name FROM user ";


    $usid = "";$id = "";$user="";
    if($us_admin!='Y'){
        $sql = $sql . " WHERE us_account='$us_account'";
        $query = $conn->query($sql);
        $user = $query->fetch(PDO::FETCH_ASSOC);
    }else{
        $sql = $sql . " WHERE us_admin NOT IN ('Y') ";
        $query = $conn->query($sql);
        $user = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    date_default_timezone_set('Asia/Taipei');
    $today = date ("Y-m-d");

    $pt_usid="";$pt_acid="";$pt_date="";
    $sql = "SELECT pt_usid,pt_acid,pt_date FROM plan_trip ";
    $query = $conn->query($sql);
    $update = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($update as $key => $value) {
        if(strtotime($today)>strtotime($value['pt_date'])){
            $pt_usid = $pt_usid . $value['pt_usid'] . ",";
            $pt_acid = $pt_acid . $value['pt_acid'] . ",";
            $pt_date = $pt_date . $value['pt_date'] . ",";
        }
    }

    if($pt_usid!="" && $pt_acid!="" && $pt_date!=""){
        $pt_usid = substr($pt_usid,0,-1);
        $pt_acid = substr($pt_acid,0,-1);
        $pt_date = substr($pt_date,0,-1);

        $pt_usid = explode(",", $pt_usid);
        $pt_acid = explode(",", $pt_acid);
        $pt_date = explode(",", $pt_date);

        $count=count($pt_usid);
        
        for($i=0 ; $i<$count ; $i++){
            $usid = $pt_usid[$i];
            $acid = $pt_acid[$i];
            $date = $pt_date[$i];
            $sql = "UPDATE plan_trip SET pt_status = 2 WHERE pt_date = '$date' and pt_usid = $usid and pt_acid = $acid ";
            $conn->exec($sql);
        }
    }

    $plan_count = "";
    if($us_admin=='Y'){
        $sql = "SELECT us_id,us_name,(select count(pt_name) from plan_trip where pt_usid = us_id) as pt_count FROM `user` WHERE us_admin NOT IN ('Y') ";
        $query = $conn->query($sql);
        $plan_count = $query->fetchAll(PDO::FETCH_ASSOC);
    }


    $usid="";
    $sql = "SELECT DISTINCT pt_name,pt_date,pt_hours,pt_spend,pt_status,pt_usid,pt_usname FROM plan_trip ";
    if($us_admin!='Y'){
        $id = $user['us_id'];
        $usid = " WHERE pt_usid='$id'";
    }

    $query = $conn->query($sql.$usid);
    $plan = $query->fetchAll(PDO::FETCH_ASSOC);

    
    


    $sql = "SELECT pt_usid,pt_name
    ,(select ac_name from activity where pt_acid = ac_id) as ac_name 
    ,(select ac_id from activity where pt_acid = ac_id) as type 
    ,(select name from activity,activity_types where pt_acid = ac_id and ac_type = type_id) as ac_type 
    ,(select ac_weather from activity where pt_acid = ac_id) as ac_weather 
    ,(select ac_drive from activity where pt_acid = ac_id) as ac_drive 
    ,(select ac_carry from activity where pt_acid = ac_id) as ac_carry 
    ,(select ac_spend from activity where pt_acid = ac_id) as ac_spend 
    ,(select ac_hours from activity where pt_acid = ac_id) as ac_hours 
    FROM plan_trip ";

    $query = $conn->query($sql.$usid);
    $plan_trip = $query->fetchAll(PDO::FETCH_ASSOC);
?>