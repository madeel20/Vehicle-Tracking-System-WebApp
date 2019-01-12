<?php
session_start();
session_unset();
header("Location: index.php"); /* Redirect browser */
exit();
session_destroy();
?>
