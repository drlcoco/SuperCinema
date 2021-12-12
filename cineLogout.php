<?php
session_start(); // This permits to continue session.
if (isset ($_SESSION['login'])) {
         $_SESSION = array();
         session_destroy();
}
header("Location:login.php"); ?>