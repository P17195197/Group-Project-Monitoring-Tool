$(document).ready(function () {
    getArticles();
    $('#article-title').keyup(function(event){
        $('#article-title-preview').text(this.value);
    });
    $('#article-content').keyup(function(event){
        $('#article-content-preview').text(this.value);
    });
    $('#post-article').click(function(){
        postArticle();
    })
});

function getArticles(){
    var articleInput = {
        function_name: 'get_articles'
    };
    $.ajax({
        url: 'database/data_populate.php',
        type: "POST",
        dataType:'json',
        data: (articleInput),
        success: function(data) {
            console.log(data);
        },
        error: function (error) {
         console.log(error);
        }
    });
}

function postArticle(){
    var input = {
        function_name: 'post_article',
        title: $('#article-title').val(),
        content:  $('#article-content').val()
    };

    $.ajax({
        url: 'database/data_populate.php', //This is the current doc
        type: "POST",
        dataType:'json', // add json datatype to get json
        data: (input),
        success: function(data) {
            if(data){
                showSuccessAlert();
                setTimeout(function(){
                    location.reload();
                }, 3000);

            }
        },
        error: function (error) {
            showFailureAlert();
        }
    });
}
