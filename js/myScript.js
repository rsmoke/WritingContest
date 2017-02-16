$( document ).ready(function(){

  var host = window.location.hostname;
  if (host === "csgrsmoke.lsait.lsa.umich.edu"){
    $('body').prepend("<div class='bg-danger text-center'>THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT </div>");
  }

  $('.flashNotify').fadeOut(6000);

	$.get( "individualSubmission.php", function( data ) {
	  $( "#currentEntry" ).html( data );
	});

  $.get( "non_active_submissions.php", function( data ) {
    $( "#non_active_Entry" ).html( data );
  });

	$.get( "contestList.php", function( data ) {
	  $( "#availableEntry" ).html( data );
	});

  $("#currentEntry").on('click','.applicantdeletebtn', function(e){
    $.post( 'applicantRemEntry.php',{sbmid:$(this).data('entryid')} );
    $.get( "individualSubmission.php", function( data ) {
      $( "#currentEntry" ).html( data );
    });
  });

	$("#currentEntry").on('click','.covshtbtn', function(e){
		var entryid = $(this).data('entryid');
		window.location = 'coversheet.php?sbmid=' + entryid;
	});

	$("#sameAddress").click( function(e){
		e.preventDefault();
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

	$('#availableEntry').on('click', '.applyBtn', function ( event ){
		//var useAppTemplate = $(this).data('app-template'); // application template to use
		var useAppTemplate = 'applicationForm';
		var useContest = $(this).data('contest-num');
		window.location = useAppTemplate + '.php?id=' + useContest;
	});

  $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });

  $('#applicantPenName').blur(function() {
    if ($('#applicantPenName').val() == $('#applicantFname').val() + ' ' + $('#applicantLname').val()){
      alert( "NOTE: Do not use your real name as a pen-name!" );
      $('#applyBasicInfo').prop('disabled', true);
    } else {
      $('#applyBasicInfo').prop('disabled', false);
    };
  });

});
