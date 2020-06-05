<?php
    session_start();
    session_destroy();
    var_dump($_SESSION);
    header("Location: index.php");
?>