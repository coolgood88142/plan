<?php
    session_start();
    session_unset( );
    session_destroy( );
?>
<script language="JavaScript">
    location.href = "login.php";
</script>