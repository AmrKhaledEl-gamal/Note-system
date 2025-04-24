<?php
require_once 'assets/php/session.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=ucfirst(basename($_SERVER['PHP_SELF'], '.php'));?>|Amr Khaled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.2.2/datatables.min.css" rel="stylesheet" integrity="sha384-M6C9anzq7GcT0g1mv0hVorHndQDVZLVBkRVdRb2SsQT7evLamoeztr1ce+tvn+f2" crossorigin="anonymous">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400..900&display=swap');
    *{
    font-family: 'Maven Pro', sans-serif;
}
    </style>
</head>

<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="fas fa-code fa-2x"></i>&nbsp;&nbsp;
    Amr Khaled</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?=(basename($_SERVER['PHP_SELF']) == 'home.php')?'active':'';?>" href="home.php"><i class="fas fa-home"></i>&nbsp;Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(basename($_SERVER['PHP_SELF']) == 'profile.php')?'active':'';?>" href="profile.php"><i class="fas fa-user-circle"></i>&nbsp;Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(basename($_SERVER['PHP_SELF']) == 'feedback.php')?'active':'';?>" href="feedback.php"><i class="fas fa-comment-dots"></i>&nbsp;feedback</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=(basename($_SERVER['PHP_SELF']) == 'notification.php')?'active':'';?>" href="notification.php"><i class="fas fa-bell"></i>&nbsp;Notification &nbsp;<span id ="checkNotification"></span></a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user-cog fa-2x"></i>&nbsp;&nbsp;
            Hi!  <?= $fname;?>
            </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#"><i class="fas fa-cog"></i>&nbsp;
            Settings</a> 
            <a class="dropdown-item" href="assets/php/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;
            Logout</a> 
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>