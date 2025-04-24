<?php
require_once 'assets/php/admin-header.php';
?>


    <div class="row">
        <div class="col-lg-12">
            <div class="card my-2 border-success">
                <div class="card-header bg-success text-white lead">
                    <h4 class="m-0"> Total Regsitered Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id ="showAllUsers">
                        <p class="text-center lead align-self-center ">PLease Wait...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Display User's in Detales -->
    <div class="modal fade" id="showUserDetailsModal">
    <div class="modal-dialog modal-dialog-centered mw-100 w-50">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="getName"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
    <div class="d-flex gap-3">
        <!-- البيانات -->
        <div class="card border-primary w-100">
            <div class="card-body">
                <p id="getEmail"></p>
                <p id="getPhone"></p>
                <p id="getDob"></p>
                <p id="getGender"></p>
                <p id="getCreated"></p>
                <p id="getVerified"></p>
            </div>
        </div>

        <!-- الصورة -->
        <div class="card align-self-start" id="getImage"></div>
    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            //Fetch All Users
            fetchAllUsers();
            function fetchAllUsers(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action:'fetchAllUsers'},
                    success:function(response){ 
                        $('#showAllUsers').html(response);
                        $("table").DataTable({
                            "order":[[0,"desc"]]
                        });
                    }
                });
            }

            // Display User in Details Ajax Request
            $("body").on("click",".userDetailsIcon",function(e){
                e.preventDefault();

                details_id = $(this).attr("id");

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {details_id: details_id},
                    success: function(response){
                        data = JSON.parse(response);
                        console.log(data);
                        $("#getName").text(data.name + ' (ID: ' + data.id + ')');
                        $("#getEmail").text('Email: ' + data.email);
                        $("#getPhone").text('Phone: ' + data.phone);
                        $("#getDob").text('Date of Birth: ' + data.dob);
                        $("#getGender").text('Gender : ' + data.gender);
                        $("#getCreated").text('Created At: ' + data.created_at);
                        $("#getVerified").text('Verified: ' + data.verified);
                        if(data.photo != ''){
                            $("#getImage").html('<img src="../assets/php/'+data.photo+'" class="card-thumbnail img-fluid align-self-center" width="900">');
                        }else{
                            $("#getImage").html('<img src="../assets/img/Avatar.png" class="card-thumbnail img-fluid fluid-end align-self-center" width="900">');
                        }
                        
                    }
                });
            })
        //Delete An User Ajax Request
        $("body").on('click', '.deleteUserIcon ', function(e){
            e.preventDefault();
            del_id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: {del_id: del_id},
                        success: function(response){
                            Swal.fire({
                                title: "Deleted!",
                                text: "Note deleted successfully",
                                type: "success"
                            });
                            fetchAllUsers();
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