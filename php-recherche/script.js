$(document).ready(function () {
    // Attachez un gestionnaire d'événements au champ de recherche
    $("#search").on("input", function () {
      // Obtenez la valeur du champ de recherche
      var query = $(this).val();
  
      // Vérifiez si la valeur est vide
      if (query === "") {
        $("#searchResults").empty();
      } else {
        // Utilisez Ajax pour interroger l'API et obtenir les suggestions
        $.ajax({
          url: "suggest.php", // Créez un fichier PHP pour gérer les suggestions
          type: "GET",
          data: {search: query},
          success: function (data) {
            // Mettez à jour la liste des suggestions
            $("#searchResults").html(data);
          },
        });
      }
    });
  });
  
  // // JavaScript for search bar toggle
  // const searchInput = document.getElementById("search");
  
  // searchInput.addEventListener("focus", function () {
  //   searchInput.classList.add("active");
  // });
  
  // searchInput.addEventListener("blur", function () {
  //   if (searchInput.value === "") {
  //     searchInput.classList.remove("active");
  //   }
  // });
  
  // Toggle Mobile Menu
  const btn = document.getElementById("menu-btn");
  const menu = document.getElementById("menu");
  
  btn.addEventListener("click", navToggle);
  
  function navToggle() {
    btn.classList.toggle("open");
    menu.classList.toggle("flex");
    menu.classList.toggle("hidden");
  }
  
  $(document).ready(function () {
    var searchInput = $("#search");
    var searchResults = $("#searchResults");
    var searchForm = $("#searchForm"); // Store the form element
    var placeholderText = "Find Movies & TV";
  
    searchInput.on("input", function () {
      var results = [""];
      displayResults(results);
    });
  
    // Handle click event on search results
    searchResults.on("click", "li", function (event) {
      var selectedResult = $(this).text();
      searchInput.val(selectedResult);
      searchResults.empty().hide();
  
      // Prevent the default form submission
      event.preventDefault();
  
      // Trigger the form submission
      searchForm.submit();
    });
  
    // Handle hover effect on search results
    searchResults.on("mouseover", "li", function () {
      $(this).addClass("hovered");
    });
  
    searchResults.on("mouseout", "li", function () {
      $(this).removeClass("hovered");
    });
  
    $(document).on("click", function (event) {
      if (
        !$(event.target).closest("#searchResults").length &&
        !$(event.target).is(searchInput) &&
        !$(event.target).closest("#searchForm").length
      ) {
        searchInput.val(""); // Clear the input text
        searchInput.attr("placeholder", placeholderText); // Set the placeholder text
        searchResults.empty().hide();
      }
    });
  
    function displayResults(results) {
      searchResults.empty();
  
      for (var i = 0; i < results.length; i++) {
        searchResults.append("<li>" + results[i] + "</li>");
      }
  
      searchResults.width(searchInput.outerWidth());
  
      searchResults.show();
    }
  });
  