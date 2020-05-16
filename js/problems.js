let projectLength = 0;
let allGroups = [];

$(document).ready(function(){
    getGroups();
    $('#problem-class').html(mapGroupsToOptions());
    addProblem();

    $('#problem-class').on('change', function(){
        getAllProblems(this.value);
    })

    $('#add-question').on('click', function(){
        addProblem();
    });

    $('#submit-form').on('click', function () {
        submitForm();
    });

    getAllProblems($('#problem-class').val());

});

function addProblem(){
    projectLength++;

    let questionTemplate = $('#test-question-template').html();
    $('#test-questions').append(questionTemplate.replace(/{problem-id}/g, projectLength));
    $('#add-topic-' + projectLength).on('click', function () {
        let closestDiv = $('#choices-' + this.id.replace('add-topic-', ''));
        let choiceTemplate = $('#choice-template').html().replace(/{problem-id}/g, projectLength);
        closestDiv.append(choiceTemplate);
    });

}

function mapGroupsToOptions(){
    let optionsHtml = '';
    allGroups.forEach(c => {
        optionsHtml += `<option value="${c.id}">${c.groupName}</option>`;
    });
    return optionsHtml;
}
function submitForm(){
    let postObject = {
        classId: $('#problem-class').val(),
        problems: []
    };
    
    for(let i = 1; i <= projectLength; i++){
        let problem = {
            statement: '',
            choices: []
        };
        problem.statement = $('#add-problem-' + i).val();
        $('#choices-' + i + ' .answer-choice').map(function() {
            problem.choices.push({
                choice: this.value,
                isCorrect: $(this).closest('.row').find('.answer-radio').is(':checked') ? 1 : 0
            });
        });
        postObject.problems.push(problem);
    }

    addProblems(postObject);
}

function addProblems(problems){
    let input = {
        function_name: 'add_problems',
        problems: JSON.stringify(problems)
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: input,
        async: false,
        success: function(data) {
            // allGroups = data;
            console.log(data);
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
}

function getAllProblems(classId){
    let input = {
        function_name: 'get_problems',
        classId: classId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            console.log('All problems', data);
            let problemsTable = $('#problems-table').DataTable();
            problemsTable.clear().destroy();
            problemsTable = $('#problems-table').DataTable( {
                "data": data,
                "columns": [
                    { "data": "userName" },
                    { "data": "postedDate",
                        "render": function ( data, type, row ) {
                            return dateFormatter(row["postedDate"]);
                        } },
                    { "data": "statement", "render": function ( data, type, row ) {
                            return data.length > 50 ? data.substr(0, 50) + '...': data;
                        }, },
                    { "data": "id", "render": function ( data, type, row ) {
                            let buttonHtml = "<input type='button' class='btn btn-info show-problem' value='Show Full Problem'>";
                            return buttonHtml;
                        }, }
                    // { "data": "id", "visible": "false" },
                    // { "data": "authorId", "visible": "false" },
                ]
            } );

            problemsTable.on('click', 'tr', function () {
                let data = $('#problems-table').DataTable().row(this).data();
                $('#problem-statement-dialog').html(data['statement']);
                getChoices(data['id']);
                $('#dialog').addClass("hidden").removeClass('hidden');
                $("#dialog").modal({
                    fadeDuration: 500,
                    fadeDelay: 0.25
                });
            } );
        }
    });
}

function getChoices(problemId){
    let input = {
        function_name: 'get_choices',
        problemId: problemId
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            let choiceHtml = '<ul class="choices-list">';
            data.forEach(choice => {
                choiceHtml += '<li>' + choice['answer'] + '</li>';
            });
            choiceHtml += '</ul>'
            $('#answer-choices-dialog').html(choiceHtml);
        }

    });
}