
<?php
     // using mysql and redis instances
    include 'redis.php' ;
    include 'mongodb.php' ;
    //Getting the data from the frontend 
   $data = json_decode($_REQUEST['data'] , true);

   // Login Task
   if ($data['task'] === "login"){
        $userDetails = $redis->get($data['username']) ;
        // retursn userdetails from REDIS 
        echo $userDetails ;

     // LOgout task
   }else if($data['task'] === "logout") {
        $username = $data['username'] ; 
        // deleting current session in redis for logging out
        $redis->del($username) ;
        echo json_encode("deleted successfully") ;

     // getting profile details from mongodb
   }else if($data['task'] === "getdetails") {
     $document = $mongoCollection->findOne(['username' => $data['username']], ['projection' => ['_id' => 0]]);
      echo json_encode($document) ;
     
      // updating the form . which is a mongodb form
   }else if($data['task'] === "updateform" ){
     // Define the update criteria and changes
     $filter = ['username' => $data['username']];
     $update = ['$set' => ['age' => $data['age'] , 'phonenumber' => $data['phonenumber'] , 'address' => $data['address'] , 'qualifications' => $data['qualifications'] , 'schoolstudied' => $data['schoolstudied'] ]];
     // Update the documents
     $result = $mongoCollection->updateMany($filter, $update);
     echo json_encode("updated");
   }
?>