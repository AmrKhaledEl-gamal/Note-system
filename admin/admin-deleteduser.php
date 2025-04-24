<?php
require_once 'assets/php/admin-header.php';
?>


    <div class="row">
    <div class="col-lg-12">
            <div class="card my-2 border-danger">
                <div class="card-header bg-danger text-white lead">
                    <h4 class="m-0"> Total Deleted Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id ="showAllDeletedUsers">
                        <p class="text-center lead align-self-center ">PLease Wait...</p>
                    </div>
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

            // Fetch All Deleted Users
            fetchAllDeletedUsers();

            function fetchAllDeletedUsers(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action:'fetchAllDeletedUsers'},
                    success:function(response){ 
                        $('#showAllDeletedUsers').html(response);
                        $("table").DataTable({
                            "order":[[0,"desc"]]
                        });
                    }
                });
            }
        //Restore Delete An User Ajax Request
        $("body").on('click', '.restoreUserIcon ', function(e){
            e.preventDefault();
            res_id = $(this).attr('id');
            
            Swal.fire({
                title: "Are you sure you want to restore this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, restore it!"
                }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: {res_id: res_id},
                        success: function(response){
                            Swal.fire({
                                title: "Restored!",
                                text: "user restored successfully",
                                type: "success"
                            });
                            fetchAllDeletedUsers();
                        }
                    })

                }
            });
        });
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
        });
    </script>

    </body>
</html>