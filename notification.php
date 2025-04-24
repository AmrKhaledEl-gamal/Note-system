<?php
require_once 'assets/php/header.php';
?>
<div class="container">
    <div class="row justify-content-center my-2">
        <div class="col-lg-6 mt-4" id="showAllNotification">

        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">
    //Fetch Notification of an User
    $(document).ready(function(){
        fetchNotification();
        function fetchNotification(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'POST',
                data: {action:'fetchNotification'},
                success:function(response){
                    $("#showAllNotification").html(response);
                    // console.log(response);
                }
            });
        }

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
        //Delete Notification
        $("body").on("click", ".btn-close", function(e){
            e.preventDefault();

            var notification_id = $(this).attr("id");
            // console.log("notification_id: ", notification_id); // دي علشان تتأكد إنه بيطلع فعلاً

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {notification_id: notification_id},
                success:function(response){
                    // console.log("Response from remove:", response); // تشوف الريسبونس
                    checkNotification();
                    fetchNotification();
                }
            });
        })
    });
</script>
</body>

</html>