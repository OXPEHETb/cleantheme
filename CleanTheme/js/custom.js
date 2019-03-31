$(document).ready(function(){
//Слайдер
  $('.TheSlider').bxSlider({
    auto: true,
    controls: true,
    pager: true,
    speed: 1500,
    pause: 3000,
    mode: 'fade',
  });

  $(window).resize(function(){ 
  /*При изменении размера экрана*/
  });


//Плавный скролл до элемента
    $("a.scrollto").click(function () {
        var elementClick = $(this).attr("href")
        var destination = $(elementClick).offset().top;
        jQuery("html:not(:animated),body:not(:animated)").animate({scrollTop: destination}, 800);
        return false;
    });



//Открываем форму
  $('.OpenForm').click(function(){
  	$('.blackkkk').fadeIn('250');
  	$('.Form').fadeIn('250');
  });


  //При клике на темный фон и close все закрываем
  $('.black, .close').click(function() {
  	$('.black').fadeOut('750');
  	$('.Form').fadeOut('750');
  });


});

