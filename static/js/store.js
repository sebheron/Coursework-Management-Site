const book_type = document.getElementById("type");
const book_genre = document.getElementById("genre");
const book_container = document.getElementById("book-container");

function bookTypeChanged() {
    book_genre.innerHTML = "";
    if (book_type.value === "school") {
        book_genre.add(new Option("Select a genre...", "", true));
        book_genre.add(new Option("English", "english"));
        book_genre.add(new Option("Maths", "math"));
        book_genre.add(new Option("Science", "science"));
    }
    else if (book_type.value === "fiction") {
        book_genre.add(new Option("Select a genre...", "", true));
        book_genre.add(new Option("New arrivals", "arrivals"));
        book_genre.add(new Option("Love", "love"));
        book_genre.add(new Option("Prize winners", "prize"));
    }
    refreshBooks();
}

// This function is called to refresh the books displayed.
// An AJAX request is sent to the server to get the books in the selected genre and type.
function refreshBooks() {
    var httpxml=new XMLHttpRequest();
    httpxml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            book_container.innerHTML = this.responseText;
        }
    };
    var query = "";
    if (book_genre.value != "") {
        query += "genre=" + book_genre.value;
    }
    else if (book_type.value != "") {
        query += "class=" + book_type.value;
    }
    httpxml.open("GET", "php/getbooks.php?" + query, true);
    httpxml.send();
}

book_type.addEventListener("change", bookTypeChanged);
book_genre.addEventListener("change", refreshBooks);
document.addEventListener("DOMContentLoaded", refreshBooks, false);