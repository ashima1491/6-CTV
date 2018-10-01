<?php
/* Excel reader setup to read from CTV flat file */
//require_once 'Excel/reader.php';
//echo "Hello";
// print_r($_POST);
// exit;
$time_start = time();
  $time_lapse = 0;
require_once 'Excel/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("CTV_data_2016-xls.xls");
// $data = new Spreadsheet_Excel_Reader("ctv_data.xls");
error_reporting(E_ALL ^ E_NOTICE);


$search_var=$_POST['compoundName'];  //Retrieve compound name from user
$mol_Weight =$_POST['MolWeight']; //Retrieve molecular weight


echo '<link href="css/bootstrap.css" rel="stylesheet">';
echo '<script type="text/javascript" src="js/customScript.js"></script>';
echo '	<style>
		td {
    		border: 1px solid black;
			padding-left: 1px;
			padding-right: 1px;
		}
		#title{border-top: 10px;}
		
	</style>';

echo '<br><br><div class="row">';
echo '	<h2 style="background-color:;">Step 4<small>: Results</small></h2>';
echo	'<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="background-color: ;">';
		

			$imageValue = $_POST['CompoundImage'];
echo '';// '		<div style="text-align: left;">&nbsp; &nbsp; ';
echo '			<img src="data:image/png;base64,' . $imageValue . '" />';

		
echo '		</div>';	// end first div in row.
echo '	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="background-color:;"><br><br><br>';

echo "		<p><b>Common Name: $search_var </b></p>";
echo '		<ul class="legend">';
echo '			<li><span class="superawesome" style="background-color: LightSkyBlue;">';
echo '				</span> <b>These values were predicted<sup>*</sup>.</B></li>';

echo '			<li><span class="superawesome" style="background-color: #f5febb;" ></span>';
echo ' 				<B style="text-indent: -30px;">';
echo 				'These value were retrieved from publicly available sources ';
echo '				(<a href="CTV_data_2016-xls.xls" target="_blank">Data Table</a>).</B></li><br>';
echo '		</ul>';



echo '	</div>';	// end of second div in row
echo '</div>';		// end of row







echo '<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:;">';





echo '<div style = "width-max: 500px; margin:auto; background-color:; ">';
	// this div holds the table.
	
echo '<table id="compResults" border="2" style="text-align: center; margin: auto; padding-right: 3px; padding-left: 3px;">';


for ($i = 1; $i <= $data->rowcount($sheet_index=0); $i++) {
	if(strcasecmp(strtolower($data->val($i,3)), strtolower($_POST['compoundName'])) ==0) {	
		// if the compound name matches
		$value_RfD = $data->val($i, 15);
		$source_RfD = $data->val($i, 20);
		
		$value_RfC = $data->val($i, 23);
		$source_RfC = $data->val($i, 28);
		
		$value_OSF = $data->val($i, 31);
		$source_OSF = $data->val($i, 36);
		
		$value_IUR = $data->val($i, 39);
		$source_IUR = $data->val($i, 44);
		
		$value_CPV = $data->val($i, 47);
		$source_CPV = $data->val($i, 52);	 
		
		if(($_POST['refDose'] == "true" && $value_RfD != 0 )|| ($_POST['refConc'] == "true" && $value_RfC != 0 ) || ($_POST['oralSlope'] == "true" && $value_OSF != 0 ) || ($_POST['ihalUnit'] == "true" && $value_IUR != 0 ) || ($_POST['cancPot'] == "true" && $value_CPV != 0 )) {	
			echo '<tr style = "border-top: 8px solid black;"><td>Chemical name</td>';
			echo '<td colspan="2">Endpoint</td><td colspan="2">Toxicity value</td>';
			echo '<td>Unit</td><td colspan="2">Source</td></tr>';
			}
		
		break;
		} 	// end of text match, if(strcasecmp($data->val($i,2), $_POST['compoundName']) ==0) {}
	}		// end of going through rows, for ($i = 1; $i <= $data->rowcount($sheet_index=0); $i++) {}

if($_POST['refDose'] == "true" && $value_RfD != 0 ){
	Display_exist_value($_POST['compoundName'], "Reference Dose", $value_RfD, $source_RfD, 'mg/(kg&middot;day)');
	$_POST['refDose'] = False;
	}

