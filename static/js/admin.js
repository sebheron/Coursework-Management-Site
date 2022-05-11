const table = document.getElementById("admin-table-body");

function addToTable(json) {
    var row = table.insertRow();

    var order_id = row.insertCell();
    var book_id = row.insertCell();
    var title = row.insertCell();
    var author = row.insertCell();
    var price = row.insertCell();
    var user_id = row.insertCell();
    var name = row.insertCell();
    var phone = row.insertCell();
    var email = row.insertCell();

    order_id.appendChild(document.createTextNode(json.order.id));
    book_id.appendChild(document.createTextNode(json.book.id));
    title.appendChild(document.createTextNode(json.book.title));
    author.appendChild(document.createTextNode(json.book.author));
    price.appendChild(document.createTextNode(json.book.price));
    user_id.appendChild(document.createTextNode(json.user.id));
    name.appendChild(document.createTextNode(json.user.name));
    phone.appendChild(document.createTextNode(json.user.phone));
    email.appendChild(document.createTextNode(json.user.email));
}

function loopThroughIds() {
    var httpxml=new XMLHttpRequest();

    httpxml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var json = JSON.parse(this.responseText);
                for (var i = 0; i < json.length; i++) {
                    addEntry(json[i]);
                }
            } catch (e) {
                return false;
            }
        }
    }

    httpxml.open("GET", "php/admin.php?id=-1", true);
    httpxml.send();
}

function addEntry(i) {
    var httpxml=new XMLHttpRequest();

    httpxml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var json = JSON.parse(this.responseText);
                if (json.order != undefined) {
                    addToTable(json);
                }
            } catch (e) {
                return false;
            }
        }
    };

    httpxml.open("GET", "php/admin.php?id=" + i, true);
    httpxml.send();
}


document.addEventListener("DOMContentLoaded", loopThroughIds, false);