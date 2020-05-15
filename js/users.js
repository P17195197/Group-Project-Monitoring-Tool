$(document).ready(function () {
    getUsers();
});

function getUsers() {
    let input = {
        function_name: 'get_all_users'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            renderUsers(data);
        }
    });
}

function renderUsers(users){
    let usersTable = $('#users-table').DataTable({
        retrieve: true
    });
    usersTable.clear().destroy();
    usersTable = $('#users-table').DataTable( {
        retrieve: true,
        "data": users,
        "columns": [
            { "data": "username" },
            { "data": "firstName" },
            { "data": "lastName" },
            { "data": "roleName" },
            { "data": "onlineStatus", "render": function ( data, type, row ) {
                    return row['onlineStatus'] === "1" ? 'Online' : 'Offline';
                }
            },
            { "data": "isActive", "render": function ( data, type, row ) {
                    let buttonText = row['isActive'] === "1" ? 'Deactivate' : 'Activate';
                    let activeStatusHtml = "<input type='button' class='btn btn-info user-status' value='" + buttonText + "'>";
                    return activeStatusHtml;
                }
            },
            { "data": "id", "visible": false }
        ]
    } );

    usersTable.on('click', 'tr .user-status', function () {
        console.log('closest row', usersTable.row(this).data());
        let data = usersTable.row($(this).closest('tr')).data();
        changeUserStatus(data['id'], data['isActive'] === "1" ? "0" : "1");
    });
}

function changeUserStatus(userId, activeStatus){
    let input = {
        function_name: 'change_user_status',
        userId: userId,
        activeStatus: activeStatus
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            getUsers();
            showMessage(data);

        }
    });
};


function showMessage(data){
    if(data){
        $('#message-status-success').addClass("invisible").removeClass("invisible");
        setTimeout(function () {
            $('#message-status-success').removeClass("invisible").addClass("invisible");
        }, 3000);
    }else{
        $('#message-status-failure').addClass("invisible").removeClass("invisible");
        setTimeout(function () {
            $('#message-status-failure').removeClass("invisible").addClass("invisible");
        }, 3000);
    }
}