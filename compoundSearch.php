<?php
header("Access-Control-Allow-Origin: *");

$query=$_POST['compoundName']; 
$search= $_POST['searchType'];
$curl=curl_init();
 
 if($search=='name' || $search=='cas')
 {
     $url="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$query."/property/MolecularFormula,MolecularWeight,InChI,CanonicalSMILES,IUPACName/JSON";
     
 }

 elseif ($search=='smiles')
 {
     $url="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/SMILES/".$query."/property/MolecularFormula,MolecularWeight,InChI,CanonicalSMILES,IUPACName/JSON";
     
 }
 
curl_setopt($curl,  CURLOPT_SSL_VERIFYPEER , false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

$result=curl_exec($curl);
if(curl_errno($curl)){
    echo 'Curl error: ' . curl_error($curl);
}
//var_dump(json_decode($result, true));
$result=json_decode($result, true);
$SMILES = $result['PropertyTable']['Properties'][0]['CanonicalSMILES'];
$commonName = $result['PropertyTable']['Properties'][0]['IUPACName'];
$molecularWeight = $result['PropertyTable']['Properties'][0]['MolecularWeight'];
$formula = $result['PropertyTable']['Properties'][0]['MolecularFormula'];


$InChI = $result['PropertyTable']['Properties'][0]['InChI'];
#for getting Inchi####


echo '<div id="result" style="width: 100%;">';

echo '  <div class="row">';
echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
echo '<div style = "float: right; background-color:; width: 100%; ">';
// this div holds the table.
echo "<p><i>Your query was: $query</i></p> ";
echo "<u>PubChem information on query:</u><br>";
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





echo '</div></div>';
echo '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
echo '<div style="margin:auto; width:200px;">';
//    echo '<img src="data:image/png;base64,' . $result . '" /><br><br><br>';
if($search=='name' || $search=='cas')
{
    echo '<img src="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/'.$query.'/png" /><br><br><br>';
    
}

elseif ($search=='smiles')
{
    echo '<img src="https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/SMILES/'.$query.'/png" /><br><br><br>';
    
}

echo '</div></div></div>';
// end of <div style="margin:auto;", div row, and class="col-lg-6
//NEW CODE
// echo '<label id="compoundImage" style="display:none;"';
// echo "val=$compoundImage";
// echo '>';
// echo "$compoundImage</label>";
echo '<label id="submission" style="display:none;">single</label>';
//
echo '<p></p><p></p></div>';

// endif;











/** lets store the login token just in case we want to use it for later use**/
?>