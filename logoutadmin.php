<?php
session_start();
session_destroy();
header("Location: adminsignin.php");