<?php
require_once 'admin-db.php';
$admin = new Admin();
session_start();

//Handel Admin Login Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'adminLogin'){
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password); // Hash the password
    $loggedInAdmin = $admin->admin_login($username, $hpassword);
    
    if($loggedInAdmin != null){
        echo 'admin_login';
        $_SESSION['username'] = $username;
    }
    else{
        echo $admin->showMessage('danger','username or password is Incorrect');
    }
} 
//Handel Fetch All Users Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
    $output = '';
    $data = $admin->fetchAllUsers(0);
    $path = '../assets/php/';

    if($data){
        $output .= '<table class="table table-bordered table-striped  text-center" ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>gender</th>
                                <th>Verified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($data as $row){
            if($row['photo']!=''){
                $uphoto = $path.$row['photo'];
            }else{
                $uphoto ='../assets/img/Avatar.png';
            }
            $output .= '<tr>
                            <td>'.$row['id'].'</td>
                            <td><img src="'.$uphoto.'" width="40px" height="40px" class="rounded-circle"></td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['phone'].'</td>
                            <td>'.$row['gender'].'</td>
                            <td>'.$row['verified'].'</td>
                            <td>
                                <a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-bs-toggle="modal" data-bs-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-2x"></i></a>&nbsp;&nbsp;
                                <a href="#" id="'.$row['id'].'" title="Delete User" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-2x"></i></a>
                            </td>
                        </tr>';
        }
        $output .= '</tbody>
                    </table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary">No Users Found</h3>';
    }
}
//Handel Fetch User Details Ajax Request
if(isset($_POST['details_id']) ){
    $id = $_POST['details_id'];
    $data = $admin->fetchUserDetailsByID($id);
    echo json_encode($data);
}
//Handel Delete User Ajax Request
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];
    $admin->userAction($id,0);
    echo 'deleted';
}
//Handel Fetch All Deleted Users Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers'){
    $output = '';
    $data = $admin->fetchAllUsers(1);
    $path = '../assets/php/';

    if($data){
        $output .= '<table class="table table-bordered table-striped  text-center" ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>gender</th>
                                <th>Verified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($data as $row){
            if($row['photo']!=''){
                $uphoto = $path.$row['photo'];
            }else{
                $uphoto ='../assets/img/Avatar.png';
            }
            $output .= '<tr>
                            <td>'.$row['id'].'</td>
                            <td><img src="'.$uphoto.'" width="40px" height="40px" class="rounded-circle"></td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['phone'].'</td>
                            <td>'.$row['gender'].'</td>
                            <td>'.$row['verified'].'</td>
                            <td>
                                <a href="#" id="'.$row['id'].'" title="Restore User" class="text-white restoreUserIcon badge bg-dark p-3" >Restore</a>
                            </td>
                        </tr>';
        }
        $output .= '</tbody>
                    </table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary">No Any Users Deleted Yet</h3>';
    }
}
//Handel Restore User Ajax Request
if(isset($_POST['res_id'])){
    $id = $_POST['res_id'];

    $admin->userAction($id,1);
}
//Handel Fetch All Notes Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes'){
    $output = '';
    $note = $admin->fetchAllNotes(1);

    if($note){
        $output .= '<table class="table table-bordered table-striped  text-center" ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Note Title</th>
                                <th>Note</th>
                                <th>written on</th>
                                <th>Updated On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($note as $row){
            $output .= '<tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.$row['note'].'</td>
                            <td>'.$row['created_at'].'</td>
                            <td>'.$row['update_at'].'</td>
                            <td>
                                <a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteNoteIcon" ><i class="fas fa-trash fa-lg"></i></a>
                            </td>
                        </tr>';
        }
        $output .= '</tbody>
                    </table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary">No Any Note Written Yet</h3>';
    }
}

