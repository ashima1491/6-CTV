<?php
/* Excel reader setup to read from CTV flat file */
//require_once 'Excel/reader.php';
//echo "Hello";
// print_r($_POST);
// exit;
require_once 'Excel/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("ctv_data.xls");
error_reporting(E_ALL ^ E_NOTICE);
$requesttimeout = 700;
$submit_type = $_POST['submitValue'];

if($submit_type == "single")
{
$search_var=$_POST['compoundName'];  //Retrieve compound name from user
 $mol_Weight =$_POST['MolWeight']; //Retrieve molecular weight
 $chemBench = true;  //By default chembench is set to true, it becomes false if compound is found in flat file.
// Process flat file


for ($i = 1; $i <= $data->rowcount($sheet_index=0); $i++) {
	if(strcasecmp($data->val($i,2), $search_var) ==0) {			// Search if the compound name matches
	  $chemBench = false; //Compound is in flat file, don't make API call to chembench 
	  echo '<link href="css/bootstrap.css" rel="stylesheet">';
	  echo '<script type="text/javascript" src="js/customScript.js"></script>';
	  echo '<div style="float: left; width: 60%;">';
	  echo '<table id="compResults" BORDER="1">';
	  
	 if($_POST['refDose'] == "true")
	 {
	      $col = 10;
		  echo'<tr><td><B>Reference Dose </B></td></tr>';
          echo"<tr><td>LogMole +/- SD";
		  echo'</td><td>RfD (mg/kg-day)</td>';
		  $color = $data->bgColor($i,$col,$sheet=0);
		  if($color == "13")
		  {
		    echo '</tr><tr><td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,11);
		    echo sprintf("%.2e",($value));
		    echo'  +/-  0.7</td>';
			echo '<td BGCOLOR="#56A0D3">';
			$value = $data->val($i,$col);
			$SD = sprintf("%.2e",(pow(10, 0.7) * 1000 * $mol_Weight));
		    echo sprintf("%.2e",($value));
			echo"  +/-  $SD</td>";
		    echo '</tr>';
		  }
          else
		  {
		   echo '</tr><tr><td>';
		   $value = $data->val($i,11);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '<td>';
		   $value = $data->val($i,$col);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '</tr>';
		  }
          echo'</td>';
          echo'</tr>';		  
	  }
	  
	 
	 if($_POST['refConc'] == "true")
	 {
	      $col = 18;
		  echo'<p></P>';
		  echo'<tr><td><B>Reference Concentration </B></td></tr>';
          echo"<tr><td>LogMole +/- SD";
		  echo'</td><td>RfC (mg/m3)</td>';
		  $color = $data->bgColor($i,$col,$sheet=0);
		  if($color == "13")
		  {
		    echo '</tr><tr><td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,19);
		    echo sprintf("%.2e",($value));
		    echo'  +/-  1.08</td>';
			echo '<td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,$col);
			$SD = sprintf("%.2e",(pow(10, 1.08) * 1000 * $mol_Weight));
		    echo sprintf("%.2e",($value));
		    echo"  +/-  $SD</td>";
		    echo '</tr>';
		  }
          else
		  {
		   echo '</tr><tr><td>';
		   $value = $data->val($i,19);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '<td>';
		   $value = $data->val($i,$col);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '</tr>';
		  }
		   echo '</td>';
		   echo '</tr>';	  
	 }   
	  
	 if($_POST['oralSlope'] == "true")
	 {
		  $col = 26;
		  echo'<tr><td><B>Oral Slope Factor </B></td></tr>';
          echo"<tr><td>LogMole +/- SD";
		  echo'</td><td>OSF (per mg/kg-day)</td>';
		  $color = $data->bgColor($i,$col,$sheet=0);
		  if($color == "13")
		  {
		    echo '</tr><tr><td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,27);
		    echo sprintf("%.2e",($value));
		    echo'  +/-  0.85</td>';
			echo '<td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,$col);
			$SD = sprintf("%.2e",(pow(10, 0.85) / 1000 / $mol_Weight));
		    echo sprintf("%.2e",($value));
		    echo"  +/-  $SD</td>";
		    echo '</tr>';
		  }
          else
		  {
		   echo '</tr><tr><td>';
		   $value = $data->val($i,27);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '<td>';
		   $value = $data->val($i,$col);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '</tr>';
		  }
	      echo'</td>';
          echo'</tr>';		  
		}  
	 if($_POST['ihalUnit'] == "true")
	 {    
	      $col = 34;
		  echo'<tr><td><B>Inhalation Unit Risk </B></td></tr>';
          echo"<tr><td>LogMole +/- SD";
		  echo'</td><td>IUR (per ug/m3)</td>';
		  $color = $data->bgColor($i,$col,$sheet=0);
		  if($color == "13")
		  {
		    echo '</tr><tr><td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,35);
		    echo sprintf("%.2e",($value));
		    echo'  +/-  0.95</td>';
			echo '<td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,$col);
			$SD = sprintf("%.2e",(pow(10, 0.95) / 1000000 / $mol_Weight));
		    echo sprintf("%.2e",($value));
		    echo"  +/-  $SD</td>";
		    echo '</tr>';
		  }
          else
		  {
		   echo '</tr><tr><td>';
		   $value = $data->val($i,35);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '<td>';
		   $value = $data->val($i,$col);
		   echo'</td>';
		   echo '</tr>';
		  }
	      echo'</td>';
          echo'</tr>';		  
	 }   
	 
	 if($_POST['cancPot'] == "true")
	 {
          $col = 42;
		  echo'<tr><td><B>Cancer Potency Value </B></td></tr>';
          echo"<tr><td>LogMole +/- SD";
		  echo'</td><td>CPV (per mg/kg-day)</td>';
		  $color = $data->bgColor($i,$col,$sheet=0);
		  if($color == "13")
		  {
		    echo '</tr><tr><td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,43);
		    echo sprintf("%.2e",($value));
		    echo'  +/-  0.86</td>';
			echo '<td BGCOLOR="#56A0D3">';  //predicted
			$value = $data->val($i,$col);
			$SD = sprintf("%.2e",(pow(10, 0.86) / 1000 / $mol_Weight));
		    echo sprintf("%.2e",($value));
		    echo"  +/- $SD</td>";
		    echo '</tr>';
		  }
          else
		  {
		   echo '</tr><tr><td>';
		   $value = $data->val($i,43);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '<td>';
		   $value = $data->val($i,$col);
		   echo sprintf("%.2e",($value));
		   echo'</td>';
		   echo '</tr>';
		  }
	      echo'</td>';
		  echo'</tr>';
	 }   
     
     echo'</table>';
	 echo "";
	 echo '</div>';
	 echo '<div style="float: right; width: 40%;">';
	 $imageValue = $_POST['CompoundImage'];
	 echo '<img src="data:image/png;base64,' . $imageValue . '" />';
	 echo "<p>Common Name: $search_var </p>";
	 echo '<ul class="legend">';
     echo '<li><span class="awesome"></span> <b>Predicted.</B></li>';
	 echo '<li><span class="superawesome"></span> <B>Retrieved from publicly available sources</B></li><br>';
     echo '</ul>';
	 echo' <p align="left">';
	 echo'<input type="button" onclick="$(';
	 echo"'#compResults').table2CSV()";
	 echo'" value="Export as CSV">';
	 echo'</p>';
	 echo '</div>';
     	 
    }
}
//*******************************************************************************************************************************************************//
//Compound not found in flat file, process through chembench
if($chemBench or $_POST['onbd'] == "true" or $_POST['ocbd'] == "true" )
{
  $smilesValue = $_POST['smilee'];
  $cutoff = 'cutoff=999';
  $url = "https://chembench.mml.unc.edu/makeSmilesPrediction?smiles=".$smilesValue;
  $url .= "&cutoff=N/A&predictorIds=";
  //$url = "https://chembench-dev.mml.unc.edu/makeSmilesPrediction?smiles=".$smilesValue."&cutoff=N/A&predictorIds=";
  $mh = curl_multi_init();
  //login into chembench
  $useDev = false;
  $devSuffix = ($useDev === true ? '-dev' : '');
  $username = 'soidowu';
  $password = '5uns939r';
  //$cookieJar = '/tmp/cookie.txt';
  $cookieJar = __DIR__ . "/cookie.txt";
  $baseUrl = "https://chembench{$devSuffix}.mml.unc.edu/";
  $loginUrl = $baseUrl . "login?username={$username}&password={$password}";
  
  $loginRequest = curl_init();
  curl_setopt($loginRequest, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($loginRequest, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($loginRequest, CURLOPT_URL, $loginUrl);
  curl_setopt($loginRequest, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($loginRequest, CURLOPT_COOKIEJAR, $cookieJar);
  curl_setopt($loginRequest, CURLOPT_CONNECTTIMEOUT, $requesttimeout);

  $loginResult = curl_exec($loginRequest);
  
  echo "This site is UNDER CONSTRUCTION. ";
    if ($loginResult === false) {
		echo "what?";
      die(curl_error($loginRequest));
     }
   curl_close($loginRequest);
  //end of login
  
  $http_response = 0;
  $time_out = 0;
  $output = null;
  echo '<link href="css/bootstrap.css" rel="stylesheet">';
  echo '<script type="text/javascript" src="js/customScript.js"></script>';
  echo '<div style="float: left; width: 60%;">';
  
  
  echo '<br>....... curl: '. Get_model_value('60561').'</br>.........';
  exit("will it show?");															////////////////////
  
  
  echo'<table id="compResults" BORDER="1" style="border-top-style: 15px;">';
  
  
  if($_POST['refDose'] == "true" && $chemBench)	{
	  $REFD_CDK = Add_curl_to_multi_handle('60561'); 
	  $RfD_NOEL_CDK_66220 = Add_curl_to_multi_handle('66220');
	  // $RfD_NOEL_ISIDA_66226 = Add_curl_to_multi_handle('66226');
	  }
  if($_POST['refConc'] == "true" && $chemBench)		{$RFC_CDK = Add_curl_to_multi_handle('60573');  }
  if($_POST['oralSlope'] == "true" && $chemBench)	{$OSF_CDK = Add_curl_to_multi_handle('60507');  }
  
  if($_POST['ihalUnit'] == "true" && $chemBench)  	{$IUR_CDK = Add_curl_to_multi_handle('60549');  }
  if($_POST['cancPot'] == "true" && $chemBench){
	  $CPV_CDK = Add_curl_to_multi_handle('60537');  
	  $CPV_ISIDA_60543 = Add_curl_to_multi_handle('60543');  
	  }  
  if($_POST['onbd'] == "true"){
	  $ONBD_CDK_60471 = Add_curl_to_multi_handle('60471');	
	  $ONBDL_CDK_66208 = Add_curl_to_multi_handle('66208');
	  $ONBDL_ISIDA_66214 = Add_curl_to_multi_handle('66214');
	  }
  if($_POST['ocbd'] == "true"){$OCBD_CDK_60489 = Add_curl_to_multi_handle('60489');}
  // setup multi handle above.
  
  //execute the handles
  
  $active = null;

  do {
	$mrc = curl_multi_exec($mh, $active);
  } while ($mrc == CURLM_CALL_MULTI_PERFORM);

  while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
	else{
	usleep(10);
	do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	
  }	// end of while ($active && $mrc == CURLM_OK) {}, about 12 lines.
  

	// echo "Array size: ". count($results);
	// echo ", Results: ". $results;
	// echo '$_POST[refDose]: '. $_POST['refDose'];
	// echo ', CURLINFO_HTTP_CODE: '. CURLINFO_HTTP_CODE;
	// echo ', curl_getinfo($REFD_CDK, CURLINFO_HTTP_CODE): '. curl_getinfo($REFD_CDK, CURLINFO_HTTP_CODE);

	// Read data and display.
  if($_POST['refDose'] == "true"){
	  
	// Get_model_value('60561');
	// echo '<br>curl: '. Get_model_value('60561').'</br>';
	$model_value_1 = Read_model_curl($REFD_CDK);		//$REFD_CDK
	$model_value_2 = Read_model_curl($RfD_NOEL_CDK_66220);		//$REFD_CDK
	// $model_value_3 = Read_model_curl($RfD_NOEL_ISIDA_66226);		//$REFD_CDK
	
	
	$model_value = log((pow(10, $model_value_1) + pow(10, $model_value_2))/2, 10);
	Display_model_value(round($model_value, 3), $mol_Weight, 'Reference Dose', 'mg/(kg x day)');	
	}
	  
  if($_POST['refConc'] == "true"){
	$model_value = Read_model_curl($RFC_CDK);		// $RFC_CDK
	Display_model_value($model_value, $mol_Weight, 'Reference Concentration', 'mg/m<sup>3</sup>');	
    }
	
  if($_POST['onbd'] == "true"){  			
    $model_value_1 = Read_model_curl($ONBD_CDK_60471);		// $ONBD_CDK
	$model_value_2 = Read_model_curl($ONBDL_CDK_66208);		
	$model_value_3 = Read_model_curl($ONBDL_ISIDA_66214);		
	$model_value = 
		log((pow(10, $model_value_1) + pow(10, $model_value_2)+ pow(10, $model_value_3))/3, 10);
	$model_value = round($model_value, 3);
	Display_model_value($model_value, $mol_Weight, 'Oral Noncancer Benchmark CDK', 'mg/(kg x day)');	
    }		  
		  
  if($_POST['ocbd'] == "true"){  			
    $model_value = Read_model_curl($OCBD_CDK_60489);	
	Display_model_value($model_value, $mol_Weight, 'Oral Cancer Benchmark Dose', 'mg/(kg x day)');	
    }	
	  
		  
  if($_POST['oralSlope'] == "true"){ 
    $model_value = Read_model_curl($OSF_CDK);		// $OSF_CDK
	Display_model_value($model_value, $mol_Weight, 'Oral Slope', 'mg/(kg x day)');	
    }
		  
  if($_POST['ihalUnit'] == "true"){  			
    $model_value = Read_model_curl($IUR_CDK);		// $IUR_CDK
	Display_model_value($model_value, $mol_Weight, 'Inhalation Unit Risk', '&#181;g/m<sup>3</sup>');	
    }
		    
  if($_POST['cancPot'] == "true"){  			
    $model_value_1 = Read_model_curl($CPV_CDK);		
	$model_value_2 = Read_model_curl($CPV_ISIDA_60543);		
	$model_value = log((pow(10, $model_value_1) + pow(10, $model_value_2))/2, 10);
	$model_value = round($model_value, 3);
	Display_model_value($model_value, $mol_Weight, 'Cancer Potency', 'mg/(kg x day)');	
    }
        

          echo'</table>';
		  echo '</div>';
	      echo '<div style="float: right; width: 40%;">';
	      $imageValue = $_POST['CompoundImage'];
	      echo '<img src="data:image/png;base64,' . $imageValue . '" />';
	      echo "<p>Common Name: $search_var </p>";
	      echo '<ul class="legend">';
          echo '<li><span class="awesome"></span> <b>Predicted</B></li>';
	      echo '<li><span class="superawesome"></span> <B>Retrieved from publicly available sources</B></li><br>';
          echo '</ul>';
		  echo' <p align="left">';
	      echo'<input type="button" onclick="$(';
	      echo"'#compResults').table2CSV()";
	      echo'" value="Export as CSV">';
	      echo '</div>';
		  if($http_response == 500)
		  {
		    if (stripos($output, "Could not read X file descriptors:") !== false) {
                  echo "<hi>Descriptors could not be calculated for this compound. Please submit organic, non-metallic substances only; please do not submit mixtures</h1>";
                }
		  
		  }		// end of if($http_response == 500){}
}
}
else
{// multiple
//read the file here
$file_location = $_POST['fileName'];
      $row = 0;
	  $msg = '';
	  $data = array();
	  $compound = array();
	  if (!empty($file_location))
	  {
	  	$file_handle = fopen("$file_location", "r");
	  	while (($record = fgetcsv($file_handle)) !== FALSE) {
      			$data[] = $record;
	  		$row++;
      		}
	  	fclose($file_handle);
	  }
      for($i = 0; $i < $row; $i++)
	  {
	    $compound[$i] = $data[$i][0];
	  }
	  
   $REFD_CDK = array(10);
   $RFC_CDK = array(10); 
   $OSF_CDK = array(10);
   $IUR_CDK = array(10);
   $CPV_CDK = array(10);
   $ONBD_CDK = array(10);
   
   
   ///login
   $useDev = false;
   $devSuffix = ($useDev === true ? '-dev' : '');
   $username = 'soidowu';
   $password = '5uns939r';
   //$cookieJar = '/tmp/cookie.txt';
   $cookieJar = __DIR__ . "/cookie.txt";
   $baseUrl = "https://chembench{$devSuffix}.mml.unc.edu/";
   $loginUrl = $baseUrl . "login?username={$username}&password={$password}";
   $predictionUrl = $baseUrl . "/makeSmilesPrediction?smiles=".$smilesValue."&cutoff=N/A&predictorIds=".$predictorids;
   $loginRequest = curl_init();
   curl_setopt($loginRequest, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($loginRequest, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($loginRequest, CURLOPT_URL, $loginUrl);
   curl_setopt($loginRequest, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($loginRequest, CURLOPT_COOKIEJAR, $cookieJar);
   curl_setopt($loginRequest, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
   $loginResult = curl_exec($loginRequest);
   if ($loginResult === false) {
       die(curl_error($loginRequest));
   }
   curl_close($loginRequest);
   //****************************************************//
   
   $mh = curl_multi_init();
   $http_response = 0;
   $time_out = 0;
   $output = null;
   $test ="true";
   $j = 0;
   $cbreturn = array();
   $properties = array();
   
   for($i = 0; $i<10; $i++)
   {
    $url = "https://chembench.mml.unc.edu/makeSmilesPrediction?smiles=".$compound[$i]."&cutoff=N/A&predictorIds=";
	
	$REFD_CDK_predictorIDs = '60561';
	$REFD_CDK_url = $url.$REFD_CDK_predictorIDs;
	echo '$REFD_CDK_url = '. $REFD_CDK_url;
	echo '<script>alert ("60561");</script>';
    $REFD_CDK[$i] = curl_init();
	curl_setopt($REFD_CDK[$i], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($REFD_CDK[$i], CURLOPT_URL, $REFD_CDK_url);
    curl_setopt($REFD_CDK[$i], CURLOPT_ENCODING, $REFD_CDK_url);
	curl_setopt($REFD_CDK[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($REFD_CDK[$i], CURLOPT_COOKIEFILE, $cookieJar); 
	curl_setopt($REFD_CDK[$i], CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$REFD_CDK[$i]);
	
	$RFC_CDK_predictorIDs = '60573';
	$RFC_CDK_url = $url.$RFC_CDK_predictorIDs;
    $RFC_CDK[$i] = curl_init();
	curl_setopt($RFC_CDK[$i], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($RFC_CDK[$i], CURLOPT_URL, $RFC_CDK_url);
    curl_setopt($RFC_CDK[$i], CURLOPT_ENCODING, $RFC_CDK_url);
    curl_setopt($RFC_CDK[$i], CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($RFC_CDK[$i], CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($RFC_CDK[$i], CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$RFC_CDK[$i]);
	$OSF_CDK_predictorIDs = '60507';
	$OSF_CDK_url = $url.$OSF_CDK_predictorIDs;
    $OSF_CDK[$i] = curl_init();
	curl_setopt($OSF_CDK[$i], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($OSF_CDK[$i], CURLOPT_URL, $OSF_CDK_url);
    curl_setopt($OSF_CDK[$i], CURLOPT_ENCODING, $OSF_CDK_url);
	curl_setopt($OSF_CDK[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($OSF_CDK[$i], CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($OSF_CDK[$i], CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$OSF_CDK[$i]);
	$IUR_CDK_predictorIDs = '60549';
	$IUR_CDK_url = $url.$IUR_CDK_predictorIDs;
    $IUR_CDK[$i] = curl_init();
	curl_setopt($IUR_CDK[$i], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($IUR_CDK[$i], CURLOPT_URL, $IUR_CDK_url);
    curl_setopt($IUR_CDK[$i], CURLOPT_ENCODING, $IUR_CDK_url);
	curl_setopt($IUR_CDK[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($IUR_CDK[$i], CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($IUR_CDK[$i], CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$IUR_CDK[$i]);
	$CPV_CDK_predictorIDs = '60537';
	$CPV_CDK_url = $url.$CPV_CDK_predictorIDs;
    $CPV_CDK[$i] = curl_init();
	curl_setopt($CPV_CDK[$i], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CPV_CDK[$i], CURLOPT_URL, $CPV_CDK_url);
    curl_setopt($CPV_CDK[$i], CURLOPT_ENCODING, $CPV_CDK_url);
	curl_setopt($CPV_CDK[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($CPV_CDK[$i], CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($CPV_CDK[$i], CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$CPV_CDK[$i]);
  
  $active = null;
//execute the handles
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
	else{
	usleep(10);
	do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	
}
$j = 0;
  if($_POST['refDose'] == "true")
  {
	$results = curl_multi_getcontent($REFD_CDK[$i]);
    $results = explode('&',$results);
    $results = explode('RfDs_RF_CDK', $results[1]);
    $results = $results[1];
    $results = (float)substr($results, 41);
	$cbreturn[$i][$j] = $results;
	$properties[$i][$j] = "Ref Dose (logmole)"; //put all table properties in an array
	$j++;
   }
   if($_POST['refConc'] == "true")
   {
	$results = curl_multi_getcontent($RFC_CDK[$i]);
	$results = explode('&',$results);
    $results = explode('RfCs_RF_CDK', $results[1]);
    $results = $results[1];
    $results = (float)substr($results, 41);
    $cbreturn[$i][$j] = $results;
	$properties[$i][$j] = "Ref Concentration (logmole)"; //put all table properties in an array
	$j++;
   }
	
   if($_POST['oralSlope'] == "true")
   { 
    $results = curl_multi_getcontent($OSF_CDK[$i]);
	$results = explode('&',$results);
    $results = explode('OSF_RF_CDK', $results[1]);
    $results = $results[1];
    $results = (float)substr($results, 41);
    $cbreturn[$i][$j] = $results;
	$properties[$i][$j] = "Oral Slope(logmole)"; //put all table properties in an array
	$j++;
   }
	
   if($_POST['ihalUnit'] == "true")
   { 	
	$results = curl_multi_getcontent($IUR_CDK[$i]);
    $results = explode('&',$results);
    $results = explode('IUR_RF_CDK', $results[1]);
    $results = $results[1];
    $results = (float)substr($results, 41);
	$cbreturn[$i][$j] = $results;
	$properties[$i][$j] = "Ihal Unit (logmole)"; //put all table properties in an array
	$j++;
   }
   
   if($_POST['cancPot'] == "true")
   { 
	$results = curl_multi_getcontent($CPV_CDK[$i]);
	$results = explode('&',$results);
    $results = explode('CPV_RF_CDK', $results[1]);
    $results = $results[1];
    $results = (float)substr($results, 41);
    $cbreturn[$i][$j] = $results;
	$properties[$i][$j] = "Cancer Potency (logmole)"; //put all table properties in an array
	$j++;
   }
   $columns = $j;
  
   
}	// end of if($chemBench){}


echo'Data from two models: Oral Noncancer Benchmark Dose, Oral Cancer Benchmark Dose';



echo '<script type="text/javascript" src="js/customScript.js"></script>';
echo'<table id="compResults" BORDER="1">';
echo'<tr>';
echo"<td>Compound</td>";
for($x = 0; $x < $columns; $x++)
{
 echo"<td>";
 echo($properties[0][$x]);   
 echo"</td>";
}
 echo'</tr>';
for($p = 0; $p < 10; $p++)
{
   echo'<tr>';
   echo"<td>";
   echo($compound[$p]);
   echo" / ";
   echo($data[$p][1]);
   echo"</td>";
  for($x = 0; $x < $columns; $x++)
  {
    echo"<td>";
	echo($cbreturn[$p][$x]);
	echo"</td>";
  }
  echo'</tr>';
}
echo'</table><br>';
		  echo' <p align="left">';
	      echo'<input type="button" onclick="$(';
	      echo"'#compResults').table2CSV()";
	      echo'" value="Export as CSV">';
   
 unlink($file_location);  
   
   //****************************************************//
}





function Get_model_value($Model_ID){
		global $url, $cookieJar, $requesttimeout, $loginUrl, $active;
	$model_curl = curl_multi_init();
	
	$useDev = false;
  	$devSuffix = ($useDev === true ? '-dev' : '');
	$username = 'soidowu';
  	$password = '5uns939r';
  	//$cookieJar = '/tmp/cookie.txt';
  	$cookieJar = __DIR__ . "/cookie.txt";
  	$baseUrl = "https://chembench{$devSuffix}.mml.unc.edu/";
  	$loginUrl = $baseUrl . "login?username={$username}&password={$password}";
	  
  $loginRequest = curl_init();
  curl_setopt($loginRequest, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($loginRequest, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($loginRequest, CURLOPT_URL, $loginUrl);
  curl_setopt($loginRequest, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($loginRequest, CURLOPT_COOKIEJAR, $cookieJar);
  curl_setopt($loginRequest, CURLOPT_CONNECTTIMEOUT, $requesttimeout);

  $loginResult = curl_exec($loginRequest);

  	if ($loginResult === false) {
	  	echo "Unable to login.";
       	die(curl_error($loginRequest));
   	}
   	echo "Login passed.";
   	curl_close($loginRequest);
  

	$url = "https://chembench.mml.unc.edu/makeSmilesPrediction.action?predictorIds=60561&smiles=C1%3DCC%3DC(C%3DC1)CC(C(%3DO)O)N&cutoff=N%2FA";

	// $model_url = $url.$Model_ID;

  	curl_setopt($model_curl2, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($model_curl2, CURLOPT_SSL_VERIFYHOST, false);
  	curl_setopt($model_curl2, CURLOPT_URL, $url);
  	curl_setopt($model_curl2, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($model_curl2, CURLOPT_COOKIEJAR, $cookieJar);
  	curl_setopt($model_curl2, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
  	// curl_setopt($model_curl2, CURLOPT_TIMEOUT, 100); 			//timeout in seconds

	curl_multi_add_handle($model_curl, $model_curl2);

	// $mrc_results = curl_multi_exec($model_curl, $active);

	echo "Login passed.2, ". '$active: '. $active;
	

	 $running = null;
  do {
    curl_multi_exec($model_curl, $running);
  } while ($running);
	
/*
	
	do {
    	$mrc = curl_multi_exec($model_curl, $active);
		echo "Login passed. 2.5";
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);

	echo "Login passed.4";


	while ($active && $mrc == CURLM_OK) {
    	if (curl_multi_select($model_curl) != -1) {
			echo "Login passed.4.5";
        	do {
            	$mrc = curl_multi_exec($model_curl, $active);
        	} while ($mrc == CURLM_CALL_MULTI_PERFORM);
    	}	//end of if
		else{
		usleep(10);
		echo "Login passed.5";
			do {
            	$mrc = curl_multi_exec($model_curl, $active);
        	} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}	//end of else
	}	//end of while
	
	*/
	
	
	
	
	echo "Login passed.5.5";
	$model_value = curl_multi_getcontent($model_curl2);
	
	echo "Login passed.6";
	curl_multi_remove_handle($model_curl, $model_curl2);
	curl_close($model_curl);
	echo "Login passed.3". '$model_value: '. $model_value;
	return $model_value;
	
	


	
  	curl_close($model_curl);
	
	$model_value = curl_multi_getcontent($model_curl2);
	
	
	
	
	
	
	
	return $model_value;
}



function Add_curl_to_multi_handle($Model_ID){
	global $mh, $url, $cookieJar, $requesttimeout;
	$model_url = $url.$Model_ID;
    $model_curl = curl_init();
	curl_setopt($model_curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($model_curl, CURLOPT_URL, $model_url);
    curl_setopt($model_curl, CURLOPT_ENCODING, $model_url);
	curl_setopt($model_curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($model_curl, CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($model_curl, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_setopt($model_curl, CURLOPT_TIMEOUT, 20); 			//timeout in seconds
	curl_multi_add_handle($mh, $model_curl);
	
	return $model_curl;
}


function Read_model_curl($model_curl){
	if(curl_getinfo($model_curl, CURLINFO_HTTP_CODE) == 500)   // 500 is error
		{
		$http_response = 500;
		$output = curl_multi_getcontent($model_curl);
		}
	else{
		$model_value = curl_multi_getcontent($model_curl);
        $model_value = explode('&',$model_value);
		$results = explode('<td>', $model_value[1]);
        $model_value = $results[2];
		}
	return $model_value;
	}
			
function Display_model_value($model_value, $mol_Weight, $model_name, $converted_unit){			 
	$model_value = $model_value * (-1);
	$converted_value = sprintf("%.3e",(pow(10, $model_value) * 1000 * $mol_Weight));
	
	$SD = round($model_value * (-0.05), 3);
	$converted_SD = sprintf("%.3e", $converted_value*0.05);
			 
    echo'<tr class="ui-helper-center" style="border-top-style: 15px;">'. 
		'<td colspan="2"><B>CTV '. $model_name. '.</B></td></tr>';
	echo'<tr class="ui-helper-center"><td>  - LogMole/(kg x day)  &#177;SD';
	echo'</td><td class="ui-helper-center">';
	echo $converted_unit. '</td></tr><tr class="ui-helper-center"><td bgcolor="#56A0D3">';
    echo '&nbsp;'. $model_value * (-1). " &#177;". $SD. "</td>";
	echo '<td bgcolor="#56A0D3">';
	echo $converted_value. " &#177;". $converted_SD. "</td></tr>";		
    }
			
         

	// border-top-style: none;
    // border-left-style: none;
    // border-right-style: none;
    // border-bottom-style: none;




//print_r($_POST);
?>