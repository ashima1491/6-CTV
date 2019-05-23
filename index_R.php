<!DOCTYPE html>
<html lang="en">
<!-- Scripts/script.js was used to sense the click of buttons -->
<head>



<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>CTV</title>

<script type="text/javascript" src="Scripts/jquery.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="Scripts/script.js"></script>
<script type="text/javascript" src="Scripts/Search_R_js.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript"
	src="Scripts/jsme.nocache.js"></script>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!---->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- with glyaphicons-->
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- <link href="css/bootstrap.css" rel="stylesheet"> -->
<!-- Custom styles for this template -->
<link href="css/jumbotron.css" rel="stylesheet">

<script>
        function jsmeOnLoad() {
            jsmeApplet = new JSApplet.JSME("jsme_container", "350px", "290px");
            document.JME = jsmeApplet;
        }
        function getSmiles() {
            var data = document.JME.smiles();
            document.getElementById("compoundNames").value = data;
        }
    </script>
<script type="text/javascript">
        $(document).ready(function(event) {
            $('#form1').ajaxForm(function(data)
			{
                $('#ctvInfo').replaceWith(data);
                $('#file_check').css("display", "block");
            });
        });
    </script>
<style>
td {
	border: 1px solid black;
}

#title {
	border-top: 10px;
}
</style>

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async
	src="https://www.googletagmanager.com/gtag/js?id=UA-107014652-1"></script>
<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments)};
		gtag('js', new Date());

		gtag('config', 'UA-107014652-1');
		// alert("G");
	</script>
</head>
<body>
<?php include("Header_R.html"); ?>

