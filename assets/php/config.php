<?php
class Database {

    const   USERNAME= 'capamr404@gmail.com';
    const   PASSWORD= '**********';

    private $dsn = "mysql:host=localhost;dbname=db_user_system";
    private $dbuser = "root";
    private $dbpass = "";
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
    // Check Input
    public function test_input($data) {
        $data = trim($data); // Strip unnecessary characters (extra space, tab, newline)
        $data = stripslashes($data); 
        $data = htmlspecialchars($data); 
        return $data;
    }
    // Error Success Message Alert
    public function showMessage($type, $message) {
        return '<div class="alert alert-' . $type . ' alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
            <strong class="text-center">' . $message . '</strong>  
        </div>';
    }
    
    //Display time in ago 
    public function timeInAgo($timestamp){
        date_default_timezone_set('Africa/Cairo'); // Set your timezone

        $timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;

        $time = time() - $timestamp; // to get the time since that moment

        switch($time) {
            case $time < 60:
                return 'Just now';
            case $time >= 60 && $time < 3600:
                return (round($time/60) == 1) ? 'one minute ago' : round($time/60) . ' minutes ago';
            case $time >= 3600 && $time < 86400:
                return (round($time/3600) == 1) ? 'an hour ago' : round($time/3600) . ' hours ago';
            case $time >= 86400 && $time < 604800:
                return (round($time/86400) == 1) ? 'yesterday' : round($time/86400) . ' days ago';
            case $time >= 604800 && $time < 2592000:
                return (round($time/604800) == 1) ? 'a week ago' : round($time/604800) . ' weeks ago';
            case $time >= 2592000 && $time < 31536000:
                return (round($time/2592000) == 1) ? 'a month ago' : round($time/2592000) . ' months ago';
            case $time >= 31536000:
                return (round($time/31536000) == 1) ? 'one year ago' : round($time/31536000) . ' years ago';
        }
    }

}
?>