if($_POST['refConc'] == "true" && $value_RfC != 0 ){
	Display_exist_value($_POST['compoundName'], "Reference Concentration", $value_RfC, $source_RfC, 'mg/m<sup>3</sup>');
	$_POST['refConc'] = False;
	}

if($_POST['oralSlope'] == "true" && $value_OSF != 0 ){
	Display_exist_value($_POST['compoundName'], "Oral Slope Factor", $value_OSF, $source_OSF, 'risk per mgl/(kg&middot;day)');
	$_POST['oralSlope'] = False;
	}
	
if($_POST['ihalUnit'] == "true" && $value_IUR != 0 ){
	Display_exist_value($_POST['compoundName'], "Inhalation Unit Risk", $value_IUR, $source_IUR, 'risk per &micro;g/m<sup>3</sup>');
	$_POST['ihalUnit'] = False;
	}

	
if($_POST['cancPot'] == "true" && $value_CPV != 0 ){
	Display_exist_value($_POST['compoundName'], "Cancer Potency Value", $value_CPV, $source_CPV, 'risk per mgl/(kg&middot;day)');
	$_POST['cancPot'] = False;
	}

	
// if any model is needed
$any_model_needed = $_POST['refDose'] == "true" || $_POST['refConc'] == "true";
$any_model_needed = $any_model_needed || $_POST['noel'] == "true";
$any_model_needed = $any_model_needed || $_POST['oralSlope'] == "true" || $_POST['ihalUnit'] == "true";
$any_model_needed = $any_model_needed || $_POST['cancPot'] == "true" || $_POST['onbdl'] == "true";
$any_model_needed = $any_model_needed || $_POST['onbd'] == "true";
// exit("589, Model needed?: ". $any_model_needed);

// echo '$_POST[refDose] '. $_POST['refDose'].'<br>';
// echo '$_POST[noel] '. $_POST['noel'].'<br>';
// echo '$any_model_needed: '. $any_model_needed;


