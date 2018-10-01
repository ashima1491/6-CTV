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
	if(strcasecmp($data->val($i,2), $search_var) ==0) {
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
if($chemBench)
{
  $smilesValue = $_POST['smilee'];
  $cutoff = 'cutoff=999';
  $url = "https://chembench.mml.unc.edu/makeSmilesPrediction?smiles=".$smilesValue."&cutoff=N/A&predictorIds=";
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
  // echo "Good so far.";
  // echo '__DIR__: '. __DIR__;
	
	
	
	
	
  $loginResult = curl_exec($loginRequest);
  echo "This site in UNDER CONSTRUCTION. ";
    if ($loginResult === false) {
		echo "what?";
      die(curl_error($loginRequest));
     }
   curl_close($loginRequest);
  //end of login
  echo "Website is being tested.";
  $http_response = 0;
  $time_out = 0;
  $output = null;
  echo '<link href="css/bootstrap.css" rel="stylesheet">';
  echo '<script type="text/javascript" src="js/customScript.js"></script>';
  echo '<div style="float: left; width: 60%;">';
  echo'<table id="compResults" BORDER="1">';
  if($_POST['refDose'] == "true")
  {
    $REFD_CDK_predictorIDs = '60561';
	$REFD_CDK_url = $url.$REFD_CDK_predictorIDs;
	
	// echo '<td> url: '. $REFD_CDK_url. '</td>';
    $REFD_CDK = curl_init();
	curl_setopt($REFD_CDK, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($REFD_CDK, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($REFD_CDK, CURLOPT_URL, $REFD_CDK_url);
    curl_setopt($REFD_CDK, CURLOPT_ENCODING, $REFD_CDK_url);
	curl_setopt($REFD_CDK, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($REFD_CDK, CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($REFD_CDK, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$REFD_CDK);
  }
  if($_POST['refConc'] == "true")
  {
    $RFC_CDK_predictorIDs = '60573';
	$RFC_CDK_url = $url.$RFC_CDK_predictorIDs;
    $RFC_CDK = curl_init();
	curl_setopt($RFC_CDK, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($RFC_CDK, CURLOPT_URL, $RFC_CDK_url);
    curl_setopt($RFC_CDK, CURLOPT_ENCODING, $RFC_CDK_url);
    curl_setopt($RFC_CDK, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($RFC_CDK, CURLOPT_COOKIEFILE, $cookieJar); 
	curl_setopt($RFC_CDK, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$RFC_CDK);
  }
  if($_POST['oralSlope'] == "true")
  {
    $OSF_CDK_predictorIDs = '60507';
	$OSF_CDK_url = $url.$OSF_CDK_predictorIDs;
    $OSF_CDK = curl_init();
	curl_setopt($OSF_CDK, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($OSF_CDK, CURLOPT_URL, $OSF_CDK_url);
    curl_setopt($OSF_CDK, CURLOPT_ENCODING, $OSF_CDK_url);
	curl_setopt($OSF_CDK, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($OSF_CDK, CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($OSF_CDK, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$OSF_CDK);
  }
  if($_POST['ihalUnit'] == "true")
  {
    $IUR_CDK_predictorIDs = '60549';
	$IUR_CDK_url = $url.$IUR_CDK_predictorIDs;
    $IUR_CDK = curl_init();
	curl_setopt($IUR_CDK, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($IUR_CDK, CURLOPT_URL, $IUR_CDK_url);
    curl_setopt($IUR_CDK, CURLOPT_ENCODING, $IUR_CDK_url);
	curl_setopt($IUR_CDK, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($IUR_CDK, CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($IUR_CDK, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$IUR_CDK);
  }
  if($_POST['cancPot'] == "true")
  {
    $CPV_CDK_predictorIDs = '60537';
	$CPV_CDK_url = $url.$CPV_CDK_predictorIDs;
    $CPV_CDK = curl_init();
	curl_setopt($CPV_CDK, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($CPV_CDK, CURLOPT_URL, $CPV_CDK_url);
    curl_setopt($CPV_CDK, CURLOPT_ENCODING, $CPV_CDK_url);
	curl_setopt($CPV_CDK, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($CPV_CDK, CURLOPT_COOKIEFILE, $cookieJar);
	curl_setopt($CPV_CDK, CURLOPT_CONNECTTIMEOUT, $requesttimeout);
	curl_multi_add_handle($mh,$CPV_CDK);
  }
  
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
$results = curl_multi_getcontent($REFD_CDK);
// echo "Array size: ". count($results);
// echo ", Results: ". $results;
// echo '$_POST[refDose]: '. $_POST['refDose'];
// echo ', CURLINFO_HTTP_CODE: '. CURLINFO_HTTP_CODE;
// echo ', curl_getinfo($REFD_CDK, CURLINFO_HTTP_CODE): '. curl_getinfo($REFD_CDK, CURLINFO_HTTP_CODE);

          if($_POST['refDose'] == "true")
          {
		     if(curl_getinfo($REFD_CDK, CURLINFO_HTTP_CODE) == 500)  //|| (curl_getinfo($REFD_ISIDA, CURLINFO_HTTP_CODE) == 500)) // 500 is error
			 {
			   $http_response = 500;
			   $output = curl_multi_getcontent($REFD_CDK);
			 }
			 else{
			  
             $rdfs_cdk = curl_multi_getcontent($REFD_CDK);
			 // echo '<tr><td>$rdfs_cdk: I am here. '; //. $rdfs_cdk;
             //$rdfs_isida = curl_multi_getcontent($REFD_ISIDA);
             $rdfs_cdk = explode('&',$rdfs_cdk);
			 // echo '$rdfs_cdk[1]: '.$rdfs_cdk[1].'</td><td>';
             //$rdfs_isida = explode('&',$rdfs_isida);
			 $results = explode('<td>', $rdfs_cdk[1]);
			 // echo '$results[2]: '.$results[2].'</td></tr>';
             // $results = explode('RfDs_RF_CDK', $rdfs_cdk[1]);
             // $resultss = explode('RfDs_CTV_RF_ISIDA', $rdfs_isida[2]);
             $rdfs_cdk = $results[1];
			 $rdfs_cdk = (float)substr($rdfs_cdk, 41);
             //$rdfs_isida = $resultss[1];
			 //$rdfs_isida = (float)substr($rdfs_isida, 41);
			 $rdfs_final = ($rdfs_cdk + $rdfs_cdk)/2;//$rdfs_isida)/2;
			 $nrdfs_final = $rdfs_final * -1;
			 $MolWe = sprintf("%.2e",(pow(10, $nrdfs_final) * 1000 * $mol_Weight));
			 $SD = sprintf("%.2e",(pow(10, 0.7) * 1000 * $mol_Weight));
			 $rdfs_final = round($rdfs_final, 2);
			 
             echo'<tr><td><B> CTV Reference Dose </B></td></tr>';
		
             echo'<tr><td>LogMole +/- SD';
			 echo'</td><td class="ui-helper-center">';
			 echo 'mg/kg-day</td>';
		     echo'</tr>';
		     echo'<tr>';
		     echo'<td bgcolor="#56A0D3">';
			 $rdfs_final = $results[2];
             echo"$rdfs_final  +/-  0.7</td>";
			 echo'<td bgcolor="#56A0D3">';
			 echo"$MolWe +/- $SD</td>";
             echo'</tr>';		
            }
			
          }
		  
		  if($_POST['refConc'] == "true")
          {
		     if(curl_getinfo($RFC_CDK, CURLINFO_HTTP_CODE) == 500)
			 {
			   $http_response = 500;
			   $output = curl_multi_getcontent($RFC_CDK);
			 }
			 else{
             $rconc_cdk = curl_multi_getcontent($RFC_CDK);
             //$rconc_isida = curl_multi_getcontent($RFC_ISIDA);
             $rconc_cdk = explode('&',$rconc_cdk);
			 // echo '<tr><td>$rconc_cdk[1]: '.$rconc_cdk[1].'</td></tr>';
			 //$rconc_isida = explode('&',$rconc_isida);
			 $results = explode('<td>', $rconc_cdk[1]);
			 // $results = explode('RfCs_RF_CDK', $rconc_cdk[1]);
			 // $resultss = explode('RfCs_CTV_RF_ISIDA', $rconc_isida[2]);
			 
			 $rconc_cdk = $results[1];
			 $rconc_cdk = (float)substr($rconc_cdk, 41);
             //$rconc_isida = $resultss[1];
			 $rconc_isida = 0;//(float)substr($rconc_isida, 41);
			 $rconc_final = ($rconc_cdk + $rconc_cdk) / 2; //$rconc_isida)/2;
			 $nrconc_final = $rconc_final * -1;
			 $MolWe = sprintf("%.2e",(pow(10, $nrconc_final) * 1000 * $mol_Weight));
			 $SD = sprintf("%.2e",(pow(10, 1.08) * 1000 * $mol_Weight));
			 $rconc_final = round($rconc_final, 2);
		     echo'<tr><td><B> CTV Reference Concentration </B></td></tr>';
             echo'<tr><td>LogMole +/- SD';
		     echo'</td><td class="ui-helper-center">mg/m<sup>3</sup></td>';
		     echo'</tr>';
		     echo'<tr>';
		     echo'<td bgcolor="#56A0D3">';
			 $rconc_final = $results[2];
             echo"$rconc_final  +/-  1.08</td>";
		     echo'<td bgcolor="#56A0D3">';
			 echo"$MolWe  +/-  $SD</td>";
             echo'</tr>';		
            }			 
          }
		  
		  if($_POST['oralSlope'] == "true")
          { 
		     if(curl_getinfo($OSF_CDK, CURLINFO_HTTP_CODE) == 500)
			 {
			   $http_response = 500;
			   $output = curl_multi_getcontent($OSF_CDK);
			 }
			 else{
		     $oral_cdk = curl_multi_getcontent($OSF_CDK);
             //$oral_isida = curl_multi_getcontent($OSF_ISIDA);
             $oral_cdk = explode('&',$oral_cdk);
             // $oral_isida = explode('&',$oral_isida);
             // $results = explode('OSF_RF_CDK', $oral_cdk[1]);
			 $results = explode('<td>', $oral_cdk[1]);
             //$resultss = explode('OSFs_CTV_RF_ISIDA', $oral_isida[2]);
			 
			 $oral_cdk = $results[1];
			 $oral_cdk = (float)substr($oral_cdk, 41);
             //$oral_isida = $resultss[1];
			 $oral_isida =0; //(float)substr($oral_isida, 41);
			 $oral_final = ($oral_cdk + $oral_cdk) /2; //$oral_isida)/2;
			 $MolWe = sprintf("%.2e",(pow(10, $oral_final) / 1000 / $mol_Weight));
			 $SD = sprintf("%.2e",(pow(10, 0.85) / 1000 / $mol_Weight));
			 $oral_final = round($oral_final, 2);
			 
             echo'<tr><td><B> CTV Oral Slope </B>';
             echo'<tr><td>LogMole +/- SD';
		     echo'</td><td class="ui-helper-center">Per mg/kg-day</td>';
		     echo'</tr>';
		     echo'<tr>';
		     echo'<td bgcolor="#56A0D3">';
			 $oral_final = $results[2];
             echo"$oral_final  +/-  0.85</td>";
		     echo'<td bgcolor="#56A0D3">';
			 echo"$MolWe  +/-  $SD</td>";
             echo'</tr>';		
            }
          }
		  
		  if($_POST['ihalUnit'] == "true")
          {  
		     if(curl_getinfo($IUR_CDK, CURLINFO_HTTP_CODE) == 500) 
			 {
			   $http_response = 500;
			   $output = curl_multi_getcontent($IUR_CDK);
			 }
			 else{
             $inhal_cdk = curl_multi_getcontent($IUR_CDK);
             //$inhal_isida = curl_multi_getcontent($IUR_ISIDA);
             $inhal_cdk = explode('&',$inhal_cdk);
             //$inhal_isida = explode('&',$inhal_isida);
             // $results = explode('IUR_RF_CDK', $inhal_cdk[1]);
			 $results = explode('<td>', $inhal_cdk[1]);
             //$resultss = explode('IURs_CTV_RF_ISIDA', $inhal_isida[2]);
			 
			 $inhal_cdk = $results[1];
			 $inhal_cdk = (float)substr($inhal_cdk, 41);
             //$inhal_isida = $resultss[1];
			 $inhal_isida = 0;//(float)substr($inhal_isida, 41);
			 $inhal_final = ($inhal_cdk + $inhal_cdk) / 2; //$inhal_isida)/2;
			 $MolWe = sprintf("%.2e",(pow(10, $inhal_final) / 1000000 / $mol_Weight));
			 $SD = sprintf("%.2e",(pow(10, 0.95) / 1000000 / $mol_Weight));
			 $inhal_final = round($inhal_final, 2);
		     echo'<tr><td><B> CTV Inhalation Unit Risk </B></td></tr>';
		     echo'<tr><td>LogMole +/- SD';
		     echo'</td><td class="ui-helper-center">Per ug/m<sup>3</sup></td>';
		     echo'</tr>';
		     echo'<tr>';
		     echo'<td bgcolor="#56A0D3">';
			 $inhal_final = $results[2];
             echo"$inhal_final  +/-  0.95</td>";
		     echo'<td bgcolor="#56A0D3">';
			 echo"$MolWe  +/-  $SD</td>";		  
             echo'</tr>';		
			}
          }
		  
		  if($_POST['cancPot'] == "true")
          {
		     if(curl_getinfo($CPV_CDK, CURLINFO_HTTP_CODE) == 500) 
			 {
			   $http_response = 500;
			   $output = curl_multi_getcontent($CPV_CDK);
			 }
			 else{
             $canc_cdk = curl_multi_getcontent($CPV_CDK);
             //$canc_isida = curl_multi_getcontent($CPV_ISIDA);
             $canc_cdk = explode('&',$canc_cdk);
             //$canc_isida = explode('&',$canc_isida);
             // $results = explode('CPV_RF_CDK', $canc_cdk[1]);
			 $results = explode('<td>', $canc_cdk[1]);
             //$resultss = explode('CPVs_CTV_RF_ISIDA', $canc_isida[2]);
             // $canc_cdk = $results[1];
             //$canc_isida = $resultss[1];
			 
			 // $canc_cdk = $results[1];
			 // $canc_cdk = (float)substr($canc_cdk, 41);
             //$canc_isida = $resultss[1];
			 // $canc_isida = 0;//(float)substr($canc_isida, 41);
			 // $canc_final = ($canc_cdk + $canc_cdk) / 2; //$canc_isida)/2;
			 // $MolWe = sprintf("%.2e",(pow(10, $canc_final) / 1000 / $mol_Weight)); 
			 // $SD = sprintf("%.2e",(pow(10, 0.86) / 1000 / $mol_Weight)); 
			 //  $canc_final = round($canc_final, 2);
			 
             echo'<tr><td><B> CTV Cancer Potency </B>';
             echo'<tr><td>LogMole +/- SD';
		     echo'</td><td class="ui-helper-center">Per mg/kg-day</td>';
		     echo'</tr>';
		     echo'<tr>';
		     echo'<td bgcolor="#56A0D3">';
			 $canc_final = $results[2];
			 // echo 'count($results[2]): '. count($results[2]);
             echo"$canc_final  +/-  0.86</td>";
		     echo'<td bgcolor="#56A0D3">';
			 echo"$MolWe  +/-  $SD</td>";
             echo'</tr>';		
			}
          
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
		  
		  }
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
  
   
}	
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
//print_r($_POST);
?>