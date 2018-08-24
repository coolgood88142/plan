<html>
  <head>
    <title>規劃行程系統</title>
  </head>
  <body>
  
    <form name="loginForm" method="post">
        帳號: <input type="text" name="us_account" /><br/><br/>

        密碼: <input type="password" name="us_password" /><br/><br/>

　      <input type="button" value="登入" onClick="sign_in()"/>
        <input type="button" value="建立" onClick="setup()"/>
    </form>  
 

  </body>
  <script language="JavaScript">
    function sign_in(){
      document.loginForm.action="sign_in.php"; 
	    document.loginForm.submit();
    }

    function setup(){
      document.loginForm.action="setup.php"; 
	    document.loginForm.submit();
    }
  </script>
</html>

