<?php
    session_start();
    include("mysql.php");

    $pt_name = $_POST['pt_name'];
    $pt_date = $_POST['pt_date'];
    $pt_usid = $_POST['pt_usid'];
    $pt_usname = $_POST['pt_usname'];

    $type = $_POST['type'];
    $type = explode(",", $type);
    $count=count($type); 

    if($count>0){
        for($i=0 ; $i<$count ; $i++){
            $acid = $type[$i];
            if($acid!="" && $acid!=null){
                $sql = "UPDATE plan_trip SET pt_name='$pt_name',pt_date = '$pt_date' WHERE pt_usid = $pt_usid and pt_acid = $acid ";
                $conn->exec($sql);
            }
        }
    }

    $isdelete = $_POST['isdelete'];
    $isdelete = explode(",", $isdelete);
    $de_acspend = (int)$_POST['de_acspend'];
    $de_achours = (int)$_POST['de_achours'];

    $count=count($isdelete);

    if($count>0){
        $sql = "SELECT count(*) as count,pt_hours,pt_spend FROM plan_trip WHERE pt_date = '$pt_date' and pt_usid = $pt_usid ";
        $query = $conn->query($sql);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $spend = (int)$user['pt_spend'];
        $hour= (int)$user['pt_hours'];                 

        if($de_achours>$hour){
            $de_achours = $de_achours - $hour;
        }else if($de_achours<$hour){
            $de_achours = $hour - $de_achours;
        }

        if($de_acspend>$spend){
            $de_acspend = $de_acspend - $spend;
        }else if($de_acspend<$spend){
            $de_acspend = $spend - $de_acspend;
         }

        $math = $user['count'];
        if($math>0){
            $sql = "UPDATE plan_trip SET pt_spend = $de_acspend,pt_hours = $de_achours WHERE pt_date = '$pt_date' and pt_usid = $pt_usid";
            $conn->exec($sql);
        }

        for($i=0 ; $i<$count ; $i++){
            if($isdelete[$i]=="true"){
                $acid = $type[$i];
                if($acid!="" && $acid!=null){
                    $sql = "DELETE FROM plan_trip WHERE pt_usid = $pt_usid and pt_acid = $acid ";
                    $conn->exec($sql);
                }
            }
        }
    }
    

    $ad_acspend = (int)$_POST['ad_acspend'];
    $ad_achours = (int)$_POST['ad_achours'];

    $ad_acid = $_POST['ad_acid'];
    $ad_acid = explode(",", $ad_acid);

    $us_id = "";
    $us_name = "";

    if(isset($_POST['us_id'])){
        $us_id = $_POST['us_id'];
    }

    if(isset($_POST['us_name'])){
        $us_name = $_POST['us_name'];
    }


    $count=count($ad_acid);

    if($count>0){
        if($us_id!="" && $us_name!=""){
            $pt_usid = $us_id;
            $pt_usname = $us_name;
        }else{
            $sql = "SELECT count(*) as count,pt_hours,pt_spend FROM plan_trip WHERE pt_date = '$pt_date' and pt_usid = $pt_usid ";
            $query = $conn->query($sql);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $hour= (int)$user['pt_hours'];
            $spend = (int)$user['pt_spend'];

            $ad_achours = $ad_achours + $hour;
            $ad_acspend = $ad_acspend + $spend;

            $math = $user['count'];
            if($math>0){
                $sql = "UPDATE plan_trip SET pt_spend = $ad_acspend,pt_hours = $ad_achours WHERE pt_date = '$pt_date' and pt_usid = $pt_usid";
                $conn->exec($sql);
            }
        }

        for($i=0 ; $i<$count ; $i++){
            $acid = $ad_acid[$i];
            if($acid!="" && $acid!=null){
                $sql = "INSERT INTO plan_trip (pt_acid, pt_name, pt_hours, pt_spend, pt_date, pt_usid, pt_usname, pt_status)
                VALUES ($acid, '$pt_name', $ad_achours, $ad_acspend, '$pt_date', $pt_usid, '$pt_usname', 1)";
                $conn->exec($sql);
            }
        }
    }

    $us_admin = $_SESSION['us_admin'];
    if($us_admin=='Y'){
        echo '<meta http-equiv=REFRESH CONTENT=0;url=plan_admin.php>';
    }else{
        echo '<meta http-equiv=REFRESH CONTENT=0;url=plan.php>';
    }
?>