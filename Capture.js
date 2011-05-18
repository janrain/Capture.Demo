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

$(document).ready(function() {
  $('select#app_addrs').change(function() {
    var app_name = $('option:selected', this).attr('value');
    del_cookie('app');
    var new_url = location.origin + location.pathname + "?app=" + app_name;
    location = new_url;
  });
});

function del_cookie(name) {
document.cookie = name +
'=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
}