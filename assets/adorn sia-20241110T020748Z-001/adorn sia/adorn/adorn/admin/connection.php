<?php
session_start();
$link=mysqli_connect("localhost", "root", "") or die (mysqli_error($link));
mysqli_select_db($link,"adorn") or die (mysqli_error($link));

