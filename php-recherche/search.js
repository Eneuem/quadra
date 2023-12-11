function searchMovies() {
    var input = document.getElementById('movie-search').value;

    if (input.length >= 2) {
        // Faire une requête AJAX pour obtenir des suggestions depuis le serveur
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var suggestions = JSON.parse(this.responseText);
                displaySuggestions(suggestions);
            }
        };

        xmlhttp.open('GET', 'search.php?input=' + input, true);
        xmlhttp.send();
    } else {
        clearSuggestions();
    }
}

function displaySuggestions(suggestions) {
    var suggestionsList = document.getElementById('suggestions');
    suggestionsList.innerHTML = '';

    suggestions.forEach(function(movie) {
        var listItem = document.createElement('li');
        listItem.textContent = movie.title;
        listItem.addEventListener('click', function() {
            document.getElementById('movie-search').value = movie.title;
            clearSuggestions();
        });
        suggestionsList.appendChild(listItem);
    });
}

function clearSuggestions() {
    var suggestionsList = document.getElementById('suggestions');
    suggestionsList.innerHTML = '';
}

