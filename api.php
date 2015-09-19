<?php
require("model.php");

class Api
{
    //--------Variables------------
    private $model;
    private $apiFunctions;
    //--------Functions------------
    //Constructor
    function __construct()
    {
        //initialize private variables
        $this->model  = new Model();
         $this->apiFunctions = array(
             //POSTS
            "attemptLogin",
            "logout",
            "attemptRegistration",

            "checkWhizname",
            "checkEmail",
             "postJob",
             "fetchJobs",
             
             //GETS
            "getWhizData",

        );
        date_default_timezone_set("UTC");
        
        //Proccess Query String
        if (isset($_GET['function'])) {
            $queryParams = explode("/", $_GET['function']);
        } else {
            $queryParams = false;
        }  

        if($queryParams === false){
            echo "Welcome to the WhizBridge API"; 
        } else if (in_array($queryParams[0], $this->apiFunctions )) {
             $this->$queryParams[0]();
        } else {
            echo "Error: invalid function";
        }
    }
    
    private function hasInvalidChars($str) 
    {
        return preg_match('/[^A-Za-z0-9]/', $str);
    }
    
    //POSTS

    private function attemptLogin()
    {
        $output = new stdClass;
        $output->status = 0;
        header('Content-Type: application/json');
        
        if(isset($_POST['user']) && isset($_POST['password'])){
            if (strpos($_POST['user'], "@") === true) {
                $user_id = $this->model->getWhizIdForEmail($_POST['user']);
            } else {
                $user_id = $this->model->getWhizIdForWhizname($_POST['user']);
            }
            $salt = $this->model->getSaltForWhizId($user_id);
            $pass      = hash('sha256', $salt.$_POST['password']);
            $loginInfo = array(
                'user_id' => $user_id,
                'password' => $pass
            );
        } else {
            $output->status = -27;
            echo json_encode($output);
            return;
        }
        
        if ($cur_hash = $this->model->attemptLogin($loginInfo, false)) {
            $output->status = 1;
            $output->auth_hash = $cur_hash;
            echo json_encode($output);
            return;
        } else {
            $output->status = -2;
            echo json_encode($output);
            return;
        }
    }

    private function logout()
    {
        $output = new stdClass;
        $output->status = 0;
        header('Content-Type: application/json');

        if(!isset($_POST['auth_hash'])){
            $output->status = -28;
            echo json_encode($output);
            return;
        }
        
        if( $this->model->logoutWhiz($_POST['auth_hash'], false)){
            $output->status = 1;
            echo json_encode($output);
            return;
        } else {
            echo json_encode($output);
            return;
        }
    }

    private function attemptRegistration()
    {
        $output = new stdClass;
        $output->status = 0;
        header('Content-Type: application/json');
        
        if( isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['display_name']) ){
            if (array_key_exists($_POST['username'], $this->apiFunctions)) {
                $output->status = -4;
            } else if ($_POST['email'] == "" || strpos($_POST['email'], "@") === false || strpos($_POST['email'], "+") === true) {
                $output->status = -7;
            } else if ($_POST['username'] == "") {
                $output->status = -9;
            } else if ($this->hasInvalidChars($_POST['username'])) {
                $output->status = -8;
            }else if (strlen($_POST['password']) < 6) {
                $output->status = -6;
            } else if ($_POST['password'] != $_POST['password2']) {
                $output->status = -5;
            } else {
                $curSalt = chr( mt_rand( 97 ,122 ) ) .substr( md5( time( ) ) ,1 );
                $pass       = hash('sha256', $curSalt.$_POST['password']);
                $signupInfo = array(
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $pass,
                    'display_name' => $_POST['display_name'],
                    'salt' => $curSalt
                );
                $resp       = $this->model->registerWhiz($signupInfo, false);

                if ($resp !== false) {
                    $output->status = 1;
                    $output->auth_hash = $resp;
                } else {
                    $output->status =  $resp;
                }
            }

            echo json_encode($output);
            return;
        } else {
            $output->status = -29;
            echo json_encode($output);
            return;
        }
    }
    
    
    
    //GETS
    
    private function getWhizData()
    {
        $output = new stdClass;
        $output->status = 0;
        
        if(isset($_GET['auth_hash'])){
            $cur_user = $this->model->userForAuthHash($_GET['auth_hash']);
            if ($cur_user === false) { 
                $output->status = -1;
                echo json_encode($output);
                return;
            } else { 
                if (isset($_GET['target_user_id'])){
                    if ($user = $this->model->getWhizData($cur_user->user_id, $_GET['target_user_id']) ) {
                        $output->status = 1;
                        $output->user = $user;   
                    }
                } else if(isset($_GET['target_username'])){
                    if ($user = $this->model->getWhizData($cur_user->user_id, null, $_GET['target_username'])) {
                        $output->status = 1;
                        $output->user = $user;   
                    }
                } else {
                    $user = $this->model->getWhizData($cur_user->user_id, $cur_user->user_id);
                    $output->status = 1;
                    $output->user = $user;
                }

                echo json_encode($output);
                return;
            }
        } else {
            $output->status = -1;
            echo json_encode($output);
            return;
        }
    }
    
    private function checkWhiznameExists()
    {
        $output = new stdClass;
        $output->status = 0;
        header('Content-Type: application/json');
        
        if (isset($_GET['username'])){
            $username = $_GET['username'];
            if($this->model->usernameExists($username)){
                $output->status = 1;
                $output->exists = 1;
                echo json_encode($output);
                return;
            } else {
                $output->status = 1;
                $output->exists = 0;
                echo json_encode($output);
                return;
            }
        } else {
            $output->status = -30;
            echo json_encode($output);
            return; 
        }
    }
    
    private function checkEmailExists()
    {
        $output = new stdClass;
        $output->status = 0;
        header('Content-Type: application/json');
        
        if (isset($_GET['email'])){
            $email = $_GET['email'];
            if($this->model->emailExists($email)){
                $output->status = 1;
                $output->exists = 1;
                echo json_encode($output);
                return;
            } else {
                $output->status = 1;
                $output->exists = 0;
                echo json_encode($output);
                return;
            }
        } else {
            $output->status = -30;
            echo json_encode($output);
            return; 
        }
    }
    
     private function postJob()
    {
        $resp = $this->model->APIcreateJob($_POST["job_name"], $_POST["job_description"], $_POST["job_address"], $_POST["job_latitude"], $_POST["job_longitude"], $_POST["job_price"], $_POST["email"]);
        echo json_encode($resp);
    }
    
    private function fetchJobs()
    {
        $a = new stdClass;
        if($user = $this->model->userForAuthHash($_GET["auth_hash"])){
            $a->status = 1;
            $resp = $this->model->APIfetchJobs($user->whiz_id);
            $a->jobs = $resp;
            echo json_encode($a);
        }
    }
}

$api = new Api();




             