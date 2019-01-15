<?php 

  header('Content-Type:application/json');
  $method= $_SERVER['REQUEST_METHOD'];

  switch ($method) {
  	case 'GET':
  	     getData();
  		break;
  	
  	case 'POST':
  	$data= json_decode(file_get_contents('php://input'),true);
         insertData($data);   
  		break;

  	case 'PUT':
    $data= json_decode(file_get_contents('php://input'),true);
           updateData($data);
  		break;
  	
  	case 'DELETE':
 $data= json_decode(file_get_contents('php://input'),true);
           deleteData($data);
  		break;

  	default:
  	echo'{"result": "NOT supported"}';
  		break;
  }



  function getData(){

  	include "db.php";
  	//get data from test table;
  	$sql= "SELECT * FROM testtable";

  	//start mysqli_query and collect all the data and put it on to $result variable;
  	$result= mysqli_query($connect, $sql);

      //make a conditional statement to identify is there any data exist in the db_table
  	if(mysqli_num_rows($result)>0){
  		$rows=array();

  		while ($r=mysqli_fetch_assoc($result)) {
  			$rows["result"][]=$r;// To get the json data in an array object -> "result"
  			//$rows[]=$r; //To get the json data without array object only array;
  		}
  		echo json_encode($rows);
  		}
  		else{
  			echo'{"result": "NOT data found"}';
  	      }
     }




     function insertData($data){
     	include "db.php";
     	$name= $data["name"];
     	$phone= $data["phone"];

        //insert data into testtable;
     	$sql= "INSERT INTO testtable(name, phone, datetime) VALUES ('$name','$phone', NOW())";
    //make a conditional statement that data successfully inserted or not 
     	if(mysqli_query($connect,$sql)){
     		echo'{"result": "Successfully insert data"}';
     	}
     	else{
     		echo'{"result": "SQL error"}';
     	}
     }


     function updateData($data){
        include "db.php";
        $id   = $data["id"];
     	$name = $data["name"];
     	$phone= $data["phone"];

        //update data into testtable;
     	$sql= "UPDATE testtable SET name='$name', phone='$phone', datetime=NOW() WHERE id='$id'";
       //make a conditional statement that data successfully updated or not 
     	if(mysqli_query($connect,$sql)){
     		echo'{"result": "Successfully update data"}';
     	}
     	else{
     		echo'{"result": "SQL error"}';
     	}
     }


     function deleteData($data){
        include "db.php";
        $id= $data["id"];


        //update data into testtable;
     	$sql= "DELETE FROM testtable WHERE id = $id";
       //make a conditional statement that data successfully updated or not 
     	if(mysqli_query($connect,$sql)){
     		echo'{"result": "Successfully DELETE data"}';
     	}
     	else{
     		echo'{"result": "SQL error"}';
     	}

     }
 ?>