$( document ).ready(function(){
  $('#contest').show();
  $('#output').hide();
  $('#initialView').hide();

  $('#jdgContestBtn').click( function(){
    $('#contest').toggle();
    $('#output').hide();
    $('#initialView').hide();
  });

  $('#contest').on('click', '.btn-eval', function (e){
  //$("#currentEntry").on('click','.covshtbtn', function(e){
    var entryid = $(this).data('entryid');
    //window.location = 'coversheet.php?sbmid=' + entryid;
    document.location = 'judging/evaluation.php?sbmid=' + entryid;
  });

});