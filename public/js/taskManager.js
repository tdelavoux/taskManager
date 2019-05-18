$(function(){
    $('#pass').keyup(function(e) {
         var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
         var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
         var enoughRegex = new RegExp("(?=.{6,}).*", "g");
         if (false == enoughRegex.test($(this).val())) {
                 $('#passstrength').html('More Characters');
         } else if (strongRegex.test($(this).val())) {
                 $('#passstrength').removeClass( "yellow red" ).addClass( "green" );
                 $('#passstrength').html('Strong');
         } else if (mediumRegex.test($(this).val())) {
                 $('#passstrength').removeClass( "green red" ).addClass( "yellow" );
                 $('#passstrength').html('Medium');
         } else {
                 $('#passstrength').removeClass( "yellow green" ).addClass( "red" );
                 $('#passstrength').html('Weak');
         }
         return true;
    });

    $(".reveal").on('click',function() {
        var $pwd = $(".pwd" + $(this).attr('data-int'));
        if ($pwd.attr('type') === 'password') {
            $(this).children().removeClass('fa-eye').addClass('fa-eye-slash');
            $pwd.attr('type', 'text');
        } else {
            $(this).children().removeClass('fa-eye-slash').addClass('fa-eye');
            $pwd.attr('type', 'password');
        }
    });

});