if ($any_model_needed){
	
	// display table header
	echo '<tr ';
	echo 'style = "all: none; border: 5px; border-top: 8px solid black; ';
	echo 'border-bottom: 2px solid black; ">';
	echo '<td>Chemical name</td><td>Model Name</td><td>Unit</td><td>Prediction</td>';
	echo '<td>Lower 95%<sup>**</sup></td><td>Upper 95%<sup>**</sup></td><td>Appl Domain<sup>***</sup></td>';
	echo '<td>Note</td></tr>';
	
	//	login into chembench
  	$useDev = false;
  	$devSuffix = ($useDev === true ? '-dev' : '');
  	$username = 'register';
  	$password = 'hXOTP3Kz';
  	//$cookieJar = '/tmp/cookie.txt';
  	$cookieJar = __DIR__ . "/cookie.txt";
  	$baseUrl = "https://chembench{$devSuffix}.mml.unc.edu/";
  	$loginUrl = $baseUrl . "login?username={$username}&password={$password}";
	$requesttimeout = 700;
	
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
  	if ($loginResult === false) {
		echo "what?";
    	die(curl_error($loginRequest));
  		}
  	curl_close($loginRequest);		//end of login

  	// Start model curl
  	$smilesValue = $_POST['smilee'];
  	$cutoff = 'cutoff=999';
  	$url = "https://chembench.mml.unc.edu/makeSmilesPrediction?smiles=".$smilesValue;
  	$url .= "&cutoff=N/A&predictorIds=";
  	$mh = curl_multi_init();

	// Add each model to curl_multi
	if($_POST['refDose'] == "true")	{
	  	$REFD_CDK_67612 = Add_curl_to_multi_handle('67612'); 
	  	$REFD_ISIDA_70526 = Add_curl_to_multi_handle('70526');
	  	}
	if($_POST['noel'] == "true")	{
	  	$NOEL_CDK_67624 = Add_curl_to_multi_handle('67624'); 
	  	$NOEL_ISIDA_66226 = Add_curl_to_multi_handle('66226');
	  	}
	if($_POST['refConc'] == "true")	{
		$RFC_CDK_67600 = Add_curl_to_multi_handle('67600');  
		$RFC_ISIDA_70520 = Add_curl_to_multi_handle('70520');  
		}

	if($_POST['onbd'] == "true"){
	  	$ONBD_CDK_67570 = Add_curl_to_multi_handle('67570');	
		$ONBD_ISIDA_70508 = Add_curl_to_multi_handle('70508');
	  	}
	if($_POST['onbdl'] == "true"){
	  	$ONBDL_CDK_67582 = Add_curl_to_multi_handle('67582');
	  	$ONBDL_ISIDA_66214 = Add_curl_to_multi_handle('66214');
	  	}
		
	if($_POST['oralSlope'] == "true"){
		$OSF_CDK_67588 = Add_curl_to_multi_handle('67588');  
		$OSF_ISIDA_70514 = Add_curl_to_multi_handle('70514'); 
		}
  	if($_POST['ihalUnit'] == "true"){
		$IUR_CDK_67546 = Add_curl_to_multi_handle('67546');  
		$IUR_ISIDA_70496 = Add_curl_to_multi_handle('70496');  
		}
  	if($_POST['cancPot'] == "true"){
	  $CPV_CDK_67534 = Add_curl_to_multi_handle('67534');  
	  $CPV_ISIDA_70490 = Add_curl_to_multi_handle('70490');  
	  }  
	// above, setup multi handle.

  	// start to execute the handles
  
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
			}	// end of else{}
	
  		}	// end of while ($active && $mrc == CURLM_OK) {}, about 12 lines.  

	// Start to read data and display.
	
	$Note = '';
  	if($_POST['refDose'] == "true"){
		$model_value_1 = Read_model_curl_2values($REFD_CDK_67612);
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($REFD_ISIDA_70526);
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		// echo '$log_value_1, $log_value_2, av: '. $log_value_1. ', '. $log_value_2. ', '. $log_value;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD)', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', -1.365,  1.471, $sigma_value, $Note);
		$Note = '';
		}
		
	if($_POST['noel'] == "true")	{
		$model_value_1 = Read_model_curl_2values($NOEL_CDK_67624);
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($NOEL_ISIDA_66226);
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		// echo '$log_value_1. $log_value_2: '. $log_value_1. ', '.$log_value_2;
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Reference Dose NO(A)EL', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', -1.258,  1.326, $sigma_value, $Note);		
		$Note = '';
	  	}
	
  	if($_POST['refConc'] == "true"){
		$model_value_1 = Read_model_curl_2values($RFC_CDK_67600);	
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($RFC_ISIDA_70520);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Reference Concentration (RfC)', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/m<sup>3</sup>', 'mg/m<sup>3</sup>', -2.043,  2.156, $sigma_value, $Note);		
		$Note = '';
	  	}
	
  	if($_POST['onbd'] == "true"){  			
    	$model_value_1 = Read_model_curl_2values($ONBD_CDK_67570);	
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($ONBD_ISIDA_70508);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD) BMD', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', -1.559,  1.523, $sigma_value, $Note);
		$Note = '';
		}
	
	if($_POST['onbdl'] == "true"){
		$model_value_1 = Read_model_curl_2values($ONBDL_CDK_67582);		
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($ONBDL_ISIDA_66214);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD) BMDL', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', -1.696,  1.624, $sigma_value, $Note);	
		$Note = '';
		}		  

  	if($_POST['oralSlope'] == "true"){
		$model_value_1 = Read_model_curl_2values($OSF_CDK_67588);
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($OSF_ISIDA_70514);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];

		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Oral Slope Factor (OSF)', $log_value, $mol_Weight, 'Log<sub>10</sub>(risk per Mol/(kg&middot;day))', 'risk per mgl/(kg&middot;day)', -1.663,  1.918, $sigma_value, $Note);
		$Note = '';
    	}

	if($_POST['ihalUnit'] == "true"){		
		$model_value_1 = Read_model_curl_2values($IUR_CDK_67546);	
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($IUR_ISIDA_70496);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		Prediction_Display($_POST['compoundName'], 'CTV Inhalation Unit Risk (IUR)', $log_value, $mol_Weight, 'Log<sub>10</sub>(m<sup>3</sup>/Mol)', 'risk per &micro;g/m<sup>3</sup>', -1.853,  2.372, $sigma_value, $Note);
		$Note = '';
		}

  	if($_POST['cancPot'] == "true"){  			
    	$model_value_1 = Read_model_curl_2values($CPV_CDK_67534 );	
		$log_value_1 = $model_value_1[0];
		$sigma_value_1 = $model_value_1[1];
		
		$model_value_2 = Read_model_curl_2values($CPV_ISIDA_70490);	
		$log_value_2 = $model_value_2[0];
		$sigma_value_2 = $model_value_2[1];
		
		if ($sigma_value_1 > $sigma_value_2){$sigma_value = $sigma_value_1;}
			else {$sigma_value = $sigma_value_2;}
		
		$log_value = ($log_value_1 + $log_value_2)/2;
		if($log_value_1 == 0 || $log_value_2 == 0 ){
			$log_value = $log_value_1 + $log_value_2; 
			if($log_value_1 == 0){ 
				$Note = 'ISIDA Only';}
				else $Note = 'CDK Only';
			}
		
		// echo 'CPV: '. $log_value_1. ', '. $log_value_2. ', '. $log_value;
		
		Prediction_Display($_POST['compoundName'], 'CTV Cancer Potency Value (CPV)', $log_value, $mol_Weight,'Log<sub>10</sub>(risk per Mol/(kg&middot;day))', 'risk per mgl/(kg&middot;day)', -1.808,  1.708, $sigma_value, $Note);
		$Note = '';
    	}
        		
	}		// end of if ($any_model_needed){}










