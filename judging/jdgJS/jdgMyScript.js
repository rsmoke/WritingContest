$( document ).ready(function(){

  $('#contest').on('click', '.btn-eval', function (e){
    var entryid = $(this).data('entryid');
    document.location = 'http://writingcontest.dev/judging/evaluation.php?evid=' + entryid;
  });

  //disable button after an evaluation has occurred
  //disabled="disabled"

});