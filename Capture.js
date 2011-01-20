CAPTURE = {

  resize: function(jargs) {
    var args = JSON.parse(jargs);

    jQuery("#fancybox-inner").css({'width': args.w + 'px', 'height': args.h + 'px'});
    jQuery("#fancybox-wrap").css({'width': args.w + 'px', 'height': args.h + 'px'});
    jQuery("#fancybox-content").css({ "height": args.h + 'px', "width": args.w + 'px'});
    jQuery("#fancybox-frame").css({'width': args.w + 'px', 'height': args.h + 'px'});

    jQuery.fancybox.resize();
    jQuery.fancybox.center();
  }
};