echo'</table></div></div>';
echo '</div></div><br>';		// end of div row, and end of div colum
echo '<div style="background-color:;">';
echo ' 		<p align="center">';		// 2 buttons
echo '			<input type="button" class="btn btn-primary" onclick="$(';
echo " 				'#compResults').table2CSV()";
echo ' 				" value="Export as CSV">';
echo ' 			<a class="btn btn-success" href="index-catch.php">New Prediction</a>';
echo '		</p>';
echo '</div>';		// end of div for 2 buttons


echo '<br><br>* Unless otherwise noted, each of the predicted values is an average of the predictions from two ';
echo 'QSAR models (Random Forest with ';
echo '<a href="https://www.ncbi.nlm.nih.gov/pubmed/24479757" target="_blank">CDK</a>';
echo ' descriptors and Random Forest with ';
echo '<a href="https://www.ncbi.nlm.nih.gov/pubmed/27464350" target="_blank">ISIDA</a> descriptors).<br>';
echo '** One-tailed confidence boundries on residuals from cross validation.<br>';
echo '*** Number of &sigma;. Typical applicability domain cutoffs are +1&sigma; for a more restrictive domain and +3&sigma; for a less restrictive domain. A negative value indicates the chemical is within the applicability domain. <br>';


function Read_model_curl_2values($model_curl){
	if(curl_getinfo($model_curl, CURLINFO_HTTP_CODE) == 500)   // 500 is error
		{
		$http_response = 500;
		$output = curl_multi_getcontent($model_curl);
		}
	else{
		$curl_content = curl_multi_getcontent($model_curl);
		// echo '$curl_content'. $curl_content;
        $curl_content = explode('&', $curl_content);
		$results = explode('<td>', $curl_content[1]);
        $model_value = $results[2];
		// echo '<pre>$curl_content[1], $model_value:'. $curl_content[1]. ', '. $model_value. '<br> <pre>';
		
		$results_sigma = explode('<td>', $curl_content[2]);
		$sigma_value = $results_sigma[2];
		}
	return array ($model_value, $sigma_value);
	}

function E_or_point($input_value){
	if ($input_value >= 100 || $input_value < 0.1){
		$output_value = sprintf("%.3e", $input_value);}
		else{$output_value = round($input_value, 3);}
	return $output_value;
	}

