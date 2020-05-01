$('#receiverrole').on('change', function() {
    onReceiverRoleSelect();
});

$('#send-message').on('click', function() {
    onSendMessage();
});

function onReceiverRoleSelect(){
    var roleId = $("#receiverrole").find(":selected").val();

    var input = {
            function_name: 'get_users',
            user_role_id: parseFloat(roleId)
        };

    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            console.log(data);
            $("#receivinguser").empty();
            var listitems = '';
            $.each(data, function(key, value){
                listitems += '<option value="' + value.id + '">' + value.username + '</option>';
            });
            $("#receivinguser").append(listitems);
        }

    });
}

function onSendMessage() {
    var receiverId = $("#receivinguser").find(":selected").val();
    var subject = $("#messagesubject").val();
    var content = $("#form_message").val();

    var input = {
        function_name: 'send_message',
        receiverid: parseFloat(receiverId),
        subject: subject,
        content: content
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            if(data === true){
                showSuccessAlert();
                $('#messagehistory').DataTable().destroy();
                getMessages();
            }else{
                showFailureAlert();
            }
        }

    });
}

function showSuccessAlert(){
    $("#message-status-failure").removeClass("visible").addClass("invisible");
    $("#message-status-success").addClass("visible").removeClass("invisible");

}

function showFailureAlert(){
    $("#message-status-success").removeClass("visible").addClass("invisible");
    $("#message-status-failure").addClass("visible").removeClass("invisible");

}

function getMessages() {
    var input = {
        function_name: 'get_messages'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            $('#messagehistory').DataTable( {
                "data": data,
                "columns": [
                    { "data": "receiver" },
                    { "data": "sentTime" },
                    { "data": "subject" },
                    { "data": "content" }
                ]
            } );
        }

    });
}

$(document).ready(function () {
    getMessages();
});