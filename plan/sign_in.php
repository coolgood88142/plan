<?php
    include("mysql.php");
    $us_account = $_POST['us_account'];
    $us_password= $_POST['us_password'];


    $sql = "select us_name,us_password,us_admin from user where us_account='" . $us_account  ."'";
        
    $query = $conn->query($sql);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    if(password_verify($us_password,$row['us_password'])){
        session_start();
        $_SESSION['us_account'] = $us_account;      //帳號
        $_SESSION['us_name'] = $row['us_name'];     //使用者姓名   
        $_SESSION['us_admin'] = $row['us_admin'];   //是否有權限

        //登入後更新登入時間
        date_default_timezone_set('Asia/Taipei');
        $datetime = date ("Y-m-d H:i:s");
        $sql = "update user set us_last_login = '$datetime' where us_account='$us_account'"  ;
        $conn->exec($sql);
    }
?>
<script language="JavaScript">
    location.href = "activity.php";
</script>