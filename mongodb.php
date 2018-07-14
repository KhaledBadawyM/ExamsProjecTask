<?php
require_once('vendor/autoload.php');
    class mongoDatabase {

        function __construct(){
           // $this->db = (new MongoDB\Client)->Examdb->examCollec;
            $client  = new MongoDB\Client ;  
            $examdb = $client->Examdb ; 
            echo "connected to database" ;
            //$examCollec  = $examdb->createCollection('ExamCollec') ;
            $examCollec  = $examdb->ExamCollec;
            echo "examcollection created";


            // require 'vendor/autoload.php'; 
            // $client = new MongoDB\Client;
            // $companydb = $client->companydb;
            // $result1 = $companydb->createCollection('empcollection');
            // var_dump($result1);
            // echo "what the fuck is going on ";
        }

        public function insertNewExam($examInfo = []){
            if(empty($examInfo)){
                return false ;
            }

            //$inserttable = $this->db->insertOne(
            $inserttable = $this->examCollec->insertOne(    
                [
                    'examDate' => $itemInfo['examDate'],
                    'examiner' => $itemInfo['examiner'],
                    'numPages' => $itemInfo['numPages'],
                    'examLink' => $itemInfo['examLink']
                ]
            );
            return $inserttable->getInsertedId();
        } 
    }

    
?>
