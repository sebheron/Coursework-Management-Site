<?php
/*
Builds a HTML page with a title and message then navigating to the url after the time.
*/
require "db.php";
require "verify.php";
require "security.php";
require "message.php";

function displayBook($id, $title, $detail, $price, $img, $loggedin) {?>
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
                <div class="panel-block w40">
                    <div class="image-container">
                        <img class="book-image" src="<?php echo $img?>"/>
                        <p class="circle-price">£<?php echo $price?></p>
                    </div>
                    <h1 class="center-text"><?php echo $title?></h1>
                    <p class="center-text"><?php echo $detail?></p>
                    <?php if ($loggedin) {
                        ?><a href="order.php?id=<?php echo $id?>" class="embossed-button semi-fill-button w40">Order</a><?php
                    }
                    else {?>
                        <a href="../login.html?id=<?php echo $id?>" class="embossed-button semi-fill-button w40">Login to order</a>
                    <?php
                    }?>
                </div>
            </div>
            <script src="../static/js/userbar.js"></script>
        </body>
    </html>
<?php 
}

//Gets book information from the database by id.
$found = false;
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $query = "SELECT title, detail, price, img FROM books WHERE id = ? LIMIT 1";
    if($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($dbtitle, $dbdetail, $dbprice, $dbimg);
        while($stmt->fetch()) {
            displayBook($_GET["id"], $dbtitle, $dbdetail, $dbprice, $dbimg, isset($response["success"]) && $response["success"]);
            $found = true;
        }
        $stmt->close();
    }
    else {
        displayMessage("Login", "Error connecting to database.", "../");
        exit();
    }
}
else {
    displayMessage("Error", "Missing book id.", "../");
    exit();
}
if (!$found) {
    displayMessage("Error", "Book not found in database.", "../");
}
?>