function Prediction_Display($Chemical_name, $model_name, $model_value, $mol_Weight, $model_unit, $converted_unit, $Lower_CI,  $Upper_CI, $sigma_value, $Note)
	{	

		
	// echo '<br>$model_value: '. $model_value.'<br>';
	if ($model_value != 0){		 
		
		
		$Lower_95 = $model_value + $Lower_CI;
		$Upper_95 = $model_value + $Upper_CI;
		
		// echo '$Upper_95 = $model_value + $Upper_CI: '. $Upper_95, $model_value, $Upper_CI;;
				
				
		if ($model_name == 'CTV Oral Slope Factor (OSF)' || $model_name== 'CTV Cancer Potency Value (CPV)' || $model_name == 'CTV Inhalation Unit Risk (IUR)' ){		// three models that mole is on bottom.
			
			$mole_model = 1/pow(10, $model_value);
			$mole_lower = 1/pow(10, $Lower_95);
			$mole_upper = 1/pow(10, $Upper_95);
			
			if ($model_name == 'Oral Slope Factor'){
				$Inverted_converted = $mole_model * (1000 * 1000 * $mol_Weight);
				$Inverted_converted_lower = $mole_lower * (1000 * 1000 * $mol_Weight);
				$Inverted_converted_upper = $mole_upper * (1000 * 1000 * $mol_Weight);
				}
				else{
					$Inverted_converted = $mole_model * (1000 * $mol_Weight);
					$Inverted_converted_lower = $mole_lower * (1000 * $mol_Weight);
					$Inverted_converted_upper = $mole_upper * (1000 * $mol_Weight);
					}
			$converted_value = 1/$Inverted_converted;
			$converted_lower = 1/$Inverted_converted_lower;
			$converted_upper = 1/$Inverted_converted_upper;
			// echo '$model_value. $Lower_95. $Upper_95: '.$model_value. ' '. $Lower_95. $Upper_95. ' '. $converted_value. ' '. $converted_lower. ' '. $converted_upper;
			}		// end of three models that mole is on bottom.
			
			elseif($model_name == 'CTV Reference Dose (RfD)' || $model_name== 'CTV Reference Concentration (RfC)' || $model_name == 'CTV Reference Dose (RfD) BMDL' || $model_name == 'CTV Reference Dose (RfD) BMD' || $model_name == 'CTV Reference Dose NO(A)EL'){
							
				$converted_value = pow(10, $model_value*(-1)) * 1000 * $mol_Weight;
				$converted_lower = pow(10, $Lower_95*(-1)) * 1000 * $mol_Weight;
				$converted_upper = pow(10, $Upper_95*(-1)) * 1000 * $mol_Weight;
				
				}		// end of three models that mole is on top.
			
			$model_value_f = E_or_point($model_value);
			$converted_value_f = E_or_point($converted_value);
			
			$Lower_95_f = E_or_point($Lower_95); 
			$Upper_95_f = E_or_point($Upper_95); 
			
			$converted_lower_f = E_or_point($converted_lower); 
			$converted_upper_f = E_or_point($converted_upper); 
			
	
			echo '<tr bgcolor="LightSkyBlue" style = "border: 2px; border-collapse: separate; ">';
			echo '<td style = "text-align: center; text-indent: 3px; padding-right: 3px;">';
			echo $Chemical_name. '</td><td>'. $model_name. '</td><td>'. $model_unit. '</td><td>';
			echo $model_value_f. '</td><td>'. $Lower_95_f. '</td><td>'. $Upper_95_f. '</td><td>';
			echo $sigma_value. '</td><td>'. $Note. '</td></tr>';
			
			echo '<tr bgcolor="LightSkyBlue" style = "border: 2px; border-collapse: separate; ">';
			echo '<td style = "text-align: center; text-indent: 3px; padding-right: 3px;">';
			echo $Chemical_name. '</td><td>'. $model_name. '</td><td>'. $converted_unit. '</td><td>';
			echo $converted_value_f. '</td><td>'. $converted_upper_f. '</td><td>'. $converted_lower_f. '</td><td>';
			echo $sigma_value. '</td><td>'. $Note. '</td></tr>';
			
	}	// end of 	if ($model_value != 0){	)
	else{
		echo'<tr style = "border: 2px;" bgcolor="LightSkyBlue">';
		echo '<td>'. $Chemical_name. '</td><td>'. $model_name. '</td>';
		echo '<td colspan="6" > Prediction not available</td>';
		}
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
	// curl_setopt($model_curl, CURLOPT_TIMEOUT, 120); 			//timeout in seconds
	curl_multi_add_handle($mh, $model_curl);
	
	return $model_curl;
}
//Display_exist_value("Reference Dose", $value_RfD, $mol_Weight, 'mg/(kg x day)');

function Display_exist_value($Chemical_name, $model_name, $value, $source, $converted_unit){
    echo'<tr bgcolor="#f5febb" style = "all: none; border: 5px; border-right: 2px;  border-bottom: 2px solid black; ">';
	
    
	if ($value >= 100 || $value < 0.1){
		$field_1 = sprintf("%.3e",($value));}
		else{$field_1 = round($value, 3);}
	echo '<td>'. $Chemical_name. '</td><td colspan="2">'. $model_name. '</td>';
    echo '<td colspan="2">'. $field_1. '</td>';
	echo "<td> $converted_unit</td><td colspan='2'>". $source .'</td></tr>';
}	  


?>