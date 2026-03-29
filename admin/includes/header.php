<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zifood Admin Panel</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; padding-top: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-radius: 6px; transition: 0.2s; margin: 5px 15px; }
        .sidebar a:hover, .sidebar a.active { background: #e63946; color: white; }
        .sidebar i { margin-right: 12px; font-size: 1.1rem; width: 20px; text-align: center; }
        .content { padding: 30px; background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-radius: 10px; margin-bottom: 25px; }
        .card-header { background: #fff; border-bottom: 1px solid #f1f1f1; font-weight: 600; padding: 18px 25px; border-radius: 10px 10px 0 0 !important; color: #333; }
        .card-body { padding: 25px; }
        .btn-primary { background-color: #e63946; border-color: #e63946; }
        .btn-primary:hover { background-color: #d62828; border-color: #d62828; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
