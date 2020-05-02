$(document).ready(function () {
    $('#article-title').keyup(function(event){
        $('#article-title-preview').text(this.value);
    });
    $('#article-content').keyup(function(event){
        $('#article-content-preview').text(this.value);
    });
    $('#post-article').click(function(){
        console.log('Article being posted');
        postArticle();
    })
});

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
            }
        },
        error: function (error) {
            showFailureAlert();
        }

    });
}
