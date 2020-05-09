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

function getContacts() {
    var input = {
        function_name: 'get_contacted_users'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            $('#contact-users').DataTable( {
                "data": data,
                "columns": [
                    { "data": "contactName" },
                    { "data": "id", visible: false },
                    { "data": "onlineStatus",
                        "render": function ( data, type, row ) {
                            return data === "1" ? 'Online': 'Offline';
                        },
                    }
                ]
            } );
            $('#contact-users').on('click', 'tbody tr', function () {
                var table = $('#contact-users').DataTable();
                var row = table.row($(this)).data();   //full row of array data
                $("#selected-user").val(row["username"]);
                $("#selected-user-id").val(row["id"]);
                getMessages(row["id"])
            });
        }

    });
}

function getMessages(userId) {
    var input = {
        function_name: 'get_messages',
        user_id: userId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            console.log(data);
            $("#chat-window").html('');
            renderMessages(data);
        }

    });
}

function dateFormatter(strDate) {
    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let current_datetime = new Date(strDate)
    let formatted_date = current_datetime.getDate() + "-" + months[current_datetime.getMonth()] + '|' + current_datetime.toLocaleTimeString();
    return formatted_date;
}

function renderMessages(messages){
    var chatWindowHtml = '';
    var currentUser = $('#current-user').val();
    messages.forEach(message => {
        if (message["sender"] === currentUser){
            //load outgoing message
            var outgoingTemplate = $('#outgoing-message-template').html();
            outgoingTemplate = outgoingTemplate.replace(/{message_id}/g, message['id']);
            outgoingTemplate = outgoingTemplate.replace(/{username}/g, message['sender']);
            outgoingTemplate = outgoingTemplate.replace(/{message-text}/g, message['content']);
            outgoingTemplate = outgoingTemplate.replace(/{message-time}/g, dateFormatter(message['sentTime']));

            chatWindowHtml += outgoingTemplate;
        }else{
            //load incoming message
            var incomingTemplate = $('#incoming-message-template').html();
            incomingTemplate = incomingTemplate.replace(/{message_id}/g, message['id']);
            incomingTemplate = incomingTemplate.replace(/{username}/g, message['sender']);
            incomingTemplate = incomingTemplate.replace(/{message-text}/g, message['content']);
            incomingTemplate = incomingTemplate.replace(/{message-time}/g, dateFormatter(message['sentTime']));

            chatWindowHtml += incomingTemplate;
        }
    });
    $('#chat-window').html(chatWindowHtml);
    // var myDiv = $('.chat-window');
    $('.chat-window').scrollTop($('.chat-window')[0].scrollHeight - $('.chat-window')[0].clientHeight);
}

function sendChatMessage(){
    var content = $('#chat-message-input').val();
    var senderId = $('#current-user-id').val();
    var receiverId = $('#selected-user-id').val();

    var input = {
        function_name: 'send_message',
        receiverid: parseFloat(receiverId),
        subject: '',
        content: content
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            console.log(data);
            //clear input
            $('#chat-message-input').val('');
            //refresh messages
        }

    });
}

function refreshMessages(){
    setTimeout(function () {
        console.log('Refreshing messages');
        getMessages($('#selected-user-id').val());
        // refreshMessages();
    }, 3000);
}

$(document).ready(function () {
    getContacts();

    $('#chat-send-message').on('click', function () {
        console.log('Send message to', $('#selected-user').val());
        sendChatMessage();
    });

    refreshMessages();
});