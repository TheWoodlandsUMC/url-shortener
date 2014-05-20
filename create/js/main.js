$(document).ready(function(){
    $("input[name='submit']").attr("disabled", "true");
    $("input[name='url']").blur(function(){
        if ($(this).val() != "") {
            $("input[name='submit']").removeAttr("disabled");
        } else {
            $("input[name='submit']").attr("disabled", "true");        
        }
    });    
});
