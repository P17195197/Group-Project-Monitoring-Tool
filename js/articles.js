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
    });

});

let allArticles = [];

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
            allArticles = data;
            renderArticles(data);
        },
        error: function (error) {
         console.log(error);
        }
    });
}

function formatArticle(text){
    if(text.length > 250){
        return text.substr(0, 250) + "...";
    }
    return text;
}

function formatTitle(text){
    if(text.length > 60){
        return text.substr(0, 60) + "...";
    }
    return text;
}

function renderArticles(articles){
    let articlesHtml = '';
    articles.forEach(article => {
        let articleTemplate = $('#article-item-template').html();
        articleTemplate = articleTemplate.replace(/{article-id}/g, article["id"]);
        articleTemplate = articleTemplate.replace(/{article-title}/g, formatTitle(article["title"]));
        articleTemplate = articleTemplate.replace(/{article-body}/g, formatArticle(article["content"]));
        articleTemplate = articleTemplate.replace(/{article-author}/g, article["authorName"]);
        articleTemplate = articleTemplate.replace(/{article-date}/g, dateFormatter(article["createdDate"]));
        articlesHtml += articleTemplate;
    });
    $('#articles-list').html(articlesHtml);
    $('.article-item').on('click', function () {
        let articleId = this.id.replace("article-item-", "");
        const article = allArticles.find(a => a["id"] === articleId);
        $("#article-render-title").html(article["title"]);
        $("#article-render-author").html(article["authorName"]);
        $("#article-render-time").html(dateFormatter(article["createdDate"]));
        $("#article-render-content").html(article["content"]);
        $('html, body').animate({
            scrollTop: $("#article-render").offset().top - 50
        }, 200);
    });
    const defaultArticle = allArticles[0];
    $("#article-render-title").html(defaultArticle["title"]);
    $("#article-render-author").html(defaultArticle["authorName"]);
    $("#article-render-time").html(dateFormatter(defaultArticle["createdDate"]));
    $("#article-render-content").html(defaultArticle["content"]);
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
