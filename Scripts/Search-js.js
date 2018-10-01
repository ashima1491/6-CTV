$(document).ready(
    function() {

        $('#Search-Data-and-Model').click(function() {
            $('#result').hide();
            $('#select_check').hide();
            // alert("Start Search Now");
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
            // $.post("Search-php-v2.php", {
			$.post("Search-php.php", {
                    compoundName: $('#compoundNamer').text(),
                    submitValue: $('#submission').text(),
                    MolWeight: $('#Molecularweight').text(),
					
					
                    refDose: $('#Ref_dose').is(":checked"),
					noel: $('#NOEL').is(":checked"),
                    refConc: $('#Ref_conc').is(":checked"),
					
					onbd: $('#ONBD').is(":checked"),
                    onbdl: $('#ONBDL').is(":checked"),
					
                    oralSlope: $('#Oral_slope').is(":checked"),
                    ihalUnit: $('#Ihal_unit').is(":checked"),
                    cancPot: $('#Canc_pot').is(":checked"),
                    
					
                    smilee: $('#smiles').text(),
                    CompoundImage: $('#compoundImage').text()

                },		// end of submitting data.
				
                function(newdata) {						// When search results received.
					// alert("Search Results Received. " + newdata);
					// var w = window.open();
					// $(w.document.body).replaceWith(newdata);
					
                    $('#spinner').hide(),
                    $('#result').show();
                    $('#reset_check').css("display", "block");
                    // $('#resultss').replaceWith(newdata);
					// $('#just_a_test').replaceWith(newdata);
					$('#step3').replaceWith(newdata);
					
					
					// alert("hello 2345");
					// $('#just_a_test').dialog();
					// $('#just_a_test').dialog("open");
					// alert("hello");
					// alert($(window).width()*0.8);
                    // $('#results').dialog("open");
					// $('#results').dialog({height: auto});

					// $('#results').dialog({width: 400});
					// $('#results').dialog( "option", "width", 300 );
					// alert("hello");
					// alert($(window).width()*0.8);
					
					
  
    				// $(w.document.body).replaceWith(newdata);
				}
            );

        });			// end of $('#Search-Data-and-Model').click(function() {}

    });				// end of $(document).ready(function() {})
	