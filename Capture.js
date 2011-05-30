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
    delCookie('app');
    setCookie('app', app_name, 1);
    $('#app_name').text(app_name);
    var new_url = location.protocol + '//' + location.hostname + location.pathname + "?app=" + app_name;
    location = new_url;
  });
});

function delCookie(name) {
document.cookie = name +
'=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
}

function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}