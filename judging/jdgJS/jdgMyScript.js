$( document ).ready(function(){
  $('#contest').hide();
  $('#output').hide();

  $('#jdgContestBtn').click( function(){
    $('#contest').toggle();
    $('#output').hide();
    $('#initialView').hide();
  });

});