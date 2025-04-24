<?php
require_once 'assets/php/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card rounded-0 mt-3 border-primary">
                <div class="card-header border-primary">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active fw-bold" data-bs-toggle= "tab">profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#editProfile" class="nav-link  fw-bold" data-bs-toggle= "tab">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#changePass" class="nav-link fw-bold" data-bs-toggle= "tab">Chang Password</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <!-- Profile Tab Content Start-->
                        <div class="tab-pane container active" id="profile">
                            <div class="row">
                                <div class="col-md-5 d-flex">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-light text-center lead">
                                            User ID: <?=$cid;?>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;"><b>Name: </b><?=$cname;?> </p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">E-mail: <?=$cemail;?></p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">Gender: <?=$cgender;?></p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">Date of Birth: <?=$cdob;?></p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">phone: <?=$cphone;?></p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">Registered on: <?=$reg_on;?></p>
                                            <p class="card-text p-2 m-1 rounded "style="border:1px solid #0275d8;">E-mail Verified: <?=$verified;?>
                                                <?php if($verified == 'Not verified'): ?>
                                                    <a href="#" id = "verify-email" class="float-right">Verify Now</a>
                                                    <?php endif; ?>
                                            </p>
                                            <div class="Flexbox"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex">
                                    <div class="card border-primary align-self-center">
                                        <?php if(!$cphoto): ?>
                                            <img src="assets/img/Avatar.png" class="img-thumbnail img-fluid" width="408px">
                                            <?php else: ?>
                                                <img src="<?='assets/php/'.$cphoto?>" class="img-thumbnail img-fluid" width="408px">
                                                <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Tab Content End-->

                        <!-- Edit Profile Tab Content Start-->
                        <div class="tab-pane container fade" id="editProfile">
                            <div id="verifyEmailAlert"></div>
                            <div class="d-flex">
                                <div class="card border-danger align-self-center">
                                    <?php if(!$cphoto): ?>
                                        <img src="assets/img/Avatar.png" class="img-thumbnail img-fluid" width="408px">
                                        <?php else: ?>
                                                <img src="<?='assets/php/'.$cphoto?>" class="img-thumbnail img-fluid" width="408px">
                                        <?php endif; ?>
                                </div>
                                <div class="card border-danger">
                                    <form action="#" method="POST" class="px-3 mt-2" enctype="multipart/form-data" id = "profile-update-form"> 
                                        <input type="hidden" name="oldimage" value="<?=$cphoto?>">
                                        <div class="form-group m-0">
                                            <label for="profilePhoto" class="m-1">Upload Profile Photo</label>
                                            <input type="file" name="image" id="profilePhoto" >
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="name" class="m-1">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" value="<?=$cname?>" >
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="gender" class="m-1">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="" disabled <?php if($cgender == null): ?> selected <?php endif; ?>>Select</option>
                                                <option value="male" <?php if($cgender == 'male'): ?> selected <?php endif; ?>>Male</option>
                                                <option value="female" <?php if($cgender == 'female'): ?> selected <?php endif; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-0">
                                            <label for="dob" class="m_1">Date of Birth</label>
                                            <input type="date" name="dob" id="dob" class="form-control" value="<?=$cdob?>">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="phone" class="m_1">Phone</label>
                                            <input type="tel" name="phone" id="phone" class="form-control" value="<?=$cphone?>" placeholder="Enter Phone Number">
                                        </div>

                                        <div class="form-group m-2">
                                            <input type="submit" name="profile_update" id="profileUpdateBtn" class="btn btn-danger btn-block w-100" value="Update Profile">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Profile Tab Content End-->

                        <!-- Change Password Tab Content Start-->
                        <div class="tab-pane container fade" id="changePass">
                            <div id="changepassAlert"></div>
                            <div class="d-flex">
                                <div class="card border-success w-100">
                                    <div class="card-header bg-success text-white text-center ">Change Password</div>
                                    <form action="#" method="POST" class="px-3 mt-2" id = "change-pass-form">
                                        <div class="form-group mb-3">
                                            <label for="curpass">Enter Current Password</label>
                                            <input type="password" name="curpass" placeholder="Current Password" id="curpass" class="form-control form-control-lg" required minlength="5">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="newpass">Enter New Password</label>
                                            <input type="password" name="newpass" placeholder="New Password" id="newpass" class="form-control form-control-lg" required minlength="5">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cnewpass">Enter New Password</label>
                                            <input type="password" name="cnewpass" placeholder="Confirm New Password" id="cnewpass" class="form-control form-control-lg" required minlength="5">
                                        </div>
                                        <div class="form-group">
                                            <p id="changePassError" class="text-danger"></p>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="submit" name="changepass" id="changePassBtn" class="btn btn-success btn-lg btn-block w-100" value="Change Password">
                                        </div>

                                    </form>
                                </div>
                                <div class="card border-success align-self-center">
                                    <img src="assets/img/pass-change.png " class="img-thumbnail img-fluid" width="405px">
                                </div>
                            </div>
                        </div>
                        <!-- Change Password Tab Content End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#profile-update-form").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success:function(response){
                    location.reload();
                }
            })
        })
        //Change password Ajax Request 
        $("#changePassBtn").click(function(e){
            if($("#change-pass-form")[0].checkValidity()){
                e.preventDefault();
                $("#changePassBtn").val("Please wait...");

                if ($("#newpass").val() != $("#cnewpass").val()){
                    $("#changePassError").text('* password do not match!');
                    $("#changePassBtn").val("Change Password");  
                }
                else{
                    $.ajax({
                        url: 'assets/php/process.php',
                        method: 'post',
                        data: $("#change-pass-form").serialize()+'&action=change_pass',
                        success: function(response){
                            $("#changepassAlert").html(response);
                            $("#changePassBtn").val("Change Password");  
                            $("#changePassError").text('');
                            $("#change-pass-form")[0].reset();
                        }
                    })
                }
            }
        })

        // Verify Email Ajax Request
        $("#verify-email").click(function(e){
            e.preventDefault();
            $(this).text('please Wait...');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'POST',
                data: {action: 'verify-email'},
                success: function(response){
                    $("#verifyEmailAlert").html(response);
                    $("#verify-email").text('Verify Email');
                }
            })
        });
                //Check NOtification
                checkNotification(); 
        function checkNotification(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {action:'checkNotification'},
                success:function(response){
                    console.log(response);
                        $("#checkNotification").html(response);
                    // }
                }
            })
        } 
    })
</script>
</body>

</html>