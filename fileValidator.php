<?php 
$lastrow = false;


header('Content-Type: text/plain; charset=utf-8');
$dir = "tmp/";
move_uploaded_file($_FILES["file"]["tmp_name"], $dir. $_FILES["file"]["name"]);
$file_name = $dir. $_FILES["file"]["name"];
  $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
     echo'<div id="result">';
     $validate = "pass";
     if(in_array($_FILES['file']['type'],$mimes)){
	 $validate = "pass";
	  $file_handle = fopen("$file_name", "r");
	  //check number of compounds
	  $row = 0;
	  $msg = '';
	  $compound = array();
	 
	  while (($record = fgetcsv($file_handle)) !== FALSE) {
      $compound[] = $record;
	  $row++;
      }
	  fclose($file_handle);
	  if($row > 10)
	  {
	    $msg = "Number of compounds exceed maximum value allowed";
		$validate = "fail";
	  }
    } 
	
	
	else {
	   $validate = "fail";
       $msg = "Invalid file format. Please upload csv file";
}
    if($validate == "pass")
	{
      $msg = "Please select continue";	
	  }
     echo"$msg";
     echo'</div>';
	 echo '<label id="filename" style="display:none;">';
		   echo "$file_name</label>";
?>


