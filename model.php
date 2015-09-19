<?php
class Model
{
    private $dbh;
    function __construct()
    {
        /*** mysql hostname ***/
        $hostname = '127.0.0.1';
        /*** mysql username ***/
        $username = 'root';
        /*** mysql password ***/
        $password = '123';
        /*** mysql dbname ***/
        $dbname   = 'whizbridge_db';
        try {
            $this->dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        date_default_timezone_set("UTC");
    }
    public function test(){
        $response = $this->getWhizIdForUsername("username");
        var_dump($response);
    }





    //***********************************************************************
    //STANDARD FUNCTIONS
    //***********************************************************************
    /* Select, Exists, Update, Insert, Delete */





    //private function for performing standard SELECTs
    private function select($table, $arr)
    {
        $query = "SELECT * FROM " . $table;
        $prefix  = " WHERE ";
        foreach ($arr as $key => $value) {
            $query .= $prefix . $key . " = ? ";
            $prefix = " AND ";
        }
        $query .= ";";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->execute(array_values($arr));
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $sth;
    }
    //private function to select only one object from one table
    //prepared using columns, key/values and pdo types
    private function objectSelect($table, $columns, $arr, $types)
    {
        $query = "SELECT ";
        $prefix = "";
        foreach ($columns as $column){
            $query .= $prefix . $column;
            $prefix = " , ";
        }
        $query .= " FROM " . $table;
        $prefix  = " WHERE ";
        foreach ($arr as $key => $value) {
            $query .= $prefix . $key . " = ? ";
            $prefix = " AND ";
        }
        $query .= ";";
        try {
            $sth = $this->dbh->prepare($query);
            $count = 1;
            foreach($arr as $key => $value){
                $sth->bindValue($count, $value, $types[$count-1]);
                $count += 1;
            }
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        $object = $sth->fetch(PDO::FETCH_OBJ);
        return $object !== null ? $object : false ;
    }
    //private function for checking if a row exists
    private function exists($table, $arr)
    {
        $result = $this->select($table, $arr);
        return ($result->fetchColumn() > 0) ? true : false;
    }
    //private function to update a row in the database
    private function objectUpdate($table, $arr, $conditions, $arrTypes, $conditionTypes)
    {
        $query = "UPDATE " .$table . " SET ";
        $prefix = "";
        foreach ($arr as $key => $value) {
            $query .= $prefix . $key . " = ? ";
            $prefix = " , ";
        }
        $prefix = " WHERE ";
        foreach ($conditions as $key => $value) {
            $query .= $prefix . $key . " = ? ";
           $prefix = " AND ";
        }
        $query .= ";";
        try {
            $sth = $this->dbh->prepare($query);
            $count = 1;
            foreach ($arr as $key => $value) {
                $sth->bindValue($count, $value, $arrTypes[$count-1]);
                $count += 1;
            }
            foreach ($conditions as $key => $value) {
                $sth->bindValue($count, $value, $conditionTypes[$count-1-count($arr)]);
                $count += 1;
            }
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }
    //private function for performing standard INSERTs
    private function insert($table, $arr)
    {
        $query = "INSERT INTO " . $table . " (";
        $prefix = "";
        foreach ($arr as $key => $value) {
            $query .= $prefix . $key;
            $prefix = ", ";
        }
        $query .= ") VALUES (";
        $prefix = "";
        foreach ($arr as $key => $value) {
            $query .= $prefix . " ? ";
            $prefix = ", ";
        }
        $query .= ");";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->execute(array_values($arr));
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }
    //private function for performing standard DELETEs
    private function delete($table, $arr)
    {
        $query = "DELETE FROM " . $table;
        $prefix  = " WHERE ";
        foreach ($arr as $key => $value) {
            $query .= $prefix . $key . " = ? ";
            $prefix = " AND ";
        }
        $query .= ";";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->execute(array_values($arr));
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }

    //TEMPLATE
    //public function
    //takes:
    //returns:
    //use case:






    //***********************************************************************
    //USER FUNCTIONS
    //***********************************************************************
    /* Authentication, Login, Logout, Registration, Whiz Data Fetching,
    Credential Changes, "Exists" Checks, Signups, Referrals */





    //public function for condensed user retrieval
    //takes:    auth_hash
    //returns:  condensed user object {user_id, username, display_name, avatar_hash}
    //          OR false if user not found based on auth_hash
    //use case: for authentication each time controller is accessed
    public function userForAuthHash($auth_hash)
    {
        try {
            $query = "  SELECT Whiz.whiz_id
                            ,username
                            ,full_name
                            ,avatar_hash
                        FROM Whiz
                        INNER JOIN (
                            SELECT whiz_id
                            FROM Auth
                            WHERE auth_hash = :auth_hash LIMIT 1
                            ) AS AuthJoin
                        WHERE Whiz.whiz_id = AuthJoin.whiz_id LIMIT 1 ";

            $sth = $this->dbh->prepare($query);
            $sth->bindValue(':auth_hash', $auth_hash, PDO::PARAM_STR);
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        if ($sth !== null) {
            $this->updateAuth($auth_hash);
            return $sth->fetch(PDO::FETCH_OBJ);
        } else {  //sth is probably never going to be null; just in case
            return false;
        }
    }
    //public function for updating the date of the auth entry show most current users
    //takes:    auth_hash
    //returns:  true or false, depending on success
    //use case: used only in userForAuthHash
    public function updateAuth($auth_hash)
    {
        return $this->objectUpdate("Auth", array("created_at" => date('Y-m-d H:i:s')),
                                    array("auth_hash" => $auth_hash),
                                    array(PDO::PARAM_STR),
                                    array(PDO::PARAM_STR));
    }
    //public function checks if user exists
    //takes:    user array of username and password hash, boolean setCookie
    //returns:  auth_hash or false depending on success
    //use case: can be used from anywhere, typically controller
    public function attemptLogin($user, $setCookie)
    {
        if ($this->exists("Whiz", $user)) {
            return $this->authorizeWhiz($user, $setCookie);
        } else {
            return false;
        }
    }
    //public function inserts hash for the current user to be logged in
    //takes:    user array with username
    //returns:  true or false, depending
    //use case: from inside model only, attemptLogin or registration
    public function authorizeWhiz($user, $setCookie)
    {
        $chars = "qazwsxedcrfvtgbyhnujmik,ol.p;/1234567890QAZWSXEDCRFVTGBYHNUJMIKOLP";
        $auth_hash  = sha1($this->getUsernameForWhizId($user['whiz_id']));
        for ($i = 0; $i < 12; $i++) {
            $auth_hash .= $chars[rand(0, 64)];
        }
        $user_id = $user['whiz_id'];
        if($user_id !== false){
            $response = $this->insert("Auth", array(
                "auth_hash" => $auth_hash,
                "whiz_id" => $user_id,
                "created_at" => date('Y-m-d H:i:s')
            ));
            if($setCookie){
                setcookie("Auth", $auth_hash, time()+60*60*24*30, "/");
                //setcookie("Auth", $auth_hash, time()+3600*24*30, "/", "http://whistlet.com");
            }
            if($response)
                return $auth_hash;
            else
                return false;
        } else {
            return false;
        }
    }
    //public function gets salt for username
    //takes:    username
    //returns:  salt
    //use case: anywhere
    public function getSaltForWhizId($user_id)
    {
        $response = $this->objectSelect("Whiz", array("salt"), array(
            "whiz_id" => $user_id), array(PDO::PARAM_INT));
        return ($response !== false ? $response->salt : false );
    }

     public function getSaltForUsername($username)
    {
        $response = $this->objectSelect("Whiz", array("salt"), array(
            "username" => $username), array(PDO::PARAM_STR));
        return ($response !== false ? $response->salt : false );
    }
    //public function gets user id for username
    //takes:    username
    //returns:  user_id
    //use case: anywhere
    public function getWhizIdForUsername($username)
    {
        $response = $this->objectSelect("Whiz", array("whiz_id"), array(
            "username" => $username), array(PDO::PARAM_STR));
        return ($response !== false ? $response->whiz_id : false );
    }
    //public function gets user id for email
    //takes:    email
    //returns:  user_id
    //use case: anywhere
    public function getWhizIdForEmail($email)
    {
        $response = $this->objectSelect("Whiz", array("whiz_id"), array(
            "email" => $email), array(PDO::PARAM_STR));
        return ($response !== false ? $response->whiz_id : false );
    }
     //public function gets user name for username id
    //takes:    user_id
    //returns:  username
    //use case: anywhere
    public function getUsernameForWhizId($user_id)
    {
        $response = $this->objectSelect("Whiz", array("username"), array(
            "user_id" => $user_id), array(PDO::PARAM_STR));
        return ($response !== false ? $response->username : false );
    }

    // public function gets whiz is for job id in job join
    public function getWhizIdForJobId ($job_id) {
        $response = $this->objectSelect("JobJoin", array("whiz_id"), array(
            "job_id" => $job_id), array(PDO::PARAM_INT));
        return ($response !== false ? $response->whiz_id : false);
    }

    public function getJobCompletedForJobId ($job_id) {
        $response = $this->objectSelect("JobJoin", array("job_completed"), array(
            "job_id" => $job_id), array(PDO::PARAM_INT));
        return ($response !== false ? $response->job_completed : false);
    }


    //public function deletes auth_hash given
    //takes:    auth_hash, setCookie
    //returns:  true or false, depending on success
    //use case: anywhere
    public function logoutWhiz($auth_hash, $setCookie)
    {
        $response = $this->delete("Auth", array(
            "auth_hash" => $auth_hash
        ));
        if($setCookie){
            setcookie("Auth", "", time() - 3600);
        }
        return $response;
    }

    //public function registers a user and checks for availability
    //takes:    full user array {username, display_name, email, password, salt} and setCookie
    //returns:  auth_hash if success, error code if not
    //use case: anywhere
    public function registerWhiz($user, $setCookie)
    {
        if ($this->emailExists($user['email'])) {
            return -3;
        } else {
            if ($this->usernameExists($user['username'])) {
                return -4;
            } else {
                $user['created_at'] = date('Y-m-d H:i:s');
                $user['avatar_hash']     = md5(substr( md5( time( ) ) ,8 ) . strtolower(trim($user['email'])));
                $this->insert("Whiz", $user);
                $user["whiz_id"] = $this->getWhizIdForUsername($user["username"]);
                return $this->authorizeWhiz($user, $setCookie);
            }
        }
    }

    //public function checks if email exists
    //takes:    email
    //returns:  true or false, depending on existence
    //use case: anywhere
    public function emailExists($email){
        return $this->exists("Whiz", array("email" => $email));
    }
    //public function checks if username exists
    //takes:    username
    //returns:  true or false, depending on existence
    //use case: anywhere
    public function usernameExists($username){
        return $this->exists("Whiz", array("username" => $username));
    }
    //public function returns a full user object - *-* USE ON CONTROLLER date('M Y', strtotime($output->created_at));
    //takes:     OPTIONAL: target_user_id, target_user_username, cur_user_id (one of id or username must be available)
    //returns:  full user object {user_id, username, display_name, amp, created_at, avatar_hash, followers, following,  OPTIONAL: did_follow}
    //use case: anywhere

    //FUCKING EDIT THIS
    public function getWhizData( $target_user_id = null,  $target_user_username = null)
    {
        if($target_user_username !== null ){
            $target_user_id = $this->getWhizIdForWhizname($target_user_username);
        }
        $query = "SELECT Whiz.whiz_id
                        ,username
                        ,full_name

                        ,created_at
                        ,avatar_hash
                    FROM Whiz
                    WHERE Whiz.whiz_id = :target_user_id LIMIT 1;";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->bindValue(':target_user_id', $target_user_id, PDO::PARAM_INT);
            // if ($cur_user_id !== null)
            //     $sth->bindValue(':cur_user_id', $cur_user_id, PDO::PARAM_INT);
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $sth->fetch(PDO::FETCH_OBJ);
    }


    //***********************************************************************
    //DATA FUNCTIONS
    //***********************************************************************

















    //EXAMPLE FUNCTIONS:


    //public function retrieves a user based on the broadcast
    //takes:    broadcast_id, optional rebroadcast_id
    //returns:  partial user_object to display data in the flip view
    //use case: anywhere but profile
    public function getWhizForBroadcastId($broadcast_id, $rebroadcast_id = null)
    {
        $query = "SELECT user_id
                ,username
                ,display_name
                , (SELECT created_at FROM Broadcast WHERE Broadcast.broadcast_id = :broadcast_id ) AS created_at, ";
        if($rebroadcast_id !== null) {
            $query .= " (SELECT username
                    FROM Whiz
                    WHERE Whiz.user_id = (
                            SELECT rebroadcast_user_id
                            FROM Rebroadcast
                            WHERE rebroadcast_id = :rebroadcast_id LIMIT 1
                            )
                    ) AS rebroadcast_username
                    , (SELECT created_at FROM Rebroadcast WHERE Rebroadcast.rebroadcast_id = :rebroadcast_id ) AS order_date ";
        } else {
            $query .= " NULL AS rebroadcast_username
                        , NULL AS order_date";
        }
        $query .= "
                ,avatar_hash
            FROM Whiz
            WHERE Whiz.user_id = (
                    SELECT Broadcast.user_id
                    FROM Broadcast
                    WHERE Broadcast.broadcast_id = :broadcast_id LIMIT 1
                    );";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->bindValue(':broadcast_id', $broadcast_id, PDO::PARAM_INT);
            if ($rebroadcast_id !== null)
                $sth->bindValue(':rebroadcast_id', $rebroadcast_id, PDO::PARAM_INT);
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $sth->fetch(PDO::FETCH_OBJ);

    }
    //public function *-* NOT DONE- ADD META DATA INSERTION
    //takes:
    //returns:
    //use case:
    public function createBroadcast($user_id, $broadcast_text, $created_at, $images = null, $vine = null, $reply_to_broadcast_id = null)
    {
        $query = "INSERT INTO Broadcast (broadcast_text, created_at, user_id, broadcast_metadata, reply_to_broadcast_id) VALUES (:broadcast_text, :created_at, :user_id, :broadcast_metadata, ";
        if($reply_to_broadcast_id !== null ){
            $query .= " :reply_to_broadcast_id ";
        } else {
            $query .= " NULL ";
        }
        $query .= ");";

        $metadata = new stdClass;
        if($images !== null) {
            $metadata->image_media = new stdClass;
            $metadata->image_media->image_count = count($images);
            $imageArray = array();

            foreach($images as $image){
                $imageObject = new stdClass;
                $imageObject->image_link = $image;
                array_push($imageArray, $imageObject);
            }
            $metadata->image_media->images = $imageArray;
        } else if ($vine !== null ){

        }
        $broadcast_metadata = json_encode($metadata);

        $broadcast_text = strip_tags($broadcast_text);

        try {
            $sth = $this->dbh->prepare($query);
            //$sth->bindParam(":text", strip_tags(htmlentities($text)));
            $sth->bindParam(":broadcast_text", $broadcast_text , PDO::PARAM_STR );
            $sth->bindParam(":created_at", $created_at, PDO::PARAM_STR );
            $sth->bindParam(":user_id", $user_id, PDO::PARAM_INT );
            $sth->bindParam(":broadcast_metadata", $broadcast_metadata, PDO::PARAM_STR );
            if($reply_to_broadcast_id !== null ){
                $sth->bindParam(":reply_to_broadcast_id", $reply_to_broadcast_id, PDO::PARAM_INT );
            }
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }

    // NEW FUNCTION
    public function fetchJobs($whiz_id)
    {
        $query = "SELECT * FROM whizbridge_db.Job WHERE job_id NOT IN (select job_id from JobJoin WHERE whiz_id <> ".$whiz_id.") ORDER BY created_at DESC LIMIT 50; ";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->bindParam(':whiz_id', $whiz_id, PDO::PARAM_INT);
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        $jobs = array();
        while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            array_push($jobs, $row);
        }
        return $jobs;
    }

    public function createJob($name, $descr, $price, $lat, $long){
        $info = array("job_name"=> $name,
            "job_description"=> $descr,
             "job_price"=>$price,
             "job_latitude" => $lat,
              "job_longitude" => $long,
              "created_at" => date('Y-m-d H:i:s'),
              "job_hash" => md5($name .date('Y-m-d H:i:s') ) );
        $this->insert("Job", $info);

        // $job_id = $this->objectSelect("Job", array("job_id"), $info, array(PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR));

        // the message
        $msg = md5($info["job_name"].$info["created_at"]);
        echo $msg;
        // send email
        mail("jeffrey.xiao1998@gmail.com","Job Created!",$msg);
    }
    public function takeJob ($job_id, $whiz_id) {
        return $this->insert("JobJoin", array("job_id"=>$job_id, "whiz_id" => $whiz_id));
    }

    public function cancelWhizJob ($job_id) {
        return $this->delete("JobJoin", array("job_id" => $job_id));
    }

    public function completeWhizJob ($job_id) {
        $query = "UPDATE JobJoin SET job_completed=1 WHERE job_id=:job_id ";

        try {
            $sth = $this->dbh->prepare($query);
            //$sth->bindParam(":text", strip_tags(htmlentities($text)));
            $sth->bindParam(":job_id", $job_id , PDO::PARAM_INT );
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }

    public function checkIfJobHashExists($hash){
        $a =  $this->objectSelect("Job", array("job_id", "job_name", "job_description", "job_price"), array(
            "job_hash" => $hash), array(PDO::PARAM_STR));
        return $a;
    }

    public function updateJobComplete($job_id){
        $query = "UPDATE Job SET job_completed=1 WHERE job_id=:job_id ";

        try {
            $sth = $this->dbh->prepare($query);
            //$sth->bindParam(":text", strip_tags(htmlentities($text)));
            $sth->bindParam(":job_id", $job_id , PDO::PARAM_INT );
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }
    public function deleteJob ($job_id) {
        return $this->delete("Job", array("job_id" => $job_id));
    }
    public function checkRsvp ($job_id) {
        $query = "SELECT * FROM JobJoin WHERE job_id = ".$job_id."";
        try {
            $sth = $this->dbh->prepare($query);
            //$sth->bindParam(":text", strip_tags(htmlentities($text)));
            $sth->bindParam(":job_id", $job_id , PDO::PARAM_INT );
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return ($sth->rowCount() > 0) ? true : false;
    }
    
    
    public function APIcreateJob($name, $descr, $address, $lat, $long, $price, $email){
        $a = $this->insert("Job", array("job_name"=>$name, 
                                   "job_description" => $descr, 
                                   "job_address" => $address, 
                                   "job_latitude" => $lat, 
                                   "job_longitude" => $job_longitude,
                                  "job_price" => $price,
                                  "created_at" => date('Y-m-d H:i:s')));
        return $a;
        
    }
    
    public function APIfetchJobs($whiz_id){
           $query = "SELECT * FROM whizbridge_db.Job WHERE job_completed IS NULL AND job_id NOT IN (select job_id from JobJoin) ORDER BY created_at DESC LIMIT 50; ";
        try {
            $sth = $this->dbh->prepare($query);
            $sth->bindParam(':whiz_id', $whiz_id, PDO::PARAM_INT);
            $sth->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        $jobs = array();
        while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            array_push($jobs, $row);
        }
        return $jobs;
    }
}