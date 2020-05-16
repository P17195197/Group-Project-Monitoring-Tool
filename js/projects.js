let testLength = 0;
let allGroups = [];

$(document).ready(function(){
    getGroups();
    getTests();
    $('#add-question').on('click', function(){
        testLength++;
        let questionTemplate = $('#test-question-template').html();
        $('#test-questions').append(questionTemplate.replace(/{test-id}/g, testLength));
        $('#add-topic-' + testLength).on('click', function () {
            let closestDiv = $('#choices-' + this.id.replace('add-topic-', ''));
            let choiceTemplate = $('#choice-template').html();
            closestDiv.append(choiceTemplate);
        });
        $('#test-class-' + testLength).html(mapGroupsToOptions());
        $( "#test-date-" + testLength ).datepicker();
        $( "#test-date-" + testLength ).datepicker('setDate', new Date());
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
    let testObjects = [];
    for(let i=1; i<=testLength; i++){
        let testObj = {};
        testObj.classId = $('#test-class-' + i).val();
        testObj.testName = $('#test-add-test-' + i).val();
        testObj.testDate = $('#test-date-' + i).val();
        testObj.testDuration = $('#test-duration-' + i).val();
        let topics = [];
        $('#choices-' + i + ' .answer-choice').map(function() {
            topics.push(this.value);
        });
        testObj.topics = topics.toString();
        testObjects.push(testObj);
    };
    addTests(testObjects);
}

function addTests(tests){
    let input = {
        function_name: 'add_tests',
        tests: JSON.stringify(tests)
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

function getTests(){
    let input = {
        function_name: 'get_tests'
    };
    $.ajax({    //create an ajax request to display.php
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        async: false,
        success: function(data) {
            renderTests(data);
        }

    });
}

function renderTests(tests){
    let testsTable = $('#tests-table').DataTable();
    testsTable.clear().destroy();
    testsTable = $('#tests-table').DataTable( {
        "data": tests,
        "columns": [
            { "data": "testName" },
            { "data": "groupName" },
            { "data": "testDate", "render": function ( data, type, row ) {
                    return dateFormatter(row["testDate"]);
                } },
            { "data": "duration", "render": function ( data, type, row ) {
                    return row["duration"] + ' minutes';
                } },
            { "data": "topics" }
        ]
    } );
}