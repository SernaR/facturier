$(document).ready(function(){
  $('.js-toggle').on('click',function(){
   $('.modal').toggle();
   $('.modal-body').empty();
   $('.modal-body').append($(this).attr('id'));
 });
}); 
