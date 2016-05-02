$('.search.selection.dropdown')
                   .dropdown({
                       useLabels: false
                   });
$('.one-block').width($('.container').width());

$(window).resize(function () { $('.one-block').width($('.container').width()); });
$('.second-block, .third-block, .fourth-block').css('margin-left', '200%');
//  $('.fourth-block a').removeAttr('href');

$('.class_link').click(function (e) {
   
    e.preventDefault();
 //   var block = $(this).parents('.one-block');
 //   $(block).animate({ 'margin-left': '-100%' }, 1000);

 //   $(block).toggleClass('active_el');
 //   $(block).next().toggleClass('active_el').animate({ 'margin-left': '0' }, 500);
 //MoveTo($(this));

});
$('.back_arrow').click(function () {
   
    if ($('.active_el').hasClass('first-block')) {
        return;
    }
    $('.active_el').animate({ 'margin-left': '200%' }, 1000);
    var prev = $('.active_el').prev();
    $(prev).animate({ 'margin-left': '0' }, 500);
    $('.active_el').toggleClass('active_el');
    $(prev).toggleClass('active_el');
    MoveTo($(this));

});
function MoveTo (th) {
    var el = $(th[0]).attr('moveto');
    $('body').animate({
        scrollTop: $(el).offset().top
    }, 2000);
    return false;
}
