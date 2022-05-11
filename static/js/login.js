/*
Way of passing ID around to PHP scripts.
*/

const id_input = document.getElementById('id-input');

//Parses the query string into a dictionary
function parseQueryString(queryString) {
    var params = {};
    var queries = queryString.split("&");
    for (var i = 0; i < queries.length; i++) {
        var query = queries[i].split("=");
        params[query[0]] = query[1];
    }
    return params;
}

//Gets the query string from the URL
function getQueryString() {
    var queryString = window.location.search;
    if (queryString.length > 0) {
        queryString = queryString.substring(1);
    }
    return queryString;
}

function domLoaded() {
    var queryString = getQueryString();
    var params = parseQueryString(queryString);
    if (params["id"] != undefined) {
        id_input.value = params["id"];
    }
}

document.addEventListener("DOMContentLoaded", domLoaded, false);