<?php
    require '../vendor/autoload.php' ; 
    use Predis\Client as PredisClient ;
    $redis = new PredisClient() ;
    if(!$redis->exists('session-details')){
        $sessionDetails = ["a" => "" ];
        $redis->set('session-details' , json_encode($sessionDetails)) ;
    }

?>