let allGroups = [];

$(document).ready(function(){
    getGroups();

});


function getGroups(){
    let input = {
        function_name: 'get_groups'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            allGroups = data;
            renderGroups(allGroups);
        }
    });
};

function getStudents(classId){
    let input = {
        function_name: 'get_students',
        classId: classId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            renderStudents(data);
        }
    });
}

function renderGroups(allGroups){
    let groupsTable = $('#classes-table').DataTable();
    groupsTable.clear().destroy();
    groupsTable = $('#classes-table').DataTable( {
        "data": allGroups,
        "lengthChange": false,
        "columns": [
            { "data": "groupName" },
            { "data": "id", "render": function ( data, type, row ) {
                    let studentsHtml = "<input type='button' class='btn btn-info show-students' value='Show Members'>";
                    return studentsHtml;
                }
            },
            { "data": "id",
                "visible": $('#user-role').val() === 'System Admin' || $('#user-role').val() === 'Guest' ? false : true,
                "render": function ( data, type, row ) {
                    let enrolmentHtml = "<input type='button' class='btn btn-info enrol-in-class' value='Join'>";
                    return row['enrolmentStatus'] === '1' ? 'Joined' : enrolmentHtml;
                }
            }
        ]
    } );

    groupsTable.on('click', 'tr .show-students', function () {
        let data = $('#classes-table').DataTable().row(  $(this).closest('tr') ).data();
        getStudents(data['id']);
        $('#class-name').html(data['groupName']);
        $('#student-div').addClass("hidden").removeClass("hidden");
    });

    groupsTable.on('click', 'tr .enrol-in-class', function () {
        let data = groupsTable.row(  $(this).closest('tr') ).data();
        enrolInClass($('#user-id').val(), data['id']);
    });
};

function renderStudents(students){
    let studentsTable = $('#students-table').DataTable();
    studentsTable.clear().destroy();
    studentsTable = $('#students-table').DataTable( {
        "data": students,
        "lengthChange": false,
        "columns": [
            { "data": "userName" }
        ]
    } );
}
function enrolInClass(studentId, classId){
    let input = {
        function_name: 'enrol_in_class',
        classId: classId,
        studentId: studentId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            showMessage(data);
            getGroups();
            getStudents(classId);
        }
    });
}
