<?php
require_once 'assets/php/admin-header.php';
?>


    <div class="row">
    <div class="col-lg-12">
            <div class="card my-2 border-secondary">
                <div class="card-header bg-secondary text-white lead">
                    <h4 class="m-0"> Total Notes By ALL Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id ="showAllNotes">
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
                        //Fetch All Notes
                        fetchAllNotes();
            function fetchAllNotes(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action:'fetchAllNotes'},
                    success:function(response){ 
                        console.log(response);
                        $('#showAllNotes').html(response);
                        $("table").DataTable({
                            "order":[[0,"desc"]]
                        });
                    }
                });
            }
            //Delete Note
            $("body").on('click', '.deleteNoteIcon ', function(e){
            e.preventDefault();
            note_id = $(this).attr('id');
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
                        data: {note_id: note_id},
                        success: function(response){
                            Swal.fire({
                                title: "Deleted!",
                                text: "Note deleted successfully",
                                type: "success"
                            });
                            fetchAllNotes();
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
        })
    </script>
    </body>
</html>