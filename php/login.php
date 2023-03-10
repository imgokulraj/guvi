<?php
    // importing msql connection and redis variables 
     include 'connection.php' ;
     include 'redis.php' ;
     // data sent from the frontend which contains the username and password for login
     $data = json_decode($_REQUEST['data'], true);
     // function to check whether username exits and password matches
     $result = checkUserNameAndPassword($conn , $data['username'] , $data['password']) ;

     // IF result['canlogin'] == false then the user has entered invalid details and reported back
     if($result['canlogin'] === false) echo json_encode($result) ; 
     // Else if the username and password matches ,
     // the session details are stored in REDIS and msg is send to the frontend that login is successfull 
     else{
        $redis->set($result['username'] , json_encode($result['details']) ) ;
        echo json_encode(['canlogin' => true , 'username' => $result['username']]) ;
     }


    // function to check username and password validity
     function checkUserNameAndPassword($conn , $username , $password) {

        // USING PREPARED SQL Statements 
        $stmt = $conn->prepare("select * from users where username= ?");
        $stmt->bind_param("s", $username);
        $stmt->execute() ;
        $result = $stmt->get_result() ; 
        $data = $result->fetch_assoc() ;

        // if no match is found in database the username doesn't exits
        if ($data === null ) {
            return ['msg' => 'Username not registered' , 'canlogin' => false] ;
        }else if (count($data) > 0){
            // if password and matches 
            if($password === $data['password']) {
                return ['msg' => 'Password matches' ,'username' => $data['username'], 'canlogin' => true , 'details' => [
                    'name' => $data['name'] ,
                    'username' => $data['username'] , 
                    'email' => $data['email'] , 
                    'password' => $data['password'] 
                ]] ;
            }else {
                // if password doesn't match 
                return ['msg' => 'Password Does not match' , 'canlogin' => false ] ; 
            }
        }
     }
?>