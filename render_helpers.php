<?php

function render_navbar($user_role){
    $rootPath =  './'; // explode('/',  $_SERVER['SERVER_NAME'])[1];
    if($user_role == "Tutor"){
        return '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
                    <div class="container">
                      <a class="navbar-brand js-scroll-trigger" href="./dashboard.php">Dashboard</a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./classes.php">Classes</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./problems.php">Problems</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./articles.php">Articles</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./tests.php">Tests</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./logout.php">Logout</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>';
    }else if($user_role == "Student"){
        return '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
                    <div class="container">
                      <a class="navbar-brand js-scroll-trigger" href="#page-top">Dashboard</a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./classes.php">Classes</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./problems.php">Problems</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./articles.php">Articles</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./tests.php">Tests</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./logout.php">Logout</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>';
    }else if($user_role == 'System Admin'){
        return '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
                    <div class="container">
                      <a class="navbar-brand js-scroll-trigger" href="./dashboard.php">Dashboard</a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./users.php">Users</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./classes.php">Classes</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./problems.php">Problems</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./articles.php">Articles</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./tests.php">Tests</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./logout.php">Logout</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>';
    }else if($user_role == 'Guest'){
        return '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
                    <div class="container">
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./classes.php">Classes</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./articles.php">Articles</a>
                          </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger" href="./logout.php">Logout</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>';
    }
    return null;
}

function render_footer(){
    $rootPath =  explode('/',  $_SERVER['SERVER_NAME'])[1];
    return '  <!-- Footer -->
              <footer class="py-5 bg-dark">
                <div class="container">
                  <p class="m-0 text-center text-white">Copyright &copy; Uni Project</p>
                </div>
                <!-- /.container -->
              </footer>
            
              <!-- Bootstrap core JavaScript -->
              <script src="' . $rootPath . '/vendor/jquery/jquery.min.js"></script>
              <script src="' . $rootPath . '/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            
              <!-- Plugin JavaScript -->
              <script src="' . $rootPath . '/vendor/jquery-easing/jquery.easing.min.js"></script>
            
              <!-- Custom JavaScript for this theme -->
              <script src="' . $rootPath . '/js/scrolling-nav.js"></script>
              <script src="' . $rootPath . '/js/jquery.dataTables.min.js"></script>
            
              <script src="' . $rootPath . '/js/scripts.js"></script>
            ';
}