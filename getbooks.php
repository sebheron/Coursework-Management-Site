<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "x1f52";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        $result = $conn->query("SELECT * FROM books WHERE genre = '" . $_GET["genre"] . "'");
        if ($result->num_rows > 0)
        {
            while($data = $result->fetch_assoc())
            {
                echo "<div class=\"panel-block\">
                        <div class=\"book\">
                            <img src=\"" . $data["img"] . "\"/>
                            <div class=\"panel-contents\">
                                <a href=\"\"><h2>" . $data["title"] . "</h2></a>
                                <p>" . $data["detail"] . "</p>
                                <p class=\"price\"><i>" . $data["price"] . "</i></p>
                            </div>
                            <div class=\"panel-buttons\">
                                <a class=\"embossed-button\" href=\"order.php?id=" . $data["id"] . "\">Order</a>
                            </div>
                        </div>
                    </div>";
            }
        }
        else
        {
            echo "<p><i>No entries found</i></p>";
        }
        $conn->close();
    }
?>