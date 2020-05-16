<?php
// Always start this first
session_start ();
require ( 'config.php' );
require ( 'helpers/auth.php' );
require ( './render_helpers.php' );
require ( './database/message.php' );
$user = check_auth ();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Articles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
<!--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">-->
    <link href="css/main.css" rel="stylesheet">
</head>
<style type="text/css">
    .result {
        margin-top: 5%;
        padding: 5%;
        background: #eee;
        color: grey;
        text-align: center;
        width: 100%;
    }
</style>
<body id="page-top">

<?= render_navbar ( $user[ "roleName" ] ); ?>

<div class="container article-publish">
    <div class="row p-5 hidden">
        <div id="article-item-template">
            <div class="col-md-12 col-lg-12 article-item" id="article-item-{article-id}">
                <div class="article-header">
                    <h7>{article-title}</h7>
                    <div class="author">
                        <p class="author-name">{article-author}</p>
                        <p class="article-date">{article-date}</p>
                    </div>
                </div>
                <div class="article-body">
                    <p>{article-body}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-5  <?php if(($user["roleName"] != "Tutor") && ($user["roleName"] != "System Admin")) { echo "hidden"; } ?>">

        <div class="col-md-6 col-lg-6"><h4>Publish new article</h4>
            <form id="publish-article" name="publish-article" method="post" action="articles.php" role="form" novalidate="true">
                <div class="articles"></div>
                <div class="controls">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="article-title">Title *</label>
                                <input id="article-title" type="text" name="article-title" class="form-control"
                                       placeholder="Please enter a title for your article *" required="required"
                                       data-error="Title is required for an article.">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="article-content">Content *</label>
                                <textarea id="article-content" name="article-content" class="form-control"
                                          placeholder="Start writing..." rows="8" required="required"
                                          data-error="Content cannot be empty"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="button" id="post-article" class="btn btn-success btn-send disabled"
                                   value="Post article">
                        </div>

                        <div class="col-md-12 pt-2">
                            <div class="alert alert-success invisible" id="message-status-success">
                                <strong>Success!</strong> Your article is posted. Refreshing the page now...</a>
                            </div>
                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="alert alert-danger invisible" id="message-status-failure">
                                <strong>Failed!</strong> There was an error posting your article. Please try later.
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        <div class="col-md-6 col-lg-6">
            <h4 id="preview-text">Preview</h4>
            <div class="row">
                <div class="col-md-12">
                    <h5 id="article-title-preview"></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span id="article-content-preview"></span>
                </div>
            </div>

        </div>
    </div>
    <div class="row p-5">
        <div class="col-3">
            <div class="row" id="articles-list">
            </div>
        </div>
        <div class="col-9" id="article-render">
            <h4 id="article-render-title" class="article-title"></h4>
            <div class="author-details">
                <span class="author-name" id="article-render-author">

                </span>
                <span class="author-time" id="article-render-time">

                </span>
            </div>
            <div id="article-render-content" class="pt-5 p-1"></div>
        </div>

    </div>


</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Uni Project</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom JavaScript for this theme -->
<script src="./js/scrolling-nav.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/common.js"></script>
<script src="./js/articles.js"></script>

</body>
</html>