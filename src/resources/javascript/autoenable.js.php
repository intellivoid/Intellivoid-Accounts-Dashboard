$("#submit_button").prop("disabled", true);
setTimeout(function(){
    $("#linear-spinner").removeClass("indeterminate");
    $("#linear-spinner").addClass("indeterminate-none");
    $("#submit_button").prop("disabled", false);
    $("#submit_preloader").prop("hidden", true);
    $("#submit_label").prop("hidden", false);
    }, <?PHP print(mt_rand(3000, 6000)); ?>
);

function authenticate(){
    $("#linear-spinner").removeClass("indeterminate-none");
    $("#linear-spinner").addClass("indeterminate");
    $("#submit_button").prop("disabled", true);
    $("#submit_preloader").prop("hidden", false);
    $("#submit_label").prop("hidden", true);
    $("#authentication_form").submit();
}