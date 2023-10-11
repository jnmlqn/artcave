$(document).ready(function(){
    $(".my-link").click(function(e){
      var url = window.location.href;
      var p;
      if (url.indexOf("?") >= 0) { p = '&page='; } else{ p = '?page='; }
      window.location.href = url + p + $(this).attr("value");
    });
});    