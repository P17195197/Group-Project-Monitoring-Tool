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
                "visible": $('#user-role').val() !== 'Student' ? false: true,
                "render": function ( data, type, row ) {
                    let enrolmentHtml = "<input type='button' class='btn btn-info enrol-in-class' value='Enrol'>";
                    return enrolmentHtml;
                }
            }
        ]
    } );

    classesTable.on('click', 'tr', function () {
        let data = classesTable.row( this ).data();
        getStudents(data['id']);
        $('#class-name').html(data['className']);
        $('#student-div').addClass("hidden").removeClass("hidden");
        // $('#problem-statement-dialog').html(data['statement']);
        // getChoices(data['id']);
        // $("#dialog").modal({
        //     fadeDuration: 500,
        //     fadeDelay: 0.25
        // });
    } );
};

function renderStudents(students){
    console.log('Students', students);
    let studentsTable = $('#students-table').DataTable();
    studentsTable.clear().destroy();
    studentsTable = $('#students-table').DataTable( {
        "data": students,
        "columns": [
            { "data": "userName" }
        ]
    } );
}
