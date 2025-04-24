<?php
require_once 'assets/php/header.php';
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
            <?=""// if($verified == 'verified!'): ?>
                <div class="card border-primary">
                    <div class="card-header lead bg-primary text-white text-center">Send Feedback to Admin</div>
                    <div class="card-body">
                        <form action="#" method="POST"class="px-4" id = "feedback-form">
                            <div class="form-group mb-3">
                                <input type="text" name="subject" placeholder="Write your Subject Here" class="form-control form-control-lg rounded-0" required>
                            </div>
                            <div class="form-group mb-3">
                                <textarea name="feedback" class="form-control form-control-lg rounded-0" placeholder="Write your Feedback Here .... " rows="8" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="feedbackBtn" id = "feedbackBtn" class="btn btn-primary btn-block btn-lg rounded-0 w-100" value="Send Feedback">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript"> 
    $(document).ready(function(){
        //Handle Feedback Form Submission
        $("#feedbackBtn").on('click', function(e){
            if($("#feedback-form")[0].checkValidity()){
                e.preventDefault();

                $("this").val('Sending...');

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'POST',
                    data: $("#feedback-form").serialize() + "&action=feedback",
                    success:function(response){
                        console.log(response);
                        
                        $("#feedback-form")[0].reset();
                        $("#feedbackBtn").val('Send Feedback');
                        swal.fire({
                            title: 'Feedback Sent!',
                            type: 'success',
                            text: 'Your feedback has been sent to the admin.',
                        });
                    }
                });
                
            }
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
    });
</script>
</body>

</html>