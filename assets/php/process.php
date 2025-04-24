<?php

require_once 'session.php';
//HAndle Add New Note Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'add_note') {
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);


    $cuser->add_new_note($cid, $title, $note);
    $cuser->notification($cid, 'admin', ' Note Added'); 
}

//Handle Display All Note Of An User

if (isset($_POST['action'])&&$_POST['action']=='display_notes'){
    $output = '';

    $notes = $cuser->get_notes($cid);
    if($notes){
        $output .='<table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>' ;
        foreach($notes as $row){
            $output .='      <tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.substr($row['note'],0,75).'...</td>
                            <td>
                                <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-2x"></i></a>&nbsp;&nbsp;
                                <a href="#" id="'.$row['id'].'" title="Edit Note" class="text-primary editBtn" data-bs-toggle="modal" data-bs-target="#editNoteModal"><i class="fas fa-edit fa-2x" ></i></a>&nbsp;&nbsp;
                                <a href="#" id="'.$row['id'].'"title="Delete Note" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-2x"></i></a>
                            </td>
                        </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(You have not write any note yet)</h3>';
    }
}

//Handle Edit Note of User Ajax Request
if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $row = $cuser->edit_note($id);
    echo json_encode($row);
}

//Handle Update Note of User Ajax Request
if(isset($_POST['action'])&&$_POST['action']=='update_note'){
    $id = $cuser->test_input($_POST['id']);
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $cuser->update_note($id, $title, $note);
    $cuser->notification($cid, 'admin', 'Note Updated'); 

}

//Handle Delete Note of User Ajax Request
if(isset($_POST['delete_id'])){
    
    $id = $_POST['delete_id'];

    $cuser->delete_note($id);
    $cuser->notification($cid, 'admin', 'Note deleted'); 

}

//Handle dISPLAY Note of User Ajax Request
if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    $row = $cuser->edit_note($id);
        
    echo json_encode($row);
}

//Handle Profile Update Ajax Request
if(isset($_FILES['image'])){
    $name = $cuser->test_input($_POST['name']);
    $gender = $cuser->test_input($_POST['gender']);
    $dob = $cuser->test_input($_POST['dob']);
    $phone = $cuser->test_input($_POST['phone']);

    $oldImage = $_POST['oldimage'];
    $folder ='uploads/';

    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
        $newImage = $folder.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $newImage );

        if($oldImage != null && file_exists($oldImage)){
            unlink($oldImage);
        }
    } else {
        $newImage = $oldImage;
    }

    $cuser->update_profile($name, $gender, $dob, $phone, $newImage, $cid); 
    $cuser->notification($cid, 'admin', 'Profile Updated'); 

}

//Handle Change Password Ajax Request
if(isset($_POST['action']) && $_POST['action']=='change_pass'){
    $currentpass = $_POST['curpass'];
    $newPass = $_POST['newpass'];
    $cnewpass = $_POST['cnewpass'];

    $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

    if($newPass!=$cnewpass){
        echo $cuser->showMessage('danger', 'Password did not match!');
    }
    else{
        if(password_verify($currentpass, $cpass)){
            $cuser->change_password($hnewPass, $cid);
            echo $cuser->showMessage('success', 'Password Changed Successfully!');
            $cuser->notification($cid, 'admin', 'Password Changed'); 

        }
        else{
            echo $cuser->showMessage('danger', 'Current Password is Wrong!');
        }
    }
}

//Handel Verfiy E-mail Ajax Request
if(isset($_POST['action']) && $_POST['action']=='verify_email'){
    
}

//Handle send feedback Ajax Request
if(isset($_POST['action']) && $_POST['action']=='feedback'){
    $subject = $cuser->test_input($_POST['subject']);
    $feedback = $cuser->test_input($_POST['feedback']);

    $cuser->send_feedback($subject, $feedback, $cid);
    $cuser->notification($cid, 'admin', 'Feedback Sent'); 
}
//Handle Fetch Notification of an User

if(isset($_POST['action'])&&$_POST['action']=='fetchNotification'){
    $notification = $cuser->fetchNotification($cid);
    $output = '';

    if($notification){
        foreach($notification as $row){
            $output .='<div class="alert alert-danger" role="alert">
                <button type="button" id = "'.$row['id'].'" class="btn-close float-end" data-bs-dismiss="" aria-label="Close">
                </button>
                <h4 class="alert-heading">New Notification</h4>
                <p class="mb-0 lead">'.$row['message'].'</p>
                <hr class="my-2">
                <p class="mb-0 float-start">Reply of feedback from admin</p>
                <p class="mb-0 float-end">'.$cuser->timeInAgo($row['created_at']).'</p>
                <div class="clearfix"></div>
            </div>';
        }

        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">:(No Notification Available)</h3>';
    }
}
//Handle Check Notification of an User
if(isset($_POST['action'])&&$_POST['action'] =='checkNotification'){
    if($cuser->fetchNotification($cid)){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>'; 
    }
    else{
        echo '';
    }
}
//Remove Notification
if (isset($_POST['notification_id'])) {
    $id = $_POST['notification_id'];
    if ($cuser->removeNotification($id)) {
        echo 'Notification removed';
    } else {
        echo 'Failed to remove notification';
    }
}