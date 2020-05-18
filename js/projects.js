let projectLength = 0;
let allGroups = [];

$(document).ready(function(){
    getGroups();
    getProjects();
    $('#add-question').on('click', function(){
        projectLength++;
        let questionTemplate = $('#test-question-template').html();
        $('#test-questions').append(questionTemplate.replace(/{test-id}/g, projectLength));
        $('#add-topic-' + projectLength).on('click', function () {
            let closestDiv = $('#choices-' + this.id.replace('add-topic-', ''));
            let choiceTemplate = $('#choice-template').html();
            closestDiv.append(choiceTemplate);
        });
        $('#test-class-' + projectLength).html(mapGroupsToOptions());
        $( "#test-date-" + projectLength ).datepicker();
        $( "#test-date-" + projectLength ).datepicker('setDate', new Date());
    });

    $('#submit-form').on('click', function () {
        submitForm();
    })

});

function mapGroupsToOptions(){
    let optionsHtml = '';
    allGroups.forEach(c => {
        optionsHtml += `<option value="${c.id}">${c.groupName}</option>`;
    });
    return optionsHtml;
}
function submitForm(){
    let projectObjects = [];
    for(let i=1; i<=projectLength; i++){
        let projectObj = {};
        projectObj.groupId = $('#test-class-' + i).val();
        projectObj.projectName = $('#test-add-test-' + i).val();
        projectObj.projectDate = $('#test-date-' + i).val();
        projectObj.projectDuration = $('#test-duration-' + i).val();
        let milestones = [];
        $('#choices-' + i + ' .answer-choice').map(function() {
            milestones.push(this.value);
        });
        projectObj.milestones = milestones.toString();
        projectObjects.push(projectObj);
    };
    addProjects(projectObjects);
}

function addProjects(projects){
    let input = {
        function_name: 'add_projects',
        projects: JSON.stringify(projects)
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: input,
        async: false,
        success: function(data) {
            // allGroups = data;
            showMessage(data);
            setTimeout(function(){
                window.location.reload();
            }, 1000);


        }

    });
}


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
        }

    });
};

function getProjects(){
    let input = {
        function_name: 'get_projects'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            renderProjects(data);
        }

    });
}

function renderProjects(projects){
    let projectsTable = $('#tests-table').DataTable();
    projectsTable.clear().destroy();
    projectsTable = $('#tests-table').DataTable( {
        responsive: true,
        "data": projects,
        "columns": [
            { "data": "projectName" },
            { "data": "groupName" },
            { "data": "projectDate", "render": function ( data, type, row ) {
                    return dateFormatter(row["projectDate"]);
                } },
            { "data": "duration", "render": function ( data, type, row ) {
                    return row["duration"] + ' minutes';
                } },
            { "data": "milestones" }
        ]
    } );
}