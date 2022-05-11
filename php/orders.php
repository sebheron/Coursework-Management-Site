<?php
    require "db.php";
    require "message.php";
    require "verify.php";
    require "security.php";

    /*
    Builds a panel element to display the total cost of all books.
    Requires the total cost of all books to be supplied.
    */
    function buildTotalPanel($total) {
        if (isset($total)) {
            ?>
                <div class="panel-block">
                    <p class="center-text">Overall total: £<?php echo $total?></p>
                </div>
            <?php
        }
    }

    /*
    Builds a panel element to be displayed on the DOM for a book.
    Requires the book's id, title, detail, price, and image.
    */
    function getBookPanel($id, $title, $detail, $price, $img, $loggedin, $count) {
        if (isset($id) && isset($title) && isset($detail) && isset($price) && isset($img)) {
            ?>
                <div class="panel-block w50">
                    <div class="book">
                        <img src="<?php echo $img;?>"/>
                        <div class="panel-contents">
                            <a href="display.php?id=<?php echo $id;?>"><h2><?php echo $title;?></h2></a>
                            <p><?php echo $detail;?></p>
                        </div>
                        <div class="order-box">
                            <p class="order-count">Ordered: <?php echo $count;?></p>
                            <p><i>Total: £<?php echo $price * $count;?></i></p>
                            <a class="embossed-button m-center" href="remove.php?id=<?php echo $id;?>">Remove</a>
                        </div>
                    </div>
                </div>
            <?php
        }
    }

    function top() {?>
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
        
                <title>Orders | Online Bookstore</title>
        
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
                <div class="orders-container">
    <?php
    }

    function bottom() {?>
                </div>
                <script src="../static/js/userbar.js"></script>
            </body>
        </html>
    <?php 
    }

    if (!isset($response["success"]) || !$response["success"]) {
        displayMessage("Order", "You are not logged in.", "../login.php");
    }

    //Build array of counts of books in each order.
    $query = "SELECT bookid, count(*) FROM orders WHERE userid = ? GROUP BY bookid";
    if($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($orderid, $count);
        while($stmt->fetch()) {
            $orders[] = $orderid;
            $counts[$orderid] = $count;
        }
        $stmt->close();
    }
    else {
        displayMessage("Order", "Error connecting to database.", "display.php?id=$oid");
        exit();
    }

    //Gets the books for the orders.
    if (isset($orders)) {
        $query = "SELECT id, title, detail, price, img FROM books WHERE id = ?";
        if($stmt = $conn->prepare($query)) {
            $overall_total = 0;
            top();
            foreach ($orders as $order) {
                $stmt->bind_param("i", $order);
                $stmt->execute();
                $stmt->bind_result($id, $title, $detail, $price, $img);
                while($stmt->fetch()) {
                    getBookPanel($id, $title, $detail, $price, $img, isset($response["success"]) && $response["success"], $counts[$order]);
                    $overall_total += $price * $counts[$order];
                }
            }
            buildTotalPanel($overall_total);
            bottom();
            $stmt->close();
        }
        else {
            displayMessage("Order", "Error connecting to database.", "display.php?id=$oid");
            exit();
        }
    }
    else {
        displayMessage("Order", "You have no orders.", "../");
    }
?>