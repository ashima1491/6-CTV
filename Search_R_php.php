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
$search= $_POST['searchType'];



$chem_rowspan = 0;
	

	
// Search data table
for ($i = 1; $i <= $data->rowcount($sheet_index=0); $i++) {
	$compound_match = 0;
	if(strcasecmp(strtolower($data->val($i,3)), strtolower($_POST['compoundName'])) ==0) {	
		// if the compound name matches
		$compound_match = 1;
			
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
			
		$has_a_value = 0;
		if(($_POST['refDose'] == "true" && $value_RfD != 0 )|| ($_POST['refConc'] == "true" && $value_RfC != 0 ) || ($_POST['oralSlope'] == 	"true" && $value_OSF != 0 ) || ($_POST['ihalUnit'] == "true" && $value_IUR != 0 ) || ($_POST['cancPot'] == "true" && $value_CPV 	!= 0 )) 	{	
			// if there is any value available.
			$has_a_value = 1;
			}
		
		break;
		} 	// end of text match, if(strcasecmp($data->val($i,2), $_POST['compoundName']) ==0) {}
	}		// end of going through rows, for ($i = 1; $i <= $data->rowcount($sheet_index=0); $i++) {}
	
	// if any model is needed
$any_model_needed = $_POST['refDose'] == "true" && $value_RfD == 0;
$any_model_needed = $any_model_needed || ($_POST['refConc'] == "true" && $value_RfC == 0);
$any_model_needed = $any_model_needed || ($_POST['oralSlope'] == "true" && $value_OSF == 0);
$any_model_needed = $any_model_needed || ($_POST['ihalUnit'] == "true" && $value_IUR == 0);
$any_model_needed = $any_model_needed || ($_POST['cancPot'] == "true" && $value_CPV == 0);
$any_model_needed = $any_model_needed || $_POST['onbd'] == "true";
$any_model_needed = $any_model_needed || $_POST['noel'] == "true" || $_POST['onbdl'] == "true";

	
if ($any_model_needed){
	// Start model 
	$smilesValue = $_POST['smilee'];
	
	$process_id = "pi_". rand ( 100000 , 999999);
	
	$file = 'C:\\4_R\\ToxValue\\Prediction\\Prediction_temp_files\\'. $process_id. '_input.txt';

	// Write the contents back to the file
	file_put_contents($file, $smilesValue);
	
	$R_command = 
		'cmd.exe /c C:\"Program Files"\R\R-3.4.1\bin\Rscript C:\4_R\ToxValue\Prediction\Prediction_Script\Predict_new_chemical_Rscript_v3.R '. $process_id;
	

	// execute shell command.
	shell_exec ( $R_command );
	
	$warning_file = 'C:\\4_R\\ToxValue\\Prediction\\Prediction_temp_files\\'. $process_id. '_warn.txt';
	$warning = file_exists($warning_file);
	// echo "Warning: ". $warning;
			
	$warn_message = file_get_contents($warning_file);
	$warn_message = str_replace ("use" , "use. <br>" , $warn_message);
	$warn_message = str_replace ("imputed" , "imputed." , $warn_message);
	
	}
	
if($warning){
	$display_status = "none";
}	
	

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
		

			$imageValue = $_POST['  '];
echo '';// '		<div style="text-align: left;">&nbsp; &nbsp; ';
// echo '			<img src="data:image/png;base64,' . $imageValue . '" />';

if($search=='name' || $search=='cas')
{
    echo '<img src="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/'.$search_var.'/png" />';
    
}

elseif ($search=='smiles')
{
    echo '<img src="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/'.$search_var.'/png" />';
    
}


		
echo '		</div>';	// end first div in row.
echo '	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>';
echo '	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="background-color:;"><br><br><br>';

