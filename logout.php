<style>
  body {
    background-color: #2a2a2a;
  }
</style>
<?php 
session_start();
session_destroy();
header( "refresh:0; url=/" ); 
?>