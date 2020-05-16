
function showSuccessAlert(){
    $("#message-status-failure").removeClass("visible").addClass("invisible");
    $("#message-status-success").addClass("visible").removeClass("invisible");
    setTimeout(function () {
        window.location.reload();
    }, 3000);

}

function showFailureAlert(){
    $("#message-status-success").removeClass("visible").addClass("invisible");
    $("#message-status-failure").addClass("visible").removeClass("invisible");

}

function dateFormatter(strDate) {
    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let current_datetime = new Date(strDate)
    let formatted_date = current_datetime.getDate() + "-" + months[current_datetime.getMonth()] + ' | ' + current_datetime.toLocaleTimeString();
    return formatted_date;
}


function showMessage(data){
    if(data){
        $('#message-status-success').addClass("hidden").removeClass("hidden");
        setTimeout(function () {
            $('#message-status-success').removeClass("hidden").addClass("hidden");
        }, 3000);
    }else{
        $('#message-status-failure').addClass("hidden").removeClass("hidden");
        setTimeout(function () {
            $('#message-status-failure').removeClass("hidden").addClass("hidden");
        }, 3000);
    }
}
