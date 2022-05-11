<?php
    /*
    Contains methods for getting books from the database.
    By default all books are returned, however if values have been supplied then books are queried based on the supplied values.
    */
    require "db.php";
    require "verify.php";
    require "security.php";

    /*
    Queries the database for all books and returns the results as panels.
    Requires a connection and a query.
    */
    function queryDatabaseForBooks($conn, $get, $loggedin) {
        //Build base query.
        $query = "SELECT id, title, detail, price, img FROM books";

        $genre_supplied = isset($_GET["genre"]);
        $class_supplied = isset($_GET["class"]);

        //Append to query.
        if ($genre_supplied) {
            $query .= " WHERE genre = ?";
        }
        else if ($class_supplied) {
            $query .= " WHERE class = ?";
        }

        $found = false;
        if($stmt = $conn->prepare($query)) {
            if ($genre_supplied || $class_supplied) {
                $check = $genre_supplied ? $_GET["genre"] : $_GET["class"];
                $stmt->bind_param("s", $check);
            }
            $stmt->execute();
            $stmt->bind_result($id, $title, $detail, $price, $img);
            while($stmt->fetch()) {
                getBookPanel($id, $title, $detail, $price, $img, $loggedin);
                $found = true;
            }
            $stmt->close();
        }
        
        if (!$found)
        {
            echo "<p><i>No entries found</i></p>";
        }
    }

    /*
    If logged in the order button should appear.
    */
    function getOrderButton($id, $loggedin) {
        return $loggedin == true ? "<a class=\"embossed-button\" href=\"php/order.php?id=" . $id . "\">Order</a>" : "";
    }

    /*
    Builds a panel element to be displayed on the DOM for a book.
    Requires the book's id, title, detail, price, and image.
    */
    function getBookPanel($id, $title, $detail, $price, $img, $loggedin) {
        if (isset($id) && isset($title) && isset($detail) && isset($price) && isset($img)) {
            echo "<div class=\"panel-block\">
                    <div class=\"book\">
                        <img src=\"" . $img . "\"/>
                        <div class=\"panel-contents\">
                            <a href=\"php/display.php?id=" . $id . "\"><h2>" . $title . "</h2></a>
                            <p>" . $detail . "</p>
                            <p class=\"price\"><i>£" . $price . "</i></p>
                        </div>
                        <div class=\"panel-buttons\">
                            <a class=\"embossed-button\" href=\"php/display.php?id=" . $id . "\">View</a>
                            " . getOrderButton($id, $loggedin) . "
                        </div>
                    </div>
                </div>";
        }
    }

    //Call method.
    queryDatabaseForBooks($conn, $_GET, isset($response["success"]) && $response["success"]);
?>