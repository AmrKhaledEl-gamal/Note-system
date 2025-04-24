<?php
require_once 'assets/php/header.php';
?>
<html lang="en">
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if($verified == 'Not verified'):?>
                <div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <strong>Your account is not yet verified. Please check your email for the verification link .</strong> 
                </div>
            <?php endif;?>
            <h4 class="text-center text-primary mt-2">Write Your Notes Here & Access Them Anytime Anywhere</h4>
        </div>
    </div>
    <div class="card border-primary ">
        <h5 class="card-header bg-primary d-flex justify-content-between align-items-center">
            <span class="text-light lead">All Notes</span>
            <a href="#" class="btn btn-light d-flex align-items-center align-self-center" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                <i class="fas fa-plus-circle fa-2x"></i>&nbsp;Add New Note
            </a>
        </h5>
        <div class="card-body">
            <div class="table-responsive" id = "showNotes">
                <p class="text-center lead mt-3">please wait...</p>
            </div>
        </div>
    </div>
</div>
<!-- Start Add New Note Modal -->
<div class = "modal fade" id = "addNoteModal">
    <div class = "modal-dialog modal-dialog-centered">
        <div class = "modal-content">
            <div class = "modal-header bg-success">
                <h4 class="modal-title text-light">Add New Note</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class = "modal-body">
                <form action="#" method="post" id="add-note-form" class="px-3">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control form-control-lg " placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="note" class="form-control form-control-lg my-3" placeholder="Write your Note Here .... " rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addNote" id = "addNoteBtn" class="btn btn-success btn-block btn-lg w-100 my-3" value="Add Note">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- End Add New Note Modal -->
    
    <!-- Start Edit Note Modal -->
<div class = "modal fade" id = "editNoteModal">
    <div class = "modal-dialog modal-dialog-centered">
        <div class = "modal-content">
            <div class = "modal-header bg-info">
                <h4 class="modal-title text-light">Edit Note</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class = "modal-body">
                <form action="#" method="post" id="edit-note-form" class="px-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control form-control-lg " placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="note" class="form-control form-control-lg" placeholder="Write your Note Here .... " rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="editNote" id="editNoteBtn" class="btn btn-info btn-block btn-lg w-100" value="Update Note">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- End Edit Note Modal -->

</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-2.2.2/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
    $(document).ready(function(){

        //Add New Note Ajax Request
        $("#addNoteBtn").click(function(e){
            if($("#add-note-form")[0].checkValidity()){
                e.preventDefault();

                $("#addNoteBtn").val('Please Wait...');
                
                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post', 
                    data: $("#add-note-form").serialize()+'&action=add_note',
                    success: function(response){
                        $("#addNoteBtn").val('Add Note');
                        $("#add-note-form")[0].reset();
                        $("#addNoteModal").modal('hide');
                        Swal.fire({
                            title: 'Note Added Successfully',
                            type: 'success',
                        });
                        displayAllNotes();
                    }
                });
            }
        });

        //Edit Note Ajax Request
        $("body").on('click','.editBtn',function(e){
            e.preventDefault();
            edit_id = $(this).attr('id');
            console.log(edit_id);
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {edit_id: edit_id},
                success: function(response){
                    data = JSON.parse(response);
                    // console.log(data);
                    $("#id").val(data[0].id);
                    $("#title").val(data[0].title);
                    $("#note").val(data[0].note);
                }
            });
        });

        //Update Note Ajax Request
        $("#editNoteBtn").click(function(e){
            if($("#edit-note-form")[0].checkValidity()){
                e.preventDefault();

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#edit-note-form").serialize()+'&action=update_note',
                    success: function(response){
                            swal.fire({
                                title: 'Note Updated Successfully',
                                type: 'success',
                            });
                            $("#edit-note-form")[0].reset();
                            $("#editNoteModal").modal('hide');
                            displayAllNotes();
                    }
                });
            }
        });

        //Delete Note 
        $("body").on('click', '.deleteBtn', function(e){
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
                        url: 'assets/php/process.php',
                        method: 'post',
                        data: {delete_id: del_id},
                        success: function(response){
                            Swal.fire({
                                title: "Deleted!",
                                text: "Note deleted successfully",
                                type: "success"
                            });
                            displayAllNotes();
                        }
                    })

                }
            });
        });

        //Display Note of An User in Details Ajax Request
        $("body").on('click', '.infoBtn', function(e){
            e.preventDefault();

            info_id = $(this).attr('id');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {info_id: info_id},
                success: function(response){
                    data = JSON.parse(response);
                    swal.fire({
                        title: '<strong> ID('+data[0].id+')</strong>',
                        type: 'info',
                        html: '<b>Title : </b>'+data[0].title+'<br><br><b>Note : </b>'+data[0].note+'<br><br><b>Written on : </b>'+data[0].created_at+'<br><br><b>Updated on : </b>'+data[0].update_at,
                        showCancelButton: true,
                    })
                    // $("#id").val(data[0].id);
                    // $("#title").val(data[0].title);
                    // $("#note").val(data[0].note);
                }
            });
        });

        //Display All Notes Ajax Request 
        displayAllNotes();

        function displayAllNotes(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {action: 'display_notes'},
                success: function(response){
                    $("#showNotes").html(response);
                    $("table").DataTable({
                        order: [0, 'desc'],
                    });
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
        //Checking user is logged in or not
        $.ajax({
            url: 'assets/php/action.php',
            method: 'post',
            data: {action: 'checkUser'},
            success:function(response){
                // console.log(response)
                if(response === 'bye'){
                    window.location = 'index.php'
                }
            }
        })
    });
</script>
</body>
</html>