//Handel delete Note An user Ajax Request
if(isset($_POST['note_id'])){
    $id = $_POST['note_id'];

    $admin->deletNoteOfUser($id);
}
//Handel Fetch Notification Ajax Request
if(isset($_POST['action'])&&$_POST['action']=='fetchNotification'){
    $notification = $admin->fetchNotification();
    $output = '';

    if($notification){
        foreach($notification as $row){
            $output .='<div class="alert alert-dark" role="alert">
                <button type="button" id = "'.$row['id'].'" class="btn-close float-end" data-bs-dismiss="" aria-label="Close">
                </button>
                <h4 class="alert-heading">New Notification</h4>
                <p class="mb-0 lead">'.$row['message'].' by '.$row['name'].'</p>
                <hr class="my-2">
                <p class="mb-0 float-start"><b>User Email :</b>'.$row['email'].'</p>
                <p class="mb-0 float-end">'.$admin->timeInAgo($row['created_at']).'</p>
                <div class="clearfix"></div>
            </div>';
        }

        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">:(No Notification Available)</h3>';
    }
}

//Handel Check Notification
if(isset($_POST['action'])&&$_POST['action'] =='checkNotification'){
    if($admin->fetchNotification()){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>'; 
    }
    else{
        echo '';
    }
}
//Handel Remove Notification
if (isset($_POST['notification_id'])) {
    $id = $_POST['notification_id'];
    if ($admin->removeNotification($id)) {
        echo 'Notification removed';
    } else {
        echo 'Failed to remove notification';
    }
}

//HAndel Fetch All Feedback Of Users Ajax Request

if(isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback'){
    $output = '';
    $feedback = $admin->fetchAllFeedback();

    if($feedback){
        $output .= '<table class="table table-bordered table-striped  text-center" ">
                        <thead>
                            <tr>
                                <th>FID</th>
                                <th>UID</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Subject</th>
                                <th>feedback</th>
                                <th>Sent ON</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach($feedback as $row){
            $output .= '<tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['uid'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['subject'].'</td>
                            <td>'.$row['feedback'].'</td>
                            <td>'.$row['created_at'].'</td>
                            <td>
                                <a href="#" fid = '.$row['id'].' id="'.$row['uid'].'" title="Reply" class="text-primary replayFeedbackIcon" ><i class="fas fa-reply fa-lg" data-bs-toggle="modal" data-bs-target="#showReplyModel"></i></a>
                            </td>
                        </tr>';
        }
        $output .= '</tbody>
                    </table>';
        echo $output;
    }else{
        echo '<h3 class="text-center text-secondary">No Any feedback Written Yet</h3>';
    }  
}
// Handel reply Feedback to User Ajax Request

if (isset($_POST['message'])) {
    $uid = $_POST['uid'];
    $message = $admin->test_input($_POST['message']);
    $fid = $_POST['fid'];
    $admin->replyFeedback($uid, $message);
    $admin->feedbackReplied($fid);
}

// Handel Export Users to Excel
if(isset($_GET['export']) && $_GET['export']== 'excel'){
    header("content-type: application/vnd.ms-excel");
    header("content-disposition: attachment; filename=users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $admin->exportAllUsers();
    echo '<table border="1" align=center>';
    echo '<tr>
    <th>#<th>
    <th>name<th>
    <th>Email<th>
    <th>Phone<th>
    <th>Gender<th>
    <th>DOB<th>
    <th>Joined On<th>
    <th>Verified<th>
    <th>Deleted<th>
    </tr>';
    foreach($data as $row){
        echo '<tr>
        <td>'.$row['id'].'</td>
        <td></td>
        <td>'.$row['name'].'</td>
        <td></td>
        <td>'.$row['email'].'</td>
        <td></td>
        <td>'.$row['phone'].'</td>
        <td></td>
        <td>'.$row['gender'].'</td>
        <td></td>
        <td>'.$row['dob'].'</td>
        <td></td>
        <td>'.$row['created_at'].'</td>
        <td></td>
        <td>'.$row['verified'].'</td>
        <td></td>
        <td>'.$row['deleted'].'</td>
        </tr>';
    }
    echo '</table>';

}
