<?php
    require 'vendor/autoload.php';
    $client  = new MongoDB\Client ;  
    $examdb = $client->Examdb ; 
    $examCollec  = $examdb->ExamCollec;
    $docs = $examCollec->find();
    echo(json_encode($docs->toArray()));

 ?>   