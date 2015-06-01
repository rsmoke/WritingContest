$( document ).ready(function(){

	$.get( "individualSubmission.php", function( data ) {
	  $( "#currentEntry" ).html( data );
	});

	$.get( "contestList.php", function( data ) {
	  $( "#availableEntry" ).html( data );
	});

	$("#currentEntry").on('click','.covshtbtn', function(e){
		var entryid = $(this).data('entryid');
		window.location = 'coversheet.php?sbmid=' + entryid;
	});

	$("#sameAddress").click( function(){
		var streetL = $( "input[name ='streetL']" ).val();
		var cityL = $( "input[name ='cityL']" ).val();
		var stateL = $( "select[name ='stateL']" ).val();
		var zipL = $( "input[name ='zipL']" ).val();
		var usrtelL =  $( "input[name ='usrtelL']" ).val();

		$( "input[name ='streetH']" ).val( streetL );
		$( "input[name ='cityH']" ).val( cityL );
		$( "select[name ='stateH']" ).val( stateL );
		$( "input[name ='zipH']" ).val( zipL );
		$( "input[name ='usrtelH']" ).val( usrtelL );
	});

	$('#utility').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget); // Button that triggered the modal
	  var pickRule = button.data('shortname'); // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this);
	  // modal.find('.modal-title').text('Eligibility Rules:');
	  modal.find('.modal-body').load( 'eligibiltyRules.html #' + pickRule, function(response, status, xhr) {
                if (status == 'error') {
                    //console.log('got here');
                    $('#utility_body').html('<h2>Oh boy</h2><p>Sorry, but there was an error:' + xhr.status + ' ' + xhr.statusText+ '</p>');
                }
            }
        );
	});

	$('#availableEntry').on('click', '.applyBtn', function ( event ){
		//var useAppTemplate = $(this).data('app-template'); // application template to use
		var useAppTemplate = 'applicationForm';
		var useContest = $(this).data('contest-num');
		window.location = useAppTemplate + '.php?id=' + useContest;
	});

});