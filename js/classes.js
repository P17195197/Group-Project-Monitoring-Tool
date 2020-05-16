let allClasses = [];

$(document).ready(function(){
    getClasses();

});


function getClasses(){
    let input = {
        function_name: 'get_classes'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            allClasses = data;
            renderClasses(allClasses);
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

function renderClasses(allClasses){
    let classesTable = $('#classes-table').DataTable();
    classesTable.clear().destroy();
    classesTable = $('#classes-table').DataTable( {
        "data": allClasses,
        "columns": [
            { "data": "className" },
            { "data": "id", "render": function ( data, type, row ) {
                    let studentsHtml = "<input type='button' class='btn btn-info show-students' value='Show Students'>";
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

    classesTable.on('click', 'tr .show-students', function () {
        let data = $('#classes-table').DataTable().row(  $(this).closest('tr') ).data();
        getStudents(data['id']);
        $('#class-name').html(data['className']);
        $('#student-div').addClass("hidden").removeClass("hidden");
    });

    classesTable.on('click', 'tr .enrol-in-class', function () {
        let data = classesTable.row(  $(this).closest('tr') ).data();
        enrolInClass($('#user-id').val(), data['id']);
    });
};

function renderStudents(students){
    let studentsTable = $('#students-table').DataTable();
    studentsTable.clear().destroy();
    studentsTable = $('#students-table').DataTable( {
        "data": students,
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
            getClasses();
            getStudents(classId);
        }
    });
}
