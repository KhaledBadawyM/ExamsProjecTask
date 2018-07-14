<?php
    require 'vendor/autoload.php';
    $client  = new MongoDB\Client ;  
    $examdb = $client->Examdb ; 
    $examCollec  = $examdb->ExamCollec;
    if(isset($_GET['exam_id']))
    {
        $doc = $examCollec->findOne(['_id' => new MongoDB\BSON\ObjectId($_GET['exam_id'])]);  
        //$specs_num =  sizeof($doc)- 7  ; 
    }

    if(isset($_POST['edit']))
    {
        $examCollec->deleteOne([ '_id' => new MongoDB\BSON\ObjectId($_POST['exam_id'])] );
        $document = array();
        for ($i=1; $i <= $_POST['specs_count'] ; $i++) { 
            $name =  $_POST['spec_name'.$i.''] ;
            $value = $_POST['spec_value'.$i.''] ;
        $document[$name] = $value  ;
        }
        
        $insertOneResult = $examCollec->insertOne($document);
         
        header('Location:index.php');
        return ;
    }




?> 
<!DOCTYPE html>
<html>
<head>
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<body>
    <div id="edit_form">
        <form method="post" action="edit.php" >
            <?php
                $count = 0;  
                foreach ($doc as $key => $value) {
                    if($key == '_id')continue ;
                    $count++ ;
                    echo'  <p>'.$key.' : 
                    <input type = "text" name="spec_value'.$count.'" required value ="'.$value.'" ></p>
                    <input type = "hidden" name="spec_name'.$count.'" required value ="'.$key.'" ></p>';
                    
                }
            ?>  
            <p>Add Specs : <input type="submit" value="+" id="addSpecs" ></p>
            
            <div id="remove_div">

            </div>
            <div id="specs_div">

            </div>

            <input type = "submit" name="edit" value="Save" >
            <input type = "hidden" name="exam_id" value = "<?php echo ($_GET['exam_id']);?>" >  
        </form>
    </div> 
    <form action="index.php">
        <input type="submit" value="Cancel" />
    </form> 

    <script>
        var specs_count = <?php echo ($count); ?> ;
        var flag  = true ; 
        function Click()
        {
            $('#specs'+specs_count+'').remove();
                specs_count-- ;    
        }
        $(document).ready(function(){
            $('#addSpecs').click(function(event){
                if(flag == true)
                {
                    flag =false ;
                    $('#remove_div').append(
                        'Remove Spec <input type="button" value="-" onClick=" Click() ; return false;"><br>'  
                    )
                }
                specs_count++ ;
                event.preventDefault();
                $('#specs_div').append(
                    '<div id="specs'+specs_count+'">\
                        <input type="text" name="spec_name'+specs_count+'" placeholder="Spec Name" >\
                        <input type="text" name="spec_value'+specs_count+'" placeholder="Spec Value" >\
                        <input type="hidden" value="'+specs_count+'" name="specs_count">\
                    </div>'
                )
               
            })
        })
        
    </script>
</body>
</html> 

    
