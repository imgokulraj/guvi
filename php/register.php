<?php
    // importing mysql and mongodb db instances
    include 'connection.php' ;
    include 'mongodb.php' ; 

    //Recieving the form details from the frontend
    $data = json_decode($_REQUEST['data'], true);
    $res = [
        'status' => 'failed' , 
        'msg' => 'Username Already Exits'
    ] ;

    // Function to check if the username already exits 
    if (checkUserAlreadyExits($conn , $data['username']) === false){

        // Username doesn't exits
        // Registring the new user in the mysql database
        addUser($conn , $data['username'] , $data['password'] , $data['email'] , $data['name']) ;    
        $res['status'] = 'success' ;
        $res['msg'] = 'Created Successfully' ;
        // creating a mongodb database for the user 
        $emptyObject = [
            'username' => $data['username'] , 'age' => '' , 'phonenumber' => '' , 'address' => '' , 'qualifications' => '' , 'schoolstudied' => '' 
        ];
        $insertOneResult = $mongoCollection->insertOne($emptyObject);
;    }
    
    $response = json_encode($res) ; 
    
    echo $response ;
    

        // function to register a new user in the mysql database
    function addUser($conn , $username , $password , $email , $name) {
               $conn -> autocommit(FALSE);
        // Using Prepared Sql statements
        $stmt = $conn->prepare("INSERT INTO users (name, username, email , password) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die ("Error: " . $conn->error);
         };
        $stmt->bind_param("ssss", $name, $username, $email , $password);
   
      $stmt->execute();
      if (!$conn -> commit()) {
        echo "Commit transaction failed";
        exit();
      }
    }

    // functin to check whether username already exits
    function checkUserAlreadyExits($conn , $username) {
        $stmt = $conn->prepare("select username from users where username= ?");
        $stmt->bind_param("s", $username);
        $stmt->execute() ;
        $result = $stmt->get_result() ; 
        $data = $result->fetch_assoc() ;
        if ($data === null ) {
            return false ;
        }else if (count($data) > 0){
            return true ;
        }
        return false ;
    }
?>