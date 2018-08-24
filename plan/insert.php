<?php
    session_start();
    include("mysql.php");

    $us_account = $_POST['us_account'];
    $us_password= $_POST['us_password'];
    $us_password = password_hash($us_password, PASSWORD_DEFAULT);

    date_default_timezone_set('Asia/Taipei');
    $datetime = date ("Y-m-d H:i:s");

    $sql = "INSERT INTO user (us_account, us_password, us_name, us_gender, us_admin, us_status, us_email, us_last_login)
        VALUES ('$us_account', '$us_password', '', '', 'N', 1, '', '$datetime')";
        

    $conn->exec($sql);
    $conn=null;
?>
<script language="JavaScript">
        location.href = "login.php";
</script>