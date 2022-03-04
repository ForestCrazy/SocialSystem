<?php
session_start();
ob_start();
$connect = mysqli_connect("localhost", "root", "", "social_network");