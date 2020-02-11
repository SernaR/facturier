$(document).ready(function(){
  $('.js-toggle').on('click',function(){
    $('.modal').toggle();
    $('#js-delete').attr({href:$(this).attr('id')});
  });

  $('#js-message').click(function(){
    $('.js-message').slideUp();
  });
});
