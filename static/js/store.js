const book_type = document.getElementById("type");
const book_genre = document.getElementById("genre");
const book_container = document.getElementById("book-container");

function bookTypeChanged() {
    book_genre.innerHTML = "";
    if (book_type.value === "school") {
        book_genre.add(new Option("Select a genre...", "none", true));
        book_genre.add(new Option("English", "english"));
        book_genre.add(new Option("Maths", "math"));
        book_genre.add(new Option("Science", "science"));
    }
    else if (book_type.value === "fiction") {
        book_genre.add(new Option("Select a genre...", "none", true));
        book_genre.add(new Option("New arrivals", "arrivals"));
        book_genre.add(new Option("Love", "love"));
        book_genre.add(new Option("Prize winners", "prize"));
    }
}

// This function is called when the genre dropdown is changed.
// An AJAX request is sent to the server to get the books in the selected genre and type.
function bookGenreChanged() {
    var httpxml=new XMLHttpRequest();
    httpxml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            book_container.innerHTML = this.responseText;
        }
    };
    httpxml.open("GET", "getbooks.php?genre=" + book_genre.value, true);
    httpxml.send();
}

book_type.addEventListener("change", bookTypeChanged);
book_genre.addEventListener("change", bookGenreChanged);