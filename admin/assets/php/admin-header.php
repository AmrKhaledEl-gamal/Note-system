<?php
    session_start();
        if(!isset($_SESSION['username'])){
            header('location:index.php');
            exit();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $title = basename($_SERVER['PHP_SELF'], ".php");
    $title = explode("-", $title);
    $title = ucfirst($title[1]);
    ?>
    <title><?=$title;?> | Admin panel</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .admin-nav {
        width: 250px;
        min-height: 100vh;
        background-color: #343a40;
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }

    .admin-nav h4 {
        background-color: #212529;
        margin-bottom: 0;
    }

    .list-group-item.admin-link {
        background-color: transparent;
        border: none;
        color: #ced4da;
        transition: all 0.2s ease-in-out;
        font-size: 16px;
        padding: 12px 20px;
    }

    .list-group-item.admin-link i {
        width: 25px;
    }

    .list-group-item.admin-link:hover,
    .list-group-item.admin-link.active {
        background-color:rgb(5, 20, 34);
        color: #fff;
    }

    /* Remove bottom border to avoid white lines */
    .list-group-item {
        border: none !important;
    }
    .animate{
        width:0;
        transition: all 0.3s ease-in-out;
    }
</style>

</head>
<body>
    <div class="container-fluid"> 
        <div class="row"> 
            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Admin Panel</h4>

                <div class="list-group list-group-flush">
                    <a href="admin-dashboard.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-dashboard.php')? "active":""?>"><i class=" fas fa-chart-pie"></i>&nbsp;
                    Dashboard</a>

                    <a href="admin-users.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-users.php')? "active":""?>"><i class=" fas fa-user-friends"></i>&nbsp;
                    Users</a>

                    <a href="admin-notes.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-notes.php')? "active":""?>"><i class=" fas fa-sticky-note"></i>&nbsp;
                    Notes</a>

                    <a href="admin-feedback.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-feedback.php')? "active":""?>"><i class=" fas fa-comment-note"></i>&nbsp;
                    feedback</a>

                    <a href="admin-notification.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-notification.php')? "active":""?>"><i class=" fas fa-bell"></i>&nbsp;
                    Notification &nbsp;<span id="checkNotification"></span></a>

                    <a href="admin-deleteduser.php" class="list-group-item text-light admin-link <?=(basename($_SERVER['PHP_SELF'])=='admin-deleteduser.php')? "active":""?>"><i class=" fas fa-user-slash"></i>&nbsp;
                    Deleted User</a>

                    <a href="assets/php/admin-action.php?export=excel" class="list-group-item text-light admin-link "><i class=" fas fa-table"></i>&nbsp;
                    Exports User</a>

                    <a href="#" class="list-group-item text-light admin-link"><i class=" fas fa-id-card"></i>&nbsp;
                    Profile</a>

                    <a href="#" class="list-group-item text-light admin-link "><i class=" fas fa-cog"></i>&nbsp;
                    Setting</a>

                </div>

            </div>
            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                        <a href="#" class = "text-white" id="open-nav">
                            <h3><i class="fas fa-bars"></i></h3>
                        </a>
                        <h4 class="text-light"><?=$title?></h4>
                        <a href="assets/php/logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                    </div>
                </div>

    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#open-nav").click(function(){
                $(".admin-nav").toggleClass('animate');
            })
        })
    </script>
