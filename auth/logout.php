<link rel="stylesheet" href="/styles/login.css">
<?php 
session_start();
session_destroy();
header( "refresh:0; url=/" ); 
?>