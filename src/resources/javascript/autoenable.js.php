setTimeout(function(){
    document.getElementById("submit_button").disabled = false;
    }, <?PHP print(mt_rand(3000, 6000)); ?>
);