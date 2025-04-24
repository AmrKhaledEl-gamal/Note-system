<?php 
    session_start();
    if(isset($_SESSION['username'])){
        header('location:admin-dashboard.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style type="text/css">
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="card border-danger shadow-lg">
                    <div class="card-header bg-danger">
                        <h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;Admin panel login</h3>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" class="px-3" id = "admin-login-form">
                            <div id="adminLoginAlert"></div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg rounded-0"  name="username" placeholder="Username" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="password" class="form-control form-control-lg rounded-0"  name="password" required placeholder="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounded-0 w-100" value="login" id="adminLoginBtn"><i class="fas fa-sign-in-alt"></i>&nbsp;Login</button>
                            </div>
                        </form>
                        
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#adminLoginBtn").click(function(e){
                if($("#admin-login-form")[0].checkValidity()){
                    e.preventDefault();

                    $(this).val('Please wait...');
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'POST',
                        data: $("#admin-login-form").serialize() + "&action=adminLogin",
                        success: function(response){
                            if(response =='admin_login'){
                                window.location = 'admin-dashboard.php'
                            }
                            else{
                                $("#adminLoginAlert").html(response);
                            }
                            $(this).val('Login');
                        }
                    })
                }
            })
        })
    </script>
</body>
</html>