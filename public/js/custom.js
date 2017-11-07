//============Height Equal of Two Column JS================//
equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}
//$(window).load(function() {
//  equalheight('.equal-height');
//  equalheight('.equal-height1');
//  equalheight('.equal-height2');
//  equalheight('.equal-height3');
//  equalheight('.equal-height4');
//  equalheight('.equal-height5');
//});
$(window).resize(function(){
  equalheight('.equal-height');
  equalheight('.equal-height1');
  equalheight('.equal-height2');
  equalheight('.equal-height3');
  equalheight('.equal-height4');
  equalheight('.equal-height5');
});

//============Bootstrap Responsive Tab JS================//
$('.responsive-tabs').responsiveTabs({
  accordionOn: ['xs', 'sm']
});