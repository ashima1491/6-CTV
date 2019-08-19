$(document).ready(function() {

    $('#Search-Data-and-Model').click(function() {
		// alert("Start Search Now");
        $('#result').hide();
        $('#select_check').hide();
		$('#spinner').show();
		//alert ($('#search').text());
		seconds_elapse();
		$.post("Search_R_php.php", {
			compoundName: $('#commonName').text(),
            commonName: $('#commonName').text(),
            submitValue: $('#submission').text(),
            MolWeight: $('#Molecularweight').text(),
            searchType: $('#search').text(),
					
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
				$('#spinner').hide(),
                $('#result').show();
                $('#reset_check').css("display", "block");
                // $('#resultss').replaceWith(newdata);
				// $('#just_a_test').replaceWith(newdata);
				$('#step3').replaceWith(newdata);
				}
            );		// end of post

        });			// end of $('#Search-Data-and-Model').click(function() {}
		

    });				// end of $(document).ready(function() {})
	