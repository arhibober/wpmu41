jQuery(document).ready(function($) {

  $('.login_box #login').on('submit', function(e){
    $('.login_box .status_login').show().text(ajax_login_object.loadingmessage);
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: ajax_login_object.ajaxurl,
      data: { 
        'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
        'username': $('.login_box #username').val(), 
        'password': $('.login_box #password').val(), 
        'security': $('.login_box #security').val()
      },
      success: function(data){
        $('.login_box .status_login').text(data.message);
        if (data.loggedin == true){
          document.location.href = ajax_login_object.redirecturl;
        }
      }
    });
    e.preventDefault();
	setTimeout(function(){location.replace("http://localhost/wpmu31");}, 2000);
  });

});
