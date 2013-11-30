$(function(){
    var owl_main      = $("#main-slide");
    var owl_blog      = $("#blog-slide");
    var owl_testi     = $("#testi-slide");
    var owl_best      = $("#best-sell-slide");
    var owl_featured  = $("#featured-slide");
    var owl_brand     = $("#brand-slide");

    var time = 7; // time in seconds
    var $progressBar,
        $bar,
        $elem,
        isPause,
        tick,
        percentTime;

    //Init the main carousel
    owl_main.owlCarousel({
        slideSpeed      : 800,
        pagination      : false,
        singleItem      : true,
        lazyLoad        : true,
        transitionStyle : "fadeUp",
        afterInit       : progressBar,
        afterMove       : moved,
        startDragging   : pauseOnDragging
    });

    //Init progressBar where elem is $("#owl-demo")
    function progressBar(elem){
      $elem = elem;
      //build progress bar elements
      buildProgressBar();
      //start counting
      start();
    }

    //create div#progressBar and div#bar then prepend to $("#owl-demo")
    function buildProgressBar(){
      $progressBar = $("<div>",{
        id:"progress-bar"
      });
      $bar = $("<div>",{
        id:"bar"
      });
      $progressBar.append($bar).prependTo($elem);
    }

    function start() {
      //reset timer
      percentTime = 0;
      isPause = false;
      //run interval every 0.01 second
      tick = setInterval(interval, 10);
    }

    function interval() {
      if(isPause === false){
        percentTime += 1 / time;
        $bar.css({
           width: percentTime+"%"
         });
        //if percentTime is equal or greater than 100
        if(percentTime >= 100){
          //slide to next item
          $elem.trigger('owl.next');
        }
      }
    }

    //pause while dragging
    function pauseOnDragging(){
      isPause = true;
    }

    //moved callback
    function moved(){
      //clear interval
      clearTimeout(tick);
      //start again
      start();
    }

    //uncomment this to make pause on mouseover
    // $elem.on('mouseover',function(){
    //   isPause = true;
    // })
    // $elem.on('mouseout',function(){
    //   isPause = false;
    // })

    //Init the blog carousel
    owl_blog.owlCarousel({
        slideSpeed      : 800,
        pagination      : false,
        lazyLoad        : true,
        singleItem      : true
    });
    $("#blog-nav-right").click(function(){
        owl_blog.trigger('owl.next');
    });
    $("#blog-nav-left").click(function(){
        owl_blog.trigger('owl.prev');
    });

    //Init the testimonial carousel
    owl_testi.owlCarousel({
        slideSpeed      : 800,
        pagination      : false,
        lazyLoad        : true,
        singleItem      : true
    });
    $("#testi-nav-right").click(function(){
        owl_testi.trigger('owl.next');
    });
    $("#testi-nav-left").click(function(){
        owl_testi.trigger('owl.prev');
    });

    //Init the best seller carousel
    owl_best.owlCarousel({
        singleItem      : true,
        lazyLoad        : true,
        slideSpeed      : 800,
        pagination      : false,
        itemsScaleUp    : true
    });
    $("#best-nav-right").click(function(){
        owl_best.trigger('owl.next');
    });
    $("#best-nav-left").click(function(){
        owl_best.trigger('owl.prev');
    });

    //Init the featured item carousel
    owl_featured.owlCarousel({
        items               : 5,
        itemsDesktop        : [1000,5],
        itemsDesktopSmall   : [900,4],
        itemsTablet         : [600,3],
        itemsMobile         : [479,2],
        lazyLoad            : true,
        slideSpeed          : 800,
        pagination          : false,
        itemsScaleUp        : true
    });

    $("#featured-nav-right").click(function(){
        owl_featured.trigger('owl.next');
    });
    $("#featured-nav-left").click(function(){
        owl_featured.trigger('owl.prev');
    });

    //Init the brand carousel
    owl_brand.owlCarousel({
        items               : 5,
        itemsDesktop        : [1000,5],
        itemsDesktopSmall   : [900,4],
        itemsTablet         : [600,3],
        itemsMobile         : [479,2],
        lazyLoad            : true,
        slideSpeed          : 800,
        pagination          : false,
        itemsScaleUp        : true
    });

    $("#brand-nav-right").click(function(){
        owl_brand.trigger('owl.next');
    });
    $("#brand-nav-left").click(function(){
        owl_brand.trigger('owl.prev');
    });

});