
function showSuccessAlert(){
    $("#message-status-failure").removeClass("visible").addClass("invisible");
    $("#message-status-success").addClass("visible").removeClass("invisible");

}

function showFailureAlert(){
    $("#message-status-success").removeClass("visible").addClass("invisible");
    $("#message-status-failure").addClass("visible").removeClass("invisible");

}
