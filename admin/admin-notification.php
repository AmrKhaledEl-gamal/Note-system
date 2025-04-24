<?php
require_once 'assets/php/admin-header.php';
?>


    <div class="row justify-content-center my-2">
        <div class="col-lg-6 mt-4" id = "showNotification">

        </div>
    </div>

<!-- footer Area -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){

            //Fetch Notification Ajax Request
            fetchNotification();
            function fetchNotification(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action: 'fetchNotification'},
                    success:function(response){
                        $('#showNotification').html(response)
                    }
                })
            }
            //check Notification
            checkNotification();

            function checkNotification(){
                $.ajax({
                    url:'assets/php/admin-action.php',
                    method: 'post',
                    data:{action: 'checkNotification'},
                    success:function(response){
                        console.log(response)
                        $("#checkNotification").html(response)
                    }
                }
                )
            }
        //Remove Notification
        $("body").on("click", ".btn-close", function(e){
            e.preventDefault();

            notification_id = $(this).attr("id");
            // console.log("notification_id: ", notification_id); // دي علشان تتأكد إنه بيطلع فعلاً

            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {notification_id: notification_id},
                success:function(response){
                    // console.log("Response from remove:", response); // تشوف الريسبونس
                    checkNotification();
                    fetchNotification();
                }
            });
        }) 
        })
    </script>
    </body>
</html>