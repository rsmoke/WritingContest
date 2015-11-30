$( document ).ready(function(){

  $('#contest').on('click', '.btn-eval', function (e){
  //$("#currentEntry").on('click','.covshtbtn', function(e){
    var entryid = $(this).data('entryid');
    //window.location = 'coversheet.php?sbmid=' + entryid;
    document.location = 'judging/evaluation.php?evid=' + entryid;
  });

});