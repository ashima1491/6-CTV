$(document).ready(
    function() {
        $('#compoundSearch').click(function() {
			// alert("This site is currently being tested.\n compoundName: "+ $('#compoundNames').val());
            $('#ctvInfo').hide();
            $('#step1').hide();
            $('#result').hide();
            $('#spinner').show();
			$('#step2').show();
			var radioValue = $("input[name='inlineRadioOptions']:checked").val();
			//alert(radioValue);
			// alert("here...7");
            $.post("compoundSearch.php", {
			// $.post("cookie.txt", {
                compoundName: $('#compoundNames').val(),
                searchType: radioValue
                },
                function(data) {
					// alert("got data: " + data);
                    $('#spinner').hide(),
                    $('#ctvInfo').replaceWith(data),
                    $('#select_check').css("display", "block");
                }
            );

        });

        $('#enable_check').click(function() {
            $('#step2').hide();
            $('#step3').show();
            $('#steptwo').css("display", "block");
            $('#steptwoinstructions').css("display", "none"),
            $('#scompoundSubmit').css("display", "block"),
            
			$('#Ref_dose').removeAttr("disabled"),
			$('#NOEL').removeAttr("disabled"),
            $('#Ref_conc').removeAttr("disabled"),
				
			$('#ONBD').removeAttr("disabled"),
			$('#ONBDL').removeAttr("disabled"),
            // $('#OCBD').removeAttr("disabled"),
				
            $('#Oral_slope').removeAttr("disabled"),
            $('#Ihal_unit').removeAttr("disabled"),
            $('#Canc_pot').removeAttr("disabled");
        });

        $('#enable_model').click(function() {
            $('#steptwo').css("display", "block");
            $('#steptwoinstructions').css("display", "none"),
                $('#mcompoundSubmit').css("display", "block"),
                $('#Ref_dose').removeAttr("disabled"),
                $('#Ref_conc').removeAttr("disabled"),
				
				$('#ONBD').removeAttr("disabled"),
                $('#OCBD').removeAttr("disabled"),
				
                $('#Oral_slope').removeAttr("disabled"),
                $('#Ihal_unit').removeAttr("disabled"),
                $('#Canc_pot').removeAttr("disabled");
        });

        $('#multi_compounds').click(function() {
			alert("Multiple compounds search is currently unavailable. It may be available by March 2017.");
            // $('#draw_structure').hide();
            // $('#single_compound').replaceWith('');
            // $('#inputfile').show();

        });


        $('#cancel_search').click(function() {
            location.reload(true);
        });
        $('#cancel_file').click(function() {
            location.reload(true);
        });
		
		$('#returnStep2s').click(function() {
            $('#step2').show();
            $('#step3').hide();
        });

        $('#cancel_multiple').click(function() {
            location.reload(true);
        });

        $('#reset_results').click(function() {
            location.reload(true);
        });

        $("#spinner").bind("ajaxSend", function() {
            $(this).show();
        }).bind("ajaxStop", function() {
            $(this).hide();
        }).bind("ajaxError", function() {
            $(this).hide();
        });


        $('#results').dialog({
            autoOpen: false,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "fade",
                duration: 1000
            },
            height: 500,
            width: 1000,
            modal: true
        });


        $('#Run').click(function() {
            $('#result').hide();
            $('#select_check').hide();
            alert("Start Search Now?");
			/*alert("This site is currently being tested.\n compoundName: "+ 	
				"compoundName: "+ $('#compoundNamer').text() +
                ", \n submitValue: " + $('#submission').text() +
                "\n MolWeight.:  "+ $('#Molecularweight').text() +
                "\n refDose:  "+ $('#Ref_dose').is(":checked") +
                "\n refConc:  "+ $('#Ref_conc').is(":checked") +
                "\n oralSlope:  "+ $('#Oral_slope').is(":checked") +
                "\n ihalUnit:  "+ $('#Ihal_unit').is(":checked") +
                "\n cancPot:  "+ $('#Canc_pot').is(":checked") +
                "\n noael:  "+ $('#NOAEL').is(":checked") +
                "\n onbd:  "+ $('#ONBD').is(":checked") +
                "\n ocbd:  "+ $('#OCBD').is(":checked") +
                "\n smilee:  "+ $('#smiles').text() +
                "\n CompoundImage:  "+ $('#compoundImage').text() + "");*/
				$('#spinner').show();
				seconds_elapse();
            $.post("results.php", {
                    compoundName: $('#compoundNamer').text(),
                    submitValue: $('#submission').text(),
                    MolWeight: $('#Molecularweight').text(),
                    refDose: $('#Ref_dose').is(":checked"),
                    refConc: $('#Ref_conc').is(":checked"),
                    oralSlope: $('#Oral_slope').is(":checked"),
                    ihalUnit: $('#Ihal_unit').is(":checked"),
                    cancPot: $('#Canc_pot').is(":checked"),
                    noael: $('#NOAEL').is(":checked"),
                    onbd: $('#ONBD').is(":checked"),
                    ocbd: $('#OCBD').is(":checked"),
                    smilee: $('#smiles').text(),
                    CompoundImage: $('#compoundImage').text()

                },
                function(newdata) {						// When search results received.
					alert("Search Results Received. ");
                    $('#spinner').hide(),
                    $('#result').show();
                    $('#reset_check').css("display", "block");
                    $('#resultss').replaceWith(newdata);
                    $('#results').dialog("open");
				}
            );

        });

        $('#Runfile').click(function() {
            $('#result').hide();
            $('#file_check').hide();
            $('#spinner').show();

            $.post("results.php", {
                    submitValue: $('#submission').text(),
                    fileName: $('#filename').text(),
                    refDose: $('#Ref_dose').is(":checked"),
                    refConc: $('#Ref_conc').is(":checked"),
                    oralSlope: $('#Oral_slope').is(":checked"),
                    ihalUnit: $('#Ihal_unit').is(":checked"),
                    cancPot: $('#Canc_pot').is(":checked"),
                    noael: $('#NOAEL').is(":checked"),
                    onbd: $('#ONBD').is(":checked"),
                    ocbd: $('#ocbd').is(":checked")

                },
                function(newdata) {
                    $('#spinner').hide(),
                        $('#result').show();
                    $('#reset_check').css("display", "block");
                    $('#resultss').replaceWith(newdata);
                    $('#results').dialog("open");
                }
            );

        });



        $("#btnExport").click(function(e) {
            window.open('data:application/vnd.ms-excel,' + $('#results').html());
            e.preventDefault();
        });

        $('#drawStructure').click(function() {
            $("#dialog").load('marvin.html', function() {
                $("#dialog").dialog("open");
            });
        });

		$('#Contact').click(function() {
			var myWindow = window.open("Contact.php", "", 
				"width=350,height=290,top=200,left=600,menubar=no，status=no，titlebar=no，toolbar=no，location=no");
			// alert("..");
			// alert('For any questions or to be notified of future updates to ToxValue.org, please send an email to <a href="mailto:conditionaltoxvalue@gmail.com" target="_blank">conditionaltoxvalue@gmail.com</a>.');
			// $( "#Contact_dialog" ).dialog({autoOpen: true, position: ['right','top'], width:'400',});
			});
		$('#About').click(function() {
			// alert(".2");
			var myWindow = window.open("about.php", "", 
				"width=200,height=100,top=200,left=600,menubar=no，status=no，titlebar=no，toolbar=no，location=no");
			//$( "#About_dialog" ).dialog({autoOpen: true, position: ['right','top'], width:'200',});
			});

        $("#dialog").dialog({
            autoOpen: false,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "fade",
                duration: 1000
            },
            height: 500,
            width: 1000,
            modal: true
        });

    });
	
var i = 0;

function seconds_elapse(){
	$("#show_content").html(
	"<br><center><Deep_maroon>" + 
	"Time: </Deep_maroon><font size='6' color='blue' face='verdana'><b> &nbsp&nbsp" + i + 
	"&nbsp&nbsp	</font></b>   <Deep_maroon>Seconds.");
		
	i = i + 1;
	if (i > 500){
		$("#show_content").html("Error, please try to reload, or report the problem.");
		excution_window.close();
	}
	seconds_100 = setTimeout("display_time()",1000);
}

function display_time() {
	seconds_elapse()
}