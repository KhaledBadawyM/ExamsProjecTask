
<?php
    require 'vendor/autoload.php';
    session_start(); 
    $client  = new MongoDB\Client ;  
    $examdb = $client->Examdb ; 
    $examCollec  = $examdb->ExamCollec;

    
    if(isset($_POST['view']))
    {   
        echo ("<table border='1'>"."\n");
        
        $thDoc = $examCollec->findOne();
        foreach ($thDoc as $key => $value) {
            if($key== '_id')continue ;
            echo '<th>'.$key.'</th>';
        }
        

        $docs = $examCollec->find();
        //$arr  = $docs->toArray();
        //print_r($arr);
        //$arr = (iterator_to_array($docsCpy));
        foreach ($docs as $doc){
            echo "<tr>" ;
            foreach($doc as $key => $value){
                if($key == '_id')continue ;
                elseif($key == 'examLink')
                echo ("<td><a href='".$value."'>".$value."</a></td>")  ; 
                else
                    echo ("<td>".$value."</td>")  ;
            }
            echo('<td><a href="edit.php?exam_id='.$doc['_id'].' ">Edit</a></td> ');    
            echo "</tr>" ;
        }
        echo "</table>" ;
        
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
    <!-- <form method="post" action="index.php" >
        <input type="submit" value="View" name="view" />
    </form> -->
    <div id="container" style="margin-left:50px;margin-top:50px;">
        <input class="form-control" id="myInput" type="text" placeholder="Search...">
        <div id="table">

        </div>
        
        <a href="add.php"><input type="submit"class="btn btn-primary" value="Add" /></a>
    </div>
    <script>
        $(document).ready(function(){
            $.getJSON('json.php',function(data){
                console.log(data) ;
                table = createTable(data);
                $('#table').append(table);
            })

            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        })
        function createTable(data)
        {   
            var tableHead = document.createElement('thead');
            var tableRowH = document.createElement('tr');
            var arrHeads = [];

            data.forEach(exam => {
               // tablHead = document
                for(key in exam){
                    if(key=='_id')continue;
                    check = $.inArray(key,arrHeads)
                    if(check == -1){
                        head = document.createElement('th');
                        headData = document.createTextNode(key);
                        head.appendChild(headData);
                        tableRowH.appendChild(head);
                        arrHeads.push(key) ;
                    }
                }
            });
            tableHead.appendChild(tableRowH);
                
            console.log(tableHead);
            var tableTags = document.createElement('tbody');
            tableTags.setAttribute("id","tableBody");
            //tableTags.appendChild(tableHead)
            exam_id ='' ;
            data.forEach(exam => {
                fieldsCount=0;
                row = document.createElement('tr');
                headControle = 0 ;examCount=0 ;
                for(key in exam){
                    flag = true ;
                    if(key=='_id'){
                        exam_id = exam[key]['$oid'] ; continue;
                        }
                    if(key==arrHeads[headControle]){
                        if(key=='examLink')
                        {
                            rowCell = document.createElement('td');
                            rowA    = document.createElement('a');
                            rowA.setAttribute("href", exam[key]);
                            text = document.createTextNode(exam[key])
                            rowA.appendChild(text); 
                            rowCell.appendChild(rowA) ;
                        }
                        else{
                            rowCell = document.createElement('td');
                            cellData = document.createTextNode(exam[key]); 
                            rowCell.appendChild(cellData) ;
                        }
                    }
                    else{
                        rowCell = document.createElement('td');
                        row.appendChild(rowCell) 
                        //var i = 0 ; 
                        for(i = headControle+1 ; i<arrHeads.length ; i++)
                        {
                            if(key==arrHeads[i]){
                                rowCell = document.createElement('td');
                                cellData = document.createTextNode(exam[key]); 
                                rowCell.appendChild(cellData) ;
                                flag = true ;
                                break ;
                            }
                            else{
                                rowCell = document.createElement('td');
                                row.appendChild(rowCell); fieldsCount++;
                                flag =false ;
                            }     
                        }
                        headControle = i ; 
                    }
                    headControle++; 
                    if(flag){ 
                        row.appendChild(rowCell)
                        fieldsCount++;
                    }  
                }
                for(i=fieldsCount;i<arrHeads.length; i++ )
                {
                    rowCell = document.createElement('td');
                    row.appendChild(rowCell);
                }
                
                //row.appendChild(rowCell);
                rowCell = document.createElement('td');
                rowCellA = document.createElement('a');
                rowCellA.setAttribute("href","edit.php?exam_id="+exam_id+" ");
                cellText = document.createTextNode('Edit');
                rowCellA.appendChild(cellText);
                rowCell.appendChild(rowCellA);
                row.appendChild(rowCell);
                tableTags.appendChild(row) ;
            });
            console.log(tableTags);
            tableAll = document.createElement('table');
            tableAll.setAttribute("class","table table-bordered table-striped")
            tableAll.appendChild(tableHead);
            tableAll.appendChild(tableTags);
            console.log(tableAll);
            return  tableAll ;
            //console.log(tableTags);
          // document.write(tableTags);
        }
    </script>
</body>
</html>