echo "		<p><b>Common Name: $search_var </b></p>";
echo '		<ul id="legend_ul" class="legend" style="display: '. $display_status. ';">';
echo '			<li><span class="superawesome" style="background-color: Beige;" ></span>';
echo ' 				<B style="text-indent: -30px;">';
echo 				'These value were retrieved from publicly available sources ';
echo '				(<a href="CTV_data_2016-xls.xls" target="_blank">Data Table</a>).</B></li>';
echo '			<li><span class="superawesome" style="background-color: LightCyan;">';
echo '				</span> <b>These values were predicted.</B></li>';
echo '		</ul>';



echo '	</div>';	// end of second div in row
echo '</div>';		// end of row


echo '<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:;">';

echo '<div style = "width-max: 500px; margin:auto; background-color:; ">';
	// this div holds the table.
	
	
if($warning){
	echo <<< EOT
	
		<div id="warning_div" style="margin-left: 20px; font-weight: bold; background-color: Salmon; padding: 50px; padding-top: 30px;
			padding-bottom: 30px;">
			
			$warn_message
		
		
			<br><br>
			<button class="btn btn-primary" onclick="Continue_Function()">Continue</button>
			<a class="btn btn-success" href="index_R.php">Start Over</a>
		

		</div>
	
		<script>
			function Continue_Function(){
				// alert("h");
				// $("#compResults").show();
				$("#compResults_display").show();
				$("#legend_ul").show();
				$("#two_buttons").show();
				$("#notes").show();
				
	
				
				
				$("#warning_div").hide();
				};
		</script>
		
		
		
		
EOT;
}		
	
	
for ($j = 0; $j < 2; $j++) {		// produce two tables one for display and one for download.
	
	if($j==0){
		echo '<table id="compResults" border="2" style="text-align: center; margin: auto; padding-right: 3px; padding-left: 3px; display: none;">';

		if($has_a_value == 1){
			echo '<tr style = "border-top: 8px solid black;"><td>Chemical name</td>';
			echo '<td colspan="2">Endpoint</td><td colspan="2">Toxicity value</td>';
			echo '<td>Unit</td><td colspan="2">Source</td></tr>';
		}
	}
	
	if($j==1){
		$GLOBALS['chem_rowspan'] = $chem_rowspan;
		echo '<table id="compResults_display" border="2" style="text-align: center; margin: auto; padding-right: 3px; padding-left: 3px; display: '. $display_status. ';">';
		if($compound_match == 1 && $has_a_value == 1){
			echo '<tr style = "border-top: 8px solid black;">';
			echo '<td>Chemical name</td>';
			echo '<td colspan="2">Endpoint</td><td colspan="2">Toxicity value</td>';
			echo '<td>Unit</td><td colspan="2">Source</td></tr>';		
			}
		}
		
	$GLOBALS['chem_display'] = 1;
	if(($_POST['refDose'] == "true" || $_POST['refDose'] == "true_2") && $value_RfD != 0 ){
		Display_exist_value($_POST['compoundName'], "Reference Dose", $value_RfD, $source_RfD, 'mg/(kg&middot;day)');
		$_POST['refDose'] = "true_2";
		if($j==0){$chem_rowspan += 1;}
		if($j==1){$GLOBALS['chem_display'] =  0; }
		}

	if(($_POST['refConc'] == "true" || $_POST['refConc'] == "true_2") && $value_RfC != 0 ){
		Display_exist_value($_POST['compoundName'], "Reference Concentration", $value_RfC, $source_RfC, 'mg/m<sup>3</sup>');
		$_POST['refConc'] = "true_2";
		if($j==0){$chem_rowspan += 1;}
		if($j==1){$GLOBALS['chem_display'] =  0; }
		}

	if(($_POST['oralSlope'] == "true" || $_POST['oralSlope'] == "true_2") && $value_OSF != 0 ){
		Display_exist_value($_POST['compoundName'], "Oral Slope Factor", $value_OSF, $source_OSF, 'risk per mg/(kg&middot;day)');
		$_POST['oralSlope'] = "true_2";
		if($j==0){$chem_rowspan += 1;}
		if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
	if(($_POST['cancPot'] == "true" || $_POST['cancPot'] == "true_2") && $value_CPV != 0 ){
		Display_exist_value($_POST['compoundName'], "Cancer Potency Value", $value_CPV, $source_CPV, 'risk per mg/(kg&middot;day)');
		$_POST['cancPot'] = "true_2";
		if($j==0){$chem_rowspan += 1;}
		if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
	if(($_POST['ihalUnit'] == "true" || $_POST['ihalUnit'] == "true_2") && $value_IUR != 0 ){
		Display_exist_value($_POST['compoundName'], "Inhalation Unit Risk", $value_IUR, $source_IUR, 'risk per &micro;g/m<sup>3</sup>');
		$_POST['ihalUnit'] = "true_2";
		if($j==0){$chem_rowspan += 1;}
		if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	


	if ($any_model_needed){

		
		if($warning){
			echo '<tr><td colspan="7" bgcolor="Salmon" align = "left" style="color:;"><div style="margin-left: 20px; font-weight: bold;"> ';
			echo $warn_message;
			echo '</div></tr></td> ';
			}
			
		// display table header
		echo '<tr ';
		echo 'style = "all: none; border: 5px; border-top: 8px solid black; ';
		echo 'border-bottom: 2px solid black; ">';
		if ($GLOBALS['chem_display'] == 1){echo '<td>Chemical name</td>';}
		echo '<td>Model Name</td><td>Unit</td><td>Prediction</td>';
		echo '<td>Lower 95%<sup>*</sup></td><td>Upper 95%<sup>*</sup></td><td>Appl Domain<sup>**</sup></td>';
		echo '</tr>';
	
		$csv = array_map('str_getcsv', file('C:\\4_R\\ToxValue\\Prediction\\Prediction_temp_files\\'. $process_id. '_output.csv'));
	
		if($_POST['refDose'] == "true"){
			$log_value = $csv[1][1];
			$Lower_CI = $csv[1][2];  
			$Upper_CI = $csv[1][3]; 
			$sigma_value = $csv[1][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD)', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['noel'] == "true")	{
			$log_value = $csv[2][1];
			$Lower_CI = $csv[2][2];  
			$Upper_CI = $csv[2][3]; 
			$sigma_value = $csv[2][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Reference Dose NO(A)EL', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['onbd'] == "true"){  				
			$log_value = $csv[4][1];
			$Lower_CI = $csv[4][2];  
			$Upper_CI = $csv[4][3];
			$sigma_value = $csv[4][4];
	
			Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD) BMD', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', 	$Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['onbdl'] == "true"){
			$log_value = $csv[3][1];
			$Lower_CI = $csv[3][2];  
			$Upper_CI = $csv[3][3];
			$sigma_value = $csv[3][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Reference Dose (RfD) BMDL', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/(kg&middot;day)', 'mg/(kg&middot;day)', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}	
	
		if($_POST['refConc'] == "true"){
			$log_value = $csv[7][1];
			$Lower_CI = $csv[7][2];  
			$Upper_CI = $csv[7][3]; 
			$sigma_value = $csv[7][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Reference Concentration (RfC)', $log_value, $mol_Weight, '  -Log<sub>10</sub>Mol/m<sup>3</sup>', 'mg/m<sup>3</sup>', $Lower_CI,  $Upper_CI, $sigma_value);		
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['oralSlope'] == "true"){
			$log_value = $csv[5][1];
			$Lower_CI = $csv[5][2];  
			$Upper_CI = $csv[5][3];
			$sigma_value = $csv[5][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Oral Slope Factor (OSF)', $log_value, $mol_Weight, 'Log<sub>10</sub>(risk per Mol/(kg&middot;day))', 'risk per mg/(kg&middot;day)', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['cancPot'] == "true"){  			
			$log_value = $csv[6][1];
			$Lower_CI = $csv[6][2];  
			$Upper_CI = $csv[6][3];
			$sigma_value = $csv[6][4];
		
			// echo 'CPV: '. $log_value_1. ', '. $log_value_2. ', '. $log_value;
		
			Prediction_Display($_POST['compoundName'], 'CTV Cancer Potency Value (CPV)', $log_value, $mol_Weight,'Log<sub>10</sub>(risk per Mol/(kg&middot;day))', 'risk per mg/(kg&middot;day)', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
		}
	
		if($_POST['ihalUnit'] == "true"){		
			$log_value = $csv[8][1];
			$Lower_CI = $csv[8][2];  
			$Upper_CI = $csv[8][3];
			$sigma_value = $csv[8][4];
		
			Prediction_Display($_POST['compoundName'], 'CTV Inhalation Unit Risk (IUR)', $log_value, $mol_Weight, 'Log<sub>10</sub>(m<sup>3</sup>/Mol)', 'risk per &micro;g/m<sup>3</sup>', $Lower_CI,  $Upper_CI,  $sigma_value);
			if($j==0){$chem_rowspan += 2;}
			if($j==1){$GLOBALS['chem_display'] =  0; }
			}

	
		// function Prediction_Display($Chemical_name, $model_name, $model_value, $mol_Weight, $model_unit, $converted_unit, $Lower_CI,  $Upper_CI, $sigma_value)

	}		// end of if ($any_model_needed){}



	echo '</table><br><br>';

}	// end of for ($j = 0; $j <= 2; $j++)



echo '</div></div>';
echo '</div></div><br>';		// end of div row, and end of div colum
echo '<div id="two_buttons" style="display: '. $display_status. ';">';
echo ' 		<p align="center">';		// 2 buttons
echo '			<input type="button" class="btn btn-primary" id = "Export_CSV" value="Export as CSV">';
echo ' 			<a class="btn btn-success" href="index_R.php">Start Over</a>';
echo '		</p>';
echo '</div>';		// end of div for 2 buttons
echo '<script> 
		$("#Export_CSV").click(function() {
			// alert("");
			$("#compResults").show();
			$("#compResults").table2CSV();
			$("#compResults").hide();
		})</script>
';
echo '<br><br>';
echo '<div id = "notes" style="display: '. $display_status. ';">';
echo '* One-tailed confidence bounds, based on residuals from cross validation.<br>';
echo '** Number of &sigma;. Typical applicability domain cutoffs are <3&sigma; for a less restrictive domain and <1&sigma; for a more restrictive domain. A negative value indicates the chemical is within the applicability domain. <br><div>';




function E_or_point($input_value){
	if ((abs($input_value) >= 1000 || abs($input_value) < 0.001) && $input_value <> 0){
		$output_value = sprintf("%.2e", $input_value);}
		elseif(abs($input_value) >= 100 && abs($input_value) < 1000){
			$output_value = round($input_value, 0);
		}
		elseif(abs($input_value) >= 10 && abs($input_value) < 100){
			$output_value = sprintf("%01.1f", round($input_value, 1));
		}
		elseif((abs($input_value) >= 1 && abs($input_value) < 10) || $input_value == 0){
			$output_value = sprintf("%01.2f", round($input_value, 2));
		}
		elseif(abs($input_value) >= 0.1 && abs($input_value) < 1){
			$output_value = sprintf("%01.3f", round($input_value, 3));
		}
		elseif(abs($input_value) >= 0.01 && abs($input_value) < 0.1){
			$output_value = sprintf("%01.4f", round($input_value, 4));
		}
		elseif(abs($input_value) >= 0.001 && abs($input_value) < 0.01){
			$output_value = sprintf("%01.5f", round($input_value, 5));
		}
		else{$output_value = round($input_value, 3);}
	return $output_value;
	}

function Prediction_Display($Chemical_name, $model_name, $model_value, $mol_Weight, $model_unit, $converted_unit, $Lower_CI,  $Upper_CI, $sigma_value)
	{		
	// echo '<br>$model_value: '. $model_value.'<br>';
	global $j;
	
	if ($model_value != 0){		 
		
		$sigma_value_f = E_or_point($sigma_value);
		$Lower_95 = $Lower_CI;
		$Upper_95 = $Upper_CI;
		
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
			
		if ($Lower_95 > $Upper_95){			// switch lower and higher
			$middle = $Lower_95;
			$Lower_95 = $Upper_95;
			$Upper_95 = $middle;
			}
			
		if ($converted_lower > $converted_upper){			// switch lower and higher
			$middle = $converted_lower;
			$converted_lower = $converted_upper;
			$converted_upper = $middle;
			}
			
		$Lower_95_f = E_or_point($Lower_95); 
		$Upper_95_f = E_or_point($Upper_95); 
			
		$converted_lower_f = E_or_point($converted_lower); 
		$converted_upper_f = E_or_point($converted_upper); 

		echo '<tr bgcolor="LightCyan" style = "border: 2px; border-collapse: separate; ">';
			
			
		if ($GLOBALS['chem_display'] == 1) {
			if ($j == 0){ echo '<td>'. $Chemical_name. '</td>'; }
			if ($j == 1){ echo '<td rowspan = '. $GLOBALS["chem_rowspan"]. '>'. $Chemical_name. '</td>'; }
			}
				
		if ($j == 0){echo '<td>'. $model_name. '</td>';}
		if ($j == 1){echo '<td rowspan = "2">'. $model_name. '</td>';}
			
		echo '<td>'. $model_unit. '</td><td>';
		echo $model_value_f. '</td><td>'. $Lower_95_f. '</td><td>'. $Upper_95_f. '</td>';
		if ($j == 0){echo '<td>'. $sigma_value_f. '</td></tr>';}
		if ($j == 1){echo '<td rowspan = "2">'. $sigma_value_f. '</td></tr>';}
			
		echo '<tr bgcolor="LightCyan" style = "border: 2px; border-collapse: separate; ">';
		if ($GLOBALS['chem_display'] == 1 && $j == 0){
			echo '<td style = "text-align: center; text-indent: 3px; padding-right: 3px;">'. $Chemical_name. '</td>';}
		if ($j == 0){echo '<td>'. $model_name. '</td>';}
		echo '<td>'. $converted_unit. '</td><td>';
		echo $converted_value_f. '</td><td>'. $converted_lower_f. '</td><td>'. $converted_upper_f. '</td>';
		if ($j == 0){echo '<td>'. $sigma_value_f.  '</td>';}
		echo '</tr>';
			
		}	// end of 	if ($model_value != 0){	)
	else{		// $model_value == 0
		echo'<tr style = "border: 2px;" bgcolor="LightCyan">';
		if ($GLOBALS['chem_display'] == 1) {
				if ($j == 0){echo '<td>'. $Chemical_name. '</td>';}
				elseif ($j == 1){echo '<td rowspan = '. $GLOBALS["chem_rowspan"]. '>'. $Chemical_name. '</td>';}}
		echo '<td>'. $model_name. '</td>';
		echo '<td colspan="6" > Prediction not available</td>';
		}
}

	

//Display_exist_value("Reference Dose", $value_RfD, $mol_Weight, 'mg/(kg x day)');

function Display_exist_value($Chemical_name, $model_name, $value, $source, $converted_unit){
    echo'<tr bgcolor="Beige" style = "all: none; border: 5px; border-right: 2px;  border-bottom: 2px solid black; ">';
	$field_1 = E_or_point($value);
	global $j;
	if ($GLOBALS['chem_display'] == 1) {
		if ($j == 0){echo '<td>'. $Chemical_name. '</td>';}
		elseif ($j == 1){echo '<td rowspan = '. ($GLOBALS["chem_rowspan"] + 1). '>'. $Chemical_name. '</td>';}}
	echo '<td colspan="2">'. $model_name. '</td>';
	// echo '<td rowspan="2">'. $Chemical_name. '</td><td colspan="2">'. $model_name. '</td>';
    echo '<td colspan="2">'. $field_1. '</td>';
	echo "<td> $converted_unit</td><td colspan='2'>". $source .'</td></tr>';
}	  


?>