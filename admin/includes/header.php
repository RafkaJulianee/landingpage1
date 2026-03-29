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
    <title>Dashboard Admin</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #5c4dff; /* Vibrant purple/blue */
            --primary-light: #f0edff;
            --bg-color: #f4f7fa; 
            --sidebar-bg: #ffffff;
            --text-main: #1d1d29;
            --text-muted: #8c9097;
            --card-bg: #ffffff;
            --border-radius-lg: 24px;
            --border-radius-md: 12px;
        }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--bg-color); 
            color: var(--text-main);
        }
        
        /* Sidebar Styling */
        .sidebar { 
            background: var(--sidebar-bg); 
            box-shadow: 2px 0 10px rgba(0,0,0,0.02); 
            padding-top: 30px; 
            min-height: 100vh;
            border-right: 1px solid #f0f0f0;
        }
        .sidebar .brand {
            margin-bottom: 40px;
            font-weight: 700;
            color: var(--text-main);
        }
        .sidebar .brand i {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .sidebar a.nav-link { 
            color: var(--text-muted); 
            text-decoration: none; 
            padding: 14px 20px; 
            display: flex; 
            align-items: center;
            border-radius: var(--border-radius-md); 
            transition: all 0.2s ease-in-out; 
            margin: 5px 25px; 
            font-weight: 500;
            font-size: 0.95rem;
        }
        .sidebar a.nav-link:hover, .sidebar a.nav-link.active { 
            background: var(--primary-color); 
            color: white; 
            box-shadow: 0 4px 12px rgba(92, 77, 255, 0.3);
        }
        .sidebar i { 
            margin-right: 12px; 
            font-size: 1.25rem; 
        }

        /* Topbar & Content */
        .content { 
            padding: 30px 45px; 
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            background: var(--card-bg);
            padding: 18px 30px;
            border-radius: 100px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }
        .topbar-search {
            position: relative;
            width: 350px;
        }
        .topbar-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .topbar .search-bar {
            background: #f8f9fc;
            border: none;
            border-radius: 50px;
            padding: 10px 20px 10px 45px;
            width: 100%;
            color: var(--text-main);
            font-size: 0.9rem;
        }
        .topbar .search-bar:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-light);
        }
        .topbar-right {
            display: flex;
            align-items: center;
        }
        .topbar-date {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 30px;
        }
        .topbar-icons i {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-left: 20px;
            cursor: pointer;
            transition: 0.2s;
        }
        .topbar-icons i:hover { color: var(--primary-color); }
        .topbar-profile {
            width: 42px; height: 42px; border-radius: 50%;
            margin-left: 20px; object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Cards */
        .card { 
            border: none; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.03); 
            border-radius: var(--border-radius-lg); 
            margin-bottom: 25px; 
            background: var(--card-bg);
        }
        .card-header { 
            background: transparent; 
            border-bottom: none; 
            font-weight: 600; 
            padding: 25px 30px 10px 30px; 
            font-size: 1.15rem;
            color: var(--text-main);
        }
        .card-body { 
            padding: 25px 30px; 
        }

        /* Inputs & Buttons */
        .form-label { font-weight: 500; font-size: 0.9rem; color: #444; }
        .form-control, .form-select {
            border-radius: var(--border-radius-md);
            border: 1px solid #eaebf0;
            padding: 12px 18px;
            font-size: 0.95rem;
            background: #fdfdfd;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px var(--primary-light);
            border-color: var(--primary-color);
            background: white;
        }
        .btn-primary { 
            background-color: var(--primary-color); 
            border-color: var(--primary-color); 
            border-radius: var(--border-radius-md);
            font-weight: 500;
            padding: 12px 28px;
            box-shadow: 0 4px 12px rgba(92, 77, 255, 0.2);
        }
        .btn-primary:hover { 
            background-color: #4835e0; 
            border-color: #4835e0; 
            box-shadow: 0 6px 15px rgba(92, 77, 255, 0.3);
        }
        .btn-danger {
            background-color: #ff5252;
            border-color: #ff5252;
            border-radius: var(--border-radius-md);
            box-shadow: 0 4px 12px rgba(255, 82, 82, 0.2);
        }
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: var(--border-radius-md);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
        }
        .btn-outline-danger {
            border-radius: var(--border-radius-md);
        }

        /* Badges / Status */
        .badge { padding: 8px 12px; border-radius: 6px; font-weight: 500; }
        .bg-secondary { background: #f0f1f5 !important; color: #495057 !important; }

        /* Tables */
        .table-responsive { overflow-x: auto; }
        .table { margin-bottom: 0; border-collapse: separate; border-spacing: 0 10px; }
        .table thead th { 
            border-bottom: none; 
            color: var(--text-muted); 
            font-weight: 500; 
            text-transform: uppercase; 
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 0 15px 10px 15px;
        }
        .table tbody tr {
            background-color: #fafbfc;
            border-radius: var(--border-radius-md);
            transition: 0.2s;
        }
        .table tbody tr:hover { background-color: var(--primary-light); transform: translateY(-1px); }
        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            color: var(--text-main);
            font-size: 0.95rem;
            border: none;
        }
        .table tbody td:first-child { border-top-left-radius: var(--border-radius-md); border-bottom-left-radius: var(--border-radius-md); }
        .table tbody td:last-child { border-top-right-radius: var(--border-radius-md); border-bottom-right-radius: var(--border-radius-md); }
        
        /* Modern Alert */
        .alert { border-radius: var(--border-radius-md); border: none; }
        .alert-success { background-color: #e5fbe7; color: #1b8a36; }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0 flex-nowrap">
