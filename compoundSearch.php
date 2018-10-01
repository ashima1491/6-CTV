<?php
header("Access-Control-Allow-Origin: *");
/////////////////////////////////////
/** define the SOAP client using the url for the service**/
 
// echo "From compoundsearch.php.";

$SoapiClient = new soapclient('http://www.chemspider.com/Search.asmx?WSDL', array('trace' => 1));

/*array trace helps so that we can see previous soap transactions for details see php.net documentation*/

/**create an array of parameters for login **/

$q_name = $_POST['compoundName']; 

$query=$_POST['compoundName']; 

$token="25798fdf-c956-4e7b-8294-4c92597cd614"; // the provided password

$thearray = array('query' => $query, 'token' => $token);

/** call the service, passing the parameters and the name of the operation **/

$result = $SoapiClient->SimpleSearch($thearray);
 
/** a quick test **/

// echo "From compoundsearch.php";

if (is_soap_fault($result) || ($result->SimpleSearchResult->int == null)):
	echo "<h4>No Information was found on $query </h4><pre></pre>";
	echo '<script>';
	echo '	$(document).ready(function(){';
	echo '		$("#enable_check").hide();});';
	echo '	</script>';



else:


$somevar = $result->SimpleSearchResult->int;

if($somevar[0] == "")
{
 $query=$somevar;
 }
 else
 {
 $query=$somevar[0];
  }

//$query=$somevar; //the provided username

$SoapiClients = new soapclient('http://www.chemspider.com/MassSpecAPI.asmx?WSDL', array('trace' => 1));

$thearray = array('CSID' => $query, 'token' => $token);

/** call the service, passing the parameters and the name of the operation **/

//$result = $SoapiClient->GetCompoundInfo($thearray);

$result = $SoapiClients->GetExtendedCompoundInfo($thearray);

if (is_soap_fault($result)):
	echo "<h1>No Information was found on: </h1>";

	//echo '<pre></pre>';

else:


//$Chemspider_ID = $result->GetCompoundInfoResult->CSID;
//$InChI = $result->GetCompoundInfoResult->InChI;
//$InChIKey = $result->GetCompoundInfoResult->InChIKey;
//$SMILES = $result->GetCompoundInfoResult->SMILES;


$SMILES = $result->GetExtendedCompoundInfoResult->SMILES;
$commonName = $result->GetExtendedCompoundInfoResult->CommonName;
$molecularWeight = $result->GetExtendedCompoundInfoResult->MolecularWeight;
$InChI = $result->GetExtendedCompoundInfoResult->InChI;
//echo "<h1>Smiles = $SMILES </h1><pre>";
//echo "<h1>InChI = $InChI </h1><pre>";
//echo "<h1>InChIKey = $InChIKey </h1><pre>";

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
		   echo "<p>InChI = $InChI </p>";
		   //*******Get image*********
		  		   //*******Get image*********
		   $url = "http://chemspider.com/Search.asmx/GetCompoundThumbnail?id=".$query."&token=".$token; //25798fdf-c956-4e7b-8294-4c92597cd614";
		   // echo "URL: ". $url;
              $ch = curl_init();
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_URL, $url);
   //curl_setopt($ch, CURLOPT_ENCODING, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

   $result = curl_exec($ch);

   if (!$result) {
     exit('cURL Error: '.curl_error($ch));
   }
   else{
         $result = substr($result, 89);
		 $result = substr($result, 0, -15);
		 $compoundImage = $result;
         //file_put_contents("images/$SMILES.png", base64_decode($result));
		 }		 
		 
		 
 
   echo '</div></div>';
   echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
   echo '<div style="margin:auto; width:200px;">';
   echo '<img src="data:image/png;base64,' . $result . '" /><br><br><br>';
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
           /*                  
		   echo '</div>';
		   echo '<div style="float: right; width: 15%;">';
           echo '<img src="images/';
		   echo "$SMILES.png";
		   echo '" style="background-color:white" alt="Smiley face">';
		   echo '</div>';
           echo '<p></p><p></p></div>';
		   */
endif;

endif;

 

// see the last SOAP request

//echo htmlspecialchars($SoapiClient->__getLastRequest(), ENT_QUOTES);

// print the SOAP response

//echo htmlspecialchars($SoapiClient->__getLastResponse(), ENT_QUOTES);
 
/** lets store the login token just in case we want to use it for later use**/
?>