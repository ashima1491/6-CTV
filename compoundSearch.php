<?php
header("Access-Control-Allow-Origin: *");

$query=$_POST['compoundName']; 
$q_name = $_POST['compoundName']; 
$thearray = array('name' => $query);

// $token="2P1NluuioKwal5EZPrRjv4PTfeUAAnsc"; // the provided password


$curl=curl_init();
// $url="https://api.rsc.org/compounds/v1/filter/name";
// $url="https://actorws.epa.gov/actorws/chemIdentifier/v01/resolve.json/identifier=".$query;
$url="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$query."/property/MolecularFormula,MolecularWeight,InChIKey,CanonicalSMILES/JSON";

curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($thearray));
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//     'apikey: 2P1NluuioKwal5EZPrRjv4PTfeUAAnsc',
    'Content-Type: application/json'
));
//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

$result=curl_exec($curl);
//print_r(curl_getinfo($curl));
if(curl_errno($curl)){
    echo 'Curl error: ' . curl_error($curl);
}
//var_dump(json_decode($result, true));
$result=json_decode($result, true);

//echo $result ;
//=json_decode($result, true);
//$data = $result['response'];
//$result = $result['response']['queryId'];


// if ( ($result == null || $result="" )):
// 	echo "<h4>No Information was found on $query </h4><pre></pre>";
// 	echo '<script>';
// 	echo '	$(document).ready(function(){';
// 	echo '		$("#enable_check").hide();});';
// 	echo '	</script>';



// else:
//   $query=$array["queryId"];

//   $url="https://api.rsc.org/compounds/v1/filter/".$query."/results";
//   $curl=curl_init();
//   curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
//   curl_setopt($curl, CURLOPT_URL, $url);
//   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//       'APIKEY:' .$token,
//       'Content-Type: application/json'
//   ));
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//   $result=curl_exec($curl);
//   $array=json_decode($result, true);

//   if ( ($result == null || $result="" )):
//       echo "<h4>No Information was found on $query </h4>";
  
//   else:
//   $recordId = $array["results"][0];
     
 
  
  
//   $url="https://api.rsc.org/compounds/v1/records/".$recordId."/details?fields=SMILES%2CMolecularWeight%2CCommonName%2CFormula";
// $curl=curl_init();
// curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//     'APIKEY:' .$token,
//     'Content-Type: application/json'
// ));
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// $result=curl_exec($curl);


// $result=json_decode($result, true);
//echo $result['PropertyTable']['Properties'][0]['MolecularFormula'];

$SMILES = $result['PropertyTable']['Properties'][0]['CanonicalSMILES'];
$commonName = $result['PropertyTable']['Properties'][0]['MolecularFormula'];
$molecularWeight = $result['PropertyTable']['Properties'][0]['MolecularWeight'];
$formula = $result['PropertyTable']['Properties'][0]['MolecularFormula'];

#for getting Inchi####
// $inputArray = array('input' => $SMILES, 'inputFormat'=> 'SMILES', 'outputFormat'=>'InChI');
// $curl=curl_init();
// $url="https://api.rsc.org/compounds/v1/tools/convert";
// curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($inputArray));
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//     'APIKEY:' .$token,
//     'Content-Type: application/json'
// ));
// $result=curl_exec($curl);
// $result=json_decode($result, true);
$InChI = $result['PropertyTable']['Properties'][0]['InChIKey'];
#for getting Inchi####


           echo '<div id="result" style="width: 100%;">';

		   echo '  <div class="row">';
		   echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
		   echo '<div style = "float: right; background-color:; width: 100%; ">';
				// this div holds the table.
		   echo "<p><i>Your query was: $q_name</i></p> ";
           echo "<u>ChemSpider information on query:</u><br>"; 		   
		   echo 'SMILES = ';
           echo '<label id="smiles" ';
		   echo "val=$SMILES";
		   echo '>';
		   echo "$SMILES</label>";
           //echo "<p>InChI = $InChI </p>";  
           echo '<p>Molecular weight = <label id="Molecularweight"';
		   echo "val=$molecularWeight";
		   echo '>';
		   echo "$molecularWeight</label>";
		   echo '</p>';
		   echo 'Common name = <label id="compoundNamer"';
		   echo "val=$commonName";
		   echo '>';
		   echo "$commonName</label>";
		   echo '<p>Formula = <label id="formula"';
		   echo "val=$formula";
		   echo '>';
		   echo "$formula</label>";
		   echo '</p>';
		   echo "<p>$InChI </p>";
// 		   echo "<a href='http://www.chemspider.com/Chemical-Structure.$recordId.html' target='_blank'>Click here to see ChemSpider page for this chemical</a>";
		   //*******Get image*********
		  		   //*******Get image*********
		  		   
		   //$thearray = array('CSID' => $query, 'token' => $token);
// 		   $url="https://api.rsc.org/compounds/v1/records/".$recordId."/image";
// 		   $curl=curl_init();
// 		   curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
// 		   curl_setopt($curl, CURLOPT_URL, $url);
// 		   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
// 		       'APIKEY:' .$token,
// 		       'Content-Type: application/json'
// 		   ));
// 		   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
// 		   $result=curl_exec($curl);
		   //var_dump(json_decode($result, true));
// 		   $result=json_decode($result,true);
// 		   $result = $result['image'];
		   

 
         //$result = substr($result, 89);
		 //$result = substr($result, 0, -15);
		 $result=null;
 		 $compoundImage = $result;
         		 
		 
		 
 
   echo '</div></div>';
   echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
   echo '<div style="margin:auto; width:200px;">';
//    echo '<img src="data:image/png;base64,' . $result . '" /><br><br><br>';
   echo '<img src="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/'.$query.'/png" /><br><br><br>';
   echo '</div></div></div>';			
		   // end of <div style="margin:auto;", div row, and class="col-lg-6 
		   //NEW CODE
		   echo '<label id="compoundImage" style="display:none;"';
		   echo "val=$compoundImage";
		   echo '>';
		   echo "$compoundImage</label>";
		   echo '<label id="submission" style="display:none;">single</label>';
		   //
           echo '<p></p><p></p></div>';		 
          
// endif;



 


 
/** lets store the login token just in case we want to use it for later use**/
?>