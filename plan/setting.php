<html>
  <head>
    <title>規劃行程系統</title>
  </head>
  <?php session_start();
        include("mysql.php"); ?>
  <body>

    <form name="showForm" method="post">
        <input type="button" value="活動行程" onClick="show('activity')"/>
        <input type="button" value="行程規劃" onClick="show('plan')"/>
        <input type="button" value="設定" onClick="show('setting')"/>
        &nbsp&nbsp
        Hi!<?php echo $_SESSION['us_name'];?>
        <input type="button" value="登出" onClick="show('sign_out')"/>
        <br/><br/>

        帳號: <?php echo $_SESSION['us_account'] ?><br/><br/>

        密碼: <input type="password" name="us_passwor" /><br/><br/>

        請在輸入一次密碼: <input type="password" name="us_password" /><br/><br/>

        姓名: <input type="text" name="us_name" /><br/><br/>

        性別: <input type="radio" name="us_gender" value="R" checked>男&nbsp
        <input type="radio" name="us_gender" value="">女<br/><br/>

        電子信箱: <input type="text" name="us_email" /><br/><br/>

    </form>  
  </body>
  <script language="JavaScript">
    function show(page){
        document.showForm.action=page+".php"; 
        document.showForm.submit();
    }
  </script>
</html>

