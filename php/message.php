<?php
/*
Builds a HTML page with a title and message then navigating to the url after the time.
*/
function displayMessage($title, $message, $url) {?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Login to the book store.">
            <meta name="author" content="19014086">
            <meta name="keywords" content="Library, Libraries, Book, Books, Novel, Novella, Non-fiction, Fiction, Reading, Reading List, Login">
            <link rel="icon" href="../favicon.ico">
            <link rel="apple-touch-icon" href="../image/512.png"/>
    
            <title><?php echo $title?> | Online Bookstore</title>
    
            <link href="../static/css/style.css" rel="stylesheet"/>
    
            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <div id="user-bar" class="login-bar">
            </div>
            <div class="navigation-bar">
                <div class="center-panel-container">
                    <a class="logo" href="../index.html"><img src="../image/books.png"/><span class="logo-text">Online Bookstore</span></a>
                    <div id="nav-bar" class="navigation-buttons">
                    </div>
                </div>
            </div>
            <div class="panels-container">
                <div class="panel-block w22">
                    <h1 class="center-text"><?php echo $title?></h1>
                    <p class="center-text"><?php echo $message?></p>
                    <a href="<?php echo $url?>" class="embossed-button fill-button">Continue</a>
                </div>
            </div>
            <script src="../static/js/userbar.js"></script>
        </body>
    </html>
<?php 
}
?>