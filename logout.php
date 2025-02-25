<?php
session_start();
session_destroy(); 
header("Location: ./StageFolder/signin.php"); 
exit();

?>
