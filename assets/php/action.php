<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

require_once 'auth.php';
$user = new Auth();

//handle register Ajax request
if (isset($_POST['action'])&& $_POST['action'] == 'register') {
    $name = $user->test_input($_POST['name']); 
    $email = $user->test_input($_POST['email']);
    $password = $user->test_input($_POST['password']);
    $hpassword = password_hash($password, PASSWORD_DEFAULT);
    if($user->user_exist($email)) {
        echo $user->showMessage('warning', 'Email already exist!');
    } else {
        if($user->register($name, $email, $hpassword)) {
            echo 'register';
            $_SESSION['user'] = $email;
        } else {
            echo $user->showMessage('danger', 'Registration failed!');
        }
    }
}

//handle login Ajax request

if (isset($_POST['action'])&& $_POST['action'] == 'login') {
    $email = $user->test_input($_POST['email']);
    $password = $user->test_input($_POST['password']);
    
    $loggedInUser = $user->login($email);

    if($loggedInUser != null) {
        if(password_verify($password, $loggedInUser['password'])) {
            if(!empty($_POST['remember'])) {
                setcookie("email",$email, time()+(30*24*60*60), '/');
                setcookie("password",$password, time()+(30*24*60*60), '/');
            }else{
                setcookie("email","", 1, '/');
                setcookie("password","",1, '/');
            }
            echo 'login';
            $_SESSION['user'] = $email;
        }else{
            echo $user->showMessage('danger', 'Invalid password!');
        }
    }else{
        echo $user->showMessage('danger', 'Email not found!');
    } 
}

//handle forgot password Ajax request
if (isset($_POST['action'])&& $_POST['action'] == 'forgot') {
    $email = $user->test_input($_POST['email']);

    $user_found = $user->currentUser($email);

    if($user_found != null) {
        $token = uniqid();
        $token = str_shuffle($token);
        $user->forgot_password($token, $email); 

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = Database::USERNAME;
            $mail->Password = Database::PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->setFrom(Database::USERNAME, "DCodeMania");
            $mail->addAddress($email); // حط هنا الإيميل اللي عاوز تبعت له
        
            $mail->isHTML(true);
            $mail->Subject = "Reset Password";
            $mail->Body = '<h3> Click the below link to reset your password <br> 
        <a href="http://localhost/USER_SYSTEM/reset-pass.php?email='.$email.'&token='.$token.'">http://localhost/USER_SYSTEM/reset-pass.php?email='.$email.'&token='.$token.'</a> 
        <br>Regards<br>DCodeMania!</h3>';
        
            $mail->send();
            echo $user->showMessage('success', 'Check your email to reset your password!');
        } catch (Exception $e) {
            echo $user->showMessage('danger', 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
        }
        
    }else{
        echo $user->showMessage('info', 'This email is not registered!');
    }
}

//Checking User is logged or not 
if (isset($_POST['action'])&& $_POST['action'] == 'checkUser') {
    if(!$user->currentUser($_SESSION['user'])){
        echo 'bye';
        unset($_SESSION['user']);
    }
}
