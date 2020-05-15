$('#receiverrole').on('change', function() {
    onReceiverRoleSelect();
});

$('#send-message').on('click', function() {
    onSendMessage();
});

function onReceiverRoleSelect(){
    let roleId = $("#receiverrole").find(":selected").val();

    let input = {
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
            let listitems = '';
            $.each(data, function(key, value){
                listitems += '<option value="' + value.id + '">' + value.username + '</option>';
            });
            $("#receivinguser").append(listitems);
        }

    });
}

function onSendMessage() {
    let receiverId = $("#receivinguser").find(":selected").val();
    let subject = $("#messagesubject").val();
    let content = $("#form_message").val();

    let input = {
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
                // $('#messagehistory').DataTable().destroy();
                // getMessages();
            }else{
                showFailureAlert();
            }
        }

    });
}

function getContacts() {
    let input = {
        function_name: 'get_contacted_users'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            renderContacts(data);
        }

    });
}

function renderContacts(contacts){
    let contactListHtml = '';
    $('#contact-list').html('');
    let currentUser = $('#current-user').val();
    console.log('Contacts are', contacts);
    contacts.forEach(contact => {
        let contactTemplate = $('#chat-contact-template').html();
        contactTemplate = contactTemplate.replace(/{user-id}/g, contact['id']);
        contactTemplate = contactTemplate.replace(/{contact-username}/g, contact['contactName']);
        contactTemplate = contactTemplate.replace(/{contact-name}/g, contact['contactName']);
        contactTemplate = contactTemplate.replace(/{last-message-time}/g, dateFormatter(contact['sentTime']));
        contactTemplate = contactTemplate.replace(/{last-message}/g,contact['content']);
        contactListHtml += contactTemplate;
    });
    $('#contact-list').html(contactListHtml);
    $('.chat-contact-item').on('click', function() {
        let contactId = this.id.replace("contact-",'');
        $('#selected-user-id').val(contactId);
        highlightSelectedUser(contactId);
        getMessages(contactId);
    });

    //default load. select latest user
    $('#selected-user-id').val(contacts[0]["id"]);
    highlightSelectedUser(contacts[0]["id"]);
    getMessages(contacts[0]["id"]);
}

function highlightSelectedUser(userId){
    $('.chat-contact-item').removeClass('selected-contact');
    $('#contact-'+userId).addClass('selected-contact');
}

function getMessages(userId) {
    let input = {
        function_name: 'get_messages',
        user_id: userId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            renderMessages(data);
        }

    });
}

function dateFormatter(strDate) {
    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let current_datetime = new Date(strDate)
    let formatted_date = current_datetime.getDate() + "-" + months[current_datetime.getMonth()] + ' | ' + current_datetime.toLocaleTimeString();
    return formatted_date;
}

function renderMessages(messages){
    let chatWindowHtml = '';
    let currentUser = $('#current-user').val();
    messages.forEach(message => {
        if (message["sender"] === currentUser){
            //load outgoing message
            let outgoingTemplate = $('#outgoing-message-template').html();
            outgoingTemplate = outgoingTemplate.replace(/{message_id}/g, message['id']);
            outgoingTemplate = outgoingTemplate.replace(/{username}/g, message['sender']);
            outgoingTemplate = outgoingTemplate.replace(/{message-text}/g, message['content']);
            outgoingTemplate = outgoingTemplate.replace(/{message-time}/g, dateFormatter(message['sentTime']));

            chatWindowHtml += outgoingTemplate;
        }else{
            //load incoming message
            let incomingTemplate = $('#incoming-message-template').html();
            incomingTemplate = incomingTemplate.replace(/{message_id}/g, message['id']);
            incomingTemplate = incomingTemplate.replace(/{username}/g, message['sender']);
            incomingTemplate = incomingTemplate.replace(/{message-text}/g, message['content']);
            incomingTemplate = incomingTemplate.replace(/{message-time}/g, dateFormatter(message['sentTime']));

            chatWindowHtml += incomingTemplate;
        }
    });
    $('#chat-window').html(chatWindowHtml);
    // let myDiv = $('.chat-window');
    $('.chat-window').scrollTop($('.chat-window')[0].scrollHeight - $('.chat-window')[0].clientHeight);
}

function sendChatMessage(){
    let content = $('#chat-message-input').val();
    let senderId = $('#current-user-id').val();
    let receiverId = $('#selected-user-id').val();

    let input = {
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
        getMessages($('#selected-user-id').val());
        refreshMessages();
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