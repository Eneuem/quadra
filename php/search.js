document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault();
    // Ajoutez ici la logique pour traiter le formulaire de recherche
    // Vous pouvez utiliser AJAX pour envoyer une requête au serveur et récupérer les résultats
    // Affichez ensuite les résultats dans la liste déroulante
    searchMovies();
});

document.getElementById('search').addEventListener('input', function () {
    // Appelé lors de la saisie dans le champ de recherche
    // Vous pouvez ajouter la logique pour effectuer une requête au serveur et récupérer les suggestions
    // Affichez ensuite les suggestions dans la liste déroulante
    searchMovies();
});

function searchMovies() {
    var input = document.getElementById('search').value;

    if (input.length >= 2) {
        // Faire une requête AJAX pour obtenir des suggestions depuis le serveur
        fetch('php/search.php?input=' + input)
            .then(response => response.json())
            .then(suggestions => displaySuggestions(suggestions))
            .catch(error => console.error('Error fetching suggestions:', error));
    } else {
        clearSuggestions();
    }
}

function displaySuggestions(suggestions) {
    var suggestionsList = document.getElementById('suggestions');
    suggestionsList.innerHTML = '';

    suggestions.forEach(function (movie) {
        var listItem = document.createElement('li');
        var link = document.createElement('a');
        link.textContent = movie.title;
        link.href = movie.link; // Utilisez le lien provenant du serveur
        
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche la soumission du formulaire par défaut
            document.getElementById('search').value = movie.title;
            clearSuggestions();
            window.location.href = link.href; // Redirige vers movie_details.php
        });
        listItem.appendChild(link);
        suggestionsList.appendChild(listItem);
    });
}


function clearSuggestions() {
    var suggestionsList = document.getElementById('suggestions');
    suggestionsList.innerHTML = '';
}