<div class="container-fluid" style="padding-bottom: 50px;">
		<div id="just_a_test"></div>
		<div id="results" title="Results">
			<br>resultss<br>resultss<br>
			<div id="resultss" title="Results-3" style="background-color:;">
				<br>resultss<br>resultss<br>res
				<p></p>
				<br>resultss
			</div>
		</div>

		<div class="container-shadow"
			style="min-height: 650px; width: 95%; margin: auto; padding: 100px; padding-top: 25px; -webkit-box-shadow: 0 0 6px 4px black; -moz-box-shadow: 0 0 6px 4px black; box-shadow: 0 0 16px 4px black;">

			<div id="spinner" class="spinner" style="display: none;">
				<p align="center">
					<img id="img-spinner" src="images/ajax-loader.gif"
						alt="Loading ..." /> Please wait, this process normally lasts
					about 2-3 minutes.
				
				
				<div id="show_content"></div>
				</p>
			</div>

			<div style="margin: auto;">
				<div id="step1">


					<div>
						<div id="single_compound">
							<h2>Step 1</h2>

							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xsm-6"
									style="background-color:;">

									
									<div
										style="width: auto; text-align: justify; background-color:;">
										<b>Enter compound name, CASRN, or SMILES below. Compounds will
											be searched using <a
											href="https://pubchemdocs.ncbi.nlm.nih.gov/pug-rest$_Toc494865566"
											target="_blank">PubChem.</a> Mixtures, inorganic compounds,
											and metallic compounds cannot be predicted by CTV.
										</b>
									</div>
									<br>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"
											name="inlineRadioOptions" id="inlineRadio1" value="name">
										<label class="form-check-label" for="inlineRadio1">Compound Name</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"
											name="inlineRadioOptions" id="inlineRadio2" value="cas">
										<label class="form-check-label" for="inlineRadio2">CAS Number</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio"
											name="inlineRadioOptions" id="inlineRadio3" value="smiles"
											> <label class="form-check-label" for="inlineRadio3">SMILES
											</label>
									</div>
									<textarea rows="3" id="compoundNames"
										placeholder="Enter search identifier"
										style="width: 100%;"></textarea>
									<br>
									<br>

									<div style="text-align: center;">
										<button type="submit" id="compoundSearch"
											class="btn btn-default btn-primary">Search</button>
										<br>
										<br>
									</div>
								</div>
								<!-- end of class="col-lg-6... -->

								<div class="col-lg-6 col-md-6 col-sm-6 col-xsm-6">
									<div id="jsme_applet">
										<div id="draw_structure">
											<div id="jsme_container"></div>

										</div>
										<br>
										<div style="line-height: 50%;">
											<button type="button" class="btn btn-customctv"
												onclick='getSmiles();'>Get SMILES</button>
										</div>
									</div>
								</div>
								<!-- end of class="col-lg-6... -->

								<p></p>

							</div>
							<!-- end of class="row" -->


							<div class="row" align="right">
								<!--
							<a class="btn btn-default" id="multi_compounds">Multiple compounds</a>
                        -->

							</div>
						</div>
						<div id="inputfile" style="display: none;">
							<h2>Step 1</h2>
							<p>
								<b>Upload a CSV file with a maximum of 10 smile strings.
									Compounds will NOT be validated, so please ensure smiles
									strings are accurate. Mixtures, inorganic compounds, and
									metallic compounds cannot be predicted by CTV..</b>
							</p>
							<fieldset>
								<p></p>
								<form id="form1" action="fileValidator-catch.php" method="post"
									enctype="multipart/form-data" target="uploader_iframe">
									<input id="file" type="file" name="file" /> <br /> <a
										class="btn btn-primary btn-customctv" id="cancel_multiple">Cancel</a>
									<input class="btn btn-default" id="submit" type="submit"
										value="Search" />
									</p>
								</form>
							</fieldset>
							<br>new
							<form id="form1" action="fileValidator-catch.php" method="post"
								enctype="multipart/form-data" target="_blank">
								<input id="file" type="file" name="file" /> <br /> <input
									type="submit" value="Open New..." />
								</p>
							</form>



						</div>
					</div>
				</div>


				<div id="step2" style="display: none; background-color:;">
					<h2>
						Step 2<small>: Verify Chemical Name and Structure</small>
					</h2>

					<div id="ctvInfo" style="background-color:;">hello</div>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

							<div id="reset_check" style="display: none;">
								<p align="right">
									<a class="btn btn-default" id="reset_results">Reset</a>
								</p>





							</div>


							<div id="select_check" style="display: none; width: 100%;">
								<p align="left">
									<a class="btn btn-primary btn-customctv" id="enable_check">Select</a>
									<a class="btn btn-success" id="cancel_search">Cancel / Back</a>

								</p>
							</div>




							<div id="file_check" style="display: none; width: 100%;">
								<p align="right">
									<a class="btn btn-denger" id="cancel_file">Cancel</a> <a
										class="btn btn-primary btn-customctv" id="enable_model">Continue</a>
								</p>
							</div>
						</div>
						<!-- end of class="col-lg-6 -->
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>


					</div>
					<!-- end of <div class="row"  -->

					<br> This information was obtained from <a
						href="https://pubchemdocs.ncbi.nlm.nih.gov/about" target="_blank">PubChem</a>
					on


					<script>
                            	var currentdate = new Date(); 
							   	var month = new Array();
    							month[0] = "January";
    							month[1] = "February";
    							month[2] = "March";
    							month[3] = "April";
    							month[4] = "May";
    							month[5] = "June";
    							month[6] = "July";
    							month[7] = "August";
    							month[8] = "September";
    							month[9] = "October";
    							month[10] = "November";
    							month[11] = "December";
								var n = currentdate.getMonth();
								
								function addZero(i) {
    								if (i < 10) {
        								i = "0" + i;
    									}
    								return i;
									}
								var minutes = currentdate.getMinutes();
								minutes = addZero(minutes);
    							var datetime = month[n] + "  "
									+ currentdate.getDate() + ", "
                					+ currentdate.getFullYear() + " "  
                					+ currentdate.getHours() + ":"  
                					+ minutes;
								document.write(datetime);
                            </script>





					<br>




				</div>
				<!-- end of <div id="step2"  -->

				<div id="step3" style="display: none; background-color:;">
					<div class="row">
						<div id="stepper" class="col-lg-12" style="background-color:;">
							<h2>
								Step 3<small>: Look Up Toxicity Values or Make Predictions</small>
							</h2>
							<label id="steptwoinstructions"><b> Select compound above before
									continuing </b> </label>
							<div id="steptwo" style="display: none;">
								<p>Please select a toxicity value of interest.</p>

								<script language="JavaScript">
							function Select_All(source) {
  								checkboxes = document.getElementsByName('model_selection');
  								for(var i=0, n=checkboxes.length;i<n;i++) {
    								checkboxes[i].checked = source.checked;
  									}
								}
						</script>
								<h5 style="line-height: 200%;">
									<input type="checkbox" onClick="Select_All(this)">&nbsp;&nbsp;
									<b>Select All</b> <br> <input type="checkbox"
										name="model_selection" id="Ref_dose" disabled="disabled"
										value="Ref_dose1">&nbsp;&nbsp; CTV Reference Dose (RfD) <small></small>
									<br> <input type="checkbox" name="model_selection" id="NOEL"
										disabled="disabled" value="Ref_dose_NOEL1">&nbsp;&nbsp; CTV
									Reference Dose (RfD) NO(A)EL <small></small> <BR> <input
										type="checkbox" name="model_selection" id="ONBD"
										disabled="disabled" value="ONBD1">&nbsp;&nbsp; CTV Reference
									Dose (RfD) BMD <small></small> <BR> <input type="checkbox"
										name="model_selection" id="ONBDL" disabled="disabled"
										value="ONBD1">&nbsp;&nbsp; CTV Reference Dose (RfD) BMDL <small></small>
									<BR> <input type="checkbox" name="model_selection"
										id="Ref_conc" disabled="disabled" value="Ref_conc1">&nbsp;&nbsp;
									CTV Reference Concentration (RfC) <small></small> <BR> <input
										type="checkbox" name="model_selection" id="Oral_slope"
										disabled="disabled" value="Oral_slope1">&nbsp;&nbsp; CTV Oral
									Slope Factor (OSF) <small></small> <BR> <input type="checkbox"
										name="model_selection" id="Canc_pot" disabled="disabled"
										value="Canc_pot1">&nbsp;&nbsp; CTV Cancer Potency Value (CPV)
									<small></small> <br> <input type="checkbox"
										name="model_selection" id="Ihal_unit" disabled="disabled"
										value="Ihal_unit1">&nbsp;&nbsp; CTV Inhalation Unit Risk (IUR)
									<small></small> <BR>
								</h5>

								<p></p>

							</div>
							<!-- end of id="steptwo"-->




						</div>
						<!-- end of div column  -->

					</div>
					<!-- end of div row?  -->
					<div class="row">
						<div class="col-lg-12" style="background-color:;">

							<br>
							<button type="submit" id="Search-Data-and-Model"
								class="btn btn-primary">Search Data and/or Make Prediction</button>
							<a class="btn btn-info" id="returnStep2s">One Step Back</a> <a
								class="btn btn-success" href="index_R.php">Start Over</a> <br>
							<br>

						</div>
						<!-- end of clomn -->
					</div>
					<!-- end of row -->
				</div>
				<!-- end of Step 3 -->
			</div>

		</div>
	</div>
	<!-- end of div id = container-fluid -->

	<script>
$(document).ready(function(){
	
// $("#container-outside").css({
//     background: "-webkit-gradient(linear, left top, left bottom, from(#00dede), to(#6495ed))" })
});		//end of $(document).ready(function(){
</script>

</body>

</html>