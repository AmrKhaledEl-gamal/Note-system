
<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('location:home.php');
    }

    include_once 'assets/php/config.php';
    $db = new Database();
    $sql = "UPDATE visitors SET hits = hits + 1 WHERE id = 0";
    $stmt = $db->conn->prepare($sql);
    $stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- login form start -->
        <div class="wrapper row justify-content-center my-auto" id="login-box">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <!-- الجزء الخاص بتسجيل الدخول -->
                    <div class="card rounded-left shadow-lg" style="flex-grow:1.4;">
                        <div class="card-body">
                            <h1 class="text-center fw-bold text-primary">Sign in to Account</h1>
                            <hr class="my-3">
                            <form action="login.php" method="POST" class="px-3" id="login-form">
                                <div id="loginAlert"></div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="far fa-envelope fa-2x"></i>
                                    </span>
                                    <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-Mail" required autocomplete="off" value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>">
                                </div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="fas fa-key fa-2x"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password" required autocomplete="off" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>">
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="customCheck" <?php if(isset($_COOKIE['email'])) { ?> checked <?php } ?>>
                                        <label for="customCheck" class="form-check-label">Remember Me</label>
                                    </div>
                                    <div class="forgot float-end mb-3">
                                        <a href="#" id="forgot-link">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-lg w-100 myBtn" value="Sign In" id="login-btn">
                                </div>
                            </form> 
                        </div>
                    </div>

                    <!-- الجزء الخاص بـ "Hello Friend" -->
                    <div class="card myColor">
                        <h1 class="text-center fw-bold text-white">Hello Friend</h1>
                        <hr class="my-3 bg-light myHr">
                        <p class="text-center fw-bold text-light lead">Enter your personal details and start your journey with us</p>
                        <button class="btn btn-lg btn-outline-light align-self-center fw-bold mt-4 myLinkBtn" id="register-link">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- login form end -->
        
        <!-- register form start -->
        <div class="wrapper row justify-content-center my-auto" id="register-box" style="display:none ;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow"> 
                    <!-- الجزء الخاص بـ "Hello Friend" -->
                    <div class="card myColor">
                        <h1 class="text-center fw-bold text-white">Welcome back</h1>
                        <hr class="my-3 bg-light myHr">
                        <p class="text-center fw-bold text-light lead">To keep connected with us please login with your personal info</p>
                        <button class="btn btn-lg btn-outline-light align-self-center fw-bold mt-4 myLinkBtn" id="login-link">Sign In</button>
                    </div>
                    <!-- الجزء الخاص بتسجيل الدخول -->
                    <div class="card rounded-left shadow-lg" style="flex-grow:1.4;">
                        <div class="card-body">
                            <h1 class="text-center fw-bold text-primary">Create Account</h1>
                            <hr class="my-3">
                            <form action="#" method="POST" class="px-3" id="register-form">
                                <div id="regAlert"></div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="far fa-user fa-2x"></i>
                                    </span>
                                    <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Full Name" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="far fa-envelope fa-2x"></i>
                                    </span>
                                    <input type="email" name="email" id="remail" class="form-control rounded-0" placeholder="E-Mail" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="fas fa-key fa-2x"></i>
                                    </span>
                                    <input type="password" name="password" id="rpassword" class="form-control rounded-0" placeholder="Password" required minlength="5" autocomplete="off">
                                </div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="fas fa-key fa-2x"></i>
                                    </span>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Confirm Password" required minlength="5" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <div id = "passError" class = "text-danger fw-bold"></div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-lg w-100 myBtn" value="Sign up" id="register-btn">
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- register form end -->

        <!-- forgot password form start -->
        <div class="wrapper row justify-content-center my-auto" id="forgot-box" style="display:none ;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <!-- الجزء الخاص بـ "Hello Friend" -->
                    <div class="card myColor">
                        <h1 class="text-center fw-bold text-white">Reset password</h1>
                        <hr class="my-3 bg-light myHr">
                        <button class="btn btn-lg btn-outline-light align-self-center fw-bold mt-4 myLinkBtn" id="back-link">Back</button>
                    </div>
                    <!-- الجزء الخاص بتسجيل الدخول -->
                    <div class="card rounded-left shadow-lg" style="flex-grow:1.4;">
                        <div class="card-body">
                            <h1 class="text-center fw-bold text-primary">Forgot Your Password</h1>
                            <hr class="my-3">
                            <p class="lead text-center text-secondary">Enter your email address to reset your password</p>
                            <form action="#" method="POST" class="px-3" id="Forgot-form">
                            <div id="forgotAlert"></div>
                                <div class="input-group input-group-lg form-group mb-3">
                                    <span class="input-group-text rounded-0 px-3">
                                        <i class="far fa-envelope fa-2x"></i>
                                    </span>
                                    <input type="email" name="email" id="femail" class="form-control rounded-0" placeholder="E-Mail" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-lg w-100 myBtn" value="Reset Password" id="forgot-btn">
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- forgotPassword form end  -->
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#register-link").click(function(){
                $("#login-box").hide();
                $("#register-box").show();
            });
            $("#login-link").click(function(){
                $("#login-box").show();
                $("#register-box").hide();
            });
            $("#forgot-link").click(function(){
                $("#login-box").hide();
                $("#forgot-box").show();
            });
            $("#back-link").click(function(){
                $("#login-box").show();
                $("#forgot-box").hide();
            });
        // Register Ajax Request
            $("#register-btn").click(function(e){
                if($("#register-form")[0].checkValidity()){
                    e.preventDefault();
                    $("#register-btn").val("Please wait...");
                    if($("#rpassword").val() != $("#cpassword").val()){
                        $("#passError").text("Password does not match");
                        $("#register-btn").val("Sign Up");
                    }else{
                        $("#passError").text("");
                        $.ajax({
                            url: 'assets/php/action.php',
                            method: 'post',
                            data: $("#register-form").serialize()+'&action=register',
                            success: function(response){
                                $("#register-btn").val("Sign Up");
                                if(response ==='register'){
                                    window.location = 'home.php';
                                }else{
                                    $("#regAlert").html(response);
                                }
                            }
                        })
                    }
                }
            });
            //LOGIN AJAX REQUEST
            $("#login-btn").click(function(e){
                if($("#login-form")[0].checkValidity()){
                    e.preventDefault();

                        $("#login-btn").val("Please wait...");
                        $.ajax({
                            url: 'assets/php/action.php',
                            method: 'post',
                            data: $("#login-form").serialize() + '&action=login',
                            success: function(response){
                                $("#login-btn").val("Sign In");
                                if(response === 'login'){  // تأكد أن الرد هو 'login'
                                    window.location = 'home.php';
                                } else {
                                    $("#loginAlert").html(response);
                                }
                            }
                    });
                }
            });
            //FORGOT AJAX REQUEST
            $("#forgot-btn").click(function(e){
                if($("#Forgot-form")[0].checkValidity()){
                    e.preventDefault();

                        $("#forgot-btn").val("Please wait...");

                        $.ajax({
                            url: 'assets/php/action.php',
                            method: 'post',
                            data: $("#Forgot-form").serialize() + '&action=forgot',
                            success: function(response){
                                $("#forgot-btn").val("Reset password");
                                $("#Forgot-form")[0].reset();
                                $("#forgotAlert").html(response);
                                
                            }
                    });
                } 
            });
        });
    </script>
</body>
</html>