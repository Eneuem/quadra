$(document).ready(function() {
    // Attachez un gestionnaire d'événements au champ de recherche
    $("#search").on("input", function() {
        // Obtenez la valeur du champ de recherche
        var query = $(this).val();

        // Vérifiez si la valeur est vide
        if (query === "") {
            $("#searchResults").empty();
        } else {
            // Utilisez Ajax pour interroger l'API et obtenir les suggestions
            $.ajax({
                url: "../suggest.php", // Créez un fichier PHP pour gérer les suggestions
                type: "GET",
                data: { search: query },
                success: function(data) {
                    // Mettez à jour la liste des suggestions
                    $("#searchResults").html(data);
                }
            });
        }
    });
});

