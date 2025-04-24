<?php
require_once 'assets/php/admin-header.php';
?>


    <div class="row">
    <div class="col-lg-12">
            <div class="card my-2 border-warning">
                <div class="card-header bg-warning text-white lead">
                    <h4 class="m-0"> Total Feedback From Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id ="showAllFeedback">
                        <p class="text-center lead align-self-center ">PLease Wait...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Replay Feedback Model -->
    <div class="modal fade" id = "showReplyModel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reply This Feedback</h4>
                    <button type="button" class = "btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" class="px-3" id="feedback-reply-form">
                        <div class="form-group mp-3">
                            <textarea name="message" id="message" class="form-control"row="6" placeholder="Write message here.." required></textarea>
                        </div>
                        <div class="form-group my-3">
                            <input type="submit" name="submit" value="Send Reply" class="btn btn-primary btn-block" id="feedbackReplyBtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- footer Area -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-2.2.2/datatables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Fetch All feedback Users
            fetchAllFeedback();

            function fetchAllFeedback(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action:'fetchAllFeedback'},
                    success:function(response){ 
                        $('#showAllFeedback').html(response);
                        $("table").DataTable({
                            "order":[[0,"desc"]]
                        });
                    }
                });
            }
            //Get The Current Row User ID and Feedback ID 
            var id;
            var fid;
            $("body").on("click",".replayFeedbackIcon",function(e){
                uid = $(this).attr('id');
                fid = $(this).attr('fid');
            })

            // Send Feedback Reply to User Ajax Request
            $("#feedbackReplyBtn").click(function(e){
                if($("#feedback-reply-form")[0].checkValidity()){
                    e.preventDefault();
                    let message = $("#message").val();
                    $("#feedbackReplyBtn").val('please Wait...');

                    $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {uid: uid,message: message,fid: fid},
                    success:function(response){ 
                        $("#feedbackReplyBtn").val('Send Reply');
                        $("#showReplyModel").modal('hide');
                        $("#feedback-reply-form")[0].reset();
                        Swal.fire({
                            title: 'Success!',
                            text: 'reply send successfully', 
                            type: 'success',
                        });
                        fetchAllFeedback();
                    }
                    })
                }
            })
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
        })
    </script>
    </body>
</html>