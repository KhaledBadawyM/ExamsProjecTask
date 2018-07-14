<?php
    require 'vendor/autoload.php';
    if(isset($_POST['add']))
    {
        echo $_POST['specs_count'] ;
        $client  = new MongoDB\Client ;  
        $examdb = $client->Examdb ; 
        $examCollec  = $examdb->ExamCollec;
        $document = array('examName' => $_POST['exam_name'],
        'examDate' => $_POST['exam_date'],
        'examiner' => $_POST['examiner'],
        'numPages' => $_POST['num_pages'],
        'examLink' => $_POST['exam_url'],
        'examTime' => $_POST['exam_time'] );
        if(isset($_POST['specs_count'])){
            for ($i=1; $i <= $_POST['specs_count'] ; $i++) { 
                $name =  $_POST['spec_name'.$i.''] ;
                $value = $_POST['spec_value'.$i.''] ;
            $document[$name] = $value  ;
            }
        }    
        $insertOneResult = $examCollec->insertOne($document);      
    }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div  id="container" style="margin-left:50px ;margin-top:50px" class="input-group mb-3">
        <form method="post" action="add.php" class="form-group">
            <div class="form-group">
                <label for="examName">Exam Name</label>
                <input type="text" class="form-control" name="exam_name" id="examName" placeholder="Enter exam name" required>
            </div>
            <div class="form-group">
                <label for="examDate">Exam Date</label>
                <input type="date" class="form-control" name="exam_date" id="examDate" placeholder="Enter exam date" required>
            </div>
            <div class="form-group">
                <label for="examiner">Examiner</label>
                <input type="text" class="form-control" name="examiner" id="examiner" placeholder="Enter examiner name" required>
            </div>
            <div class="form-group">
                <label for="pages">Number Of Pages</label>
                <input type="text" class="form-control" name="num_pages" id="pages" placeholder="Enter number of exam contain pages" required>
            </div>
            <div class="form-group">
                <label for="examLink">Exam Link</label>
                <input type="url" class="form-control" name="exam_url" id="examLink" placeholder="Enter url" required>
            </div>
            <div class="form-group">
                <label for="examTime">Exam Time</label>
                <input type="time" class="form-control" name="exam_time" id="examTime" placeholder="Enter exam time" required>
            </div>
            <div style="display:inline;">
            Add Specs : <input type="submit" class="btn btn-primary" value="+" id="addSpecs" >
            </div>
            <div id="remove_div" style="display:inline;"> 
            </div>
            
            <div id="specs_div">
            </div>
          
            <input type = "submit" class="btn btn-primary" name="add" value="Submit" >
        </form>   
        <form action="index.php" class="form-group">
            <input type="submit"class="btn btn-primary" value="Cancel" />
        </form>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    </div>
    <script>
        var specs_count = 0 ;
        var flag  = true ; 
        function Click()
        {
            $('#specs'+specs_count+'').remove();
                specs_count-- ;    
        }
        $(document).ready(function(){
            $('#addSpecs').click(function(event){
                if(specs_count== 0 && flag == true)
                {
                    flag =false ;
                    $('#remove_div').append(
                        'Remove Spec <input type="button" class="btn btn-primary" value="-" onClick=" Click() ; return false;"><br>'  
                    )
                }
                specs_count++ ;
                event.preventDefault();
                $('#specs_div').append(
                    '<div id="specs'+specs_count+'" class="form-group" ">\
                            <input type="text" class="form-control" name="spec_name'+specs_count+'" placeholder="Spec Name" >\
                            <input type="text" class="form-control" name="spec_value'+specs_count+'" placeholder="Spec Value" >\
                            <input type="hidden" value="'+specs_count+'" name="specs_count">\
                    </div>'
                )
            })
        })
        
    </script>
</body>
</html>