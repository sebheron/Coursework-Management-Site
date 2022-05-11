const user_bar = document.getElementById("user-bar");
const nav_bar = document.getElementById("nav-bar");

let forward = "php/";
let backward = "";
if (window.location.href.indexOf("php") > -1) {
    forward = "";
    backward = "../";
}

function domLoaded() {
    var httpxml=new XMLHttpRequest();

    httpxml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var json = JSON.parse(this.responseText);
            if(json.success) {
                user_bar.innerHTML = "<a class=\"embossed-button\" href=\"" + forward + "logout.php\">Logout</a><p>" + json.name + "</p>";
                nav_bar.innerHTML = "<a class=\"debossed-button\" href=\"" + backward + "index.html\">Home</a><a class=\"debossed-button\" href=\"" + backward + "php/orders.php\">Orders</a>";
                if (json.admin) {
                    nav_bar.innerHTML += "<a class=\"debossed-button\" href=\"" + backward + "admin.html\">Management</a>";
                }
            } else {
                user_bar.innerHTML = "<a class=\"embossed-button\" href=\"" + backward + "register.html\">Register</a><a class=\"embossed-button\" href=\"" + backward + "login.html\">Login</a>";
                nav_bar.innerHTML = "<a class=\"debossed-button\" href=\"" + backward + "index.html\">Home</a>";
            }
        }
    };

    httpxml.open("GET", forward + "verify.php?respond=json", true);
    httpxml.send();
}

document.addEventListener("DOMContentLoaded", domLoaded, false);