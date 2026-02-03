<?php
session_start();

require_once '../includes/auth_check.php';
checkAuth();

$status = $_GET['status'] ?? 'error';

require_once '../views/payment_result_v.php';
?>
