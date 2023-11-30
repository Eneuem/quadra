<?php
include 'notes.php';

include 'moyenne.php';

?>
<style>
  .wrapper-rating {
    font-size: 3em;
    line-height: 0;
    margin: 0;
    --coulFillHover: #FD0;
    /* couleur de fond au survol */
    --coulFillSelected: #FFC;
    /* couleur de fond selected */
    --coulStrokeHover: #F00;
    /* couleur de bord au survol */
    --coulStrokeSelected: #FA0;
    /* couleur de bord selected */
  }

  .wrapper-rating label {
    cursor: pointer;
    border-bottom: 2px solid currentColor;
  }

  .wrapper-rating input {
    position: absolute;
    opacity: 0;
  }

  .wrapper-rating input:checked~* label {
    --coulFillSelected: #FAFAFA;
    /* couleur de fond par défaut */
    --coulStrokeSelected: #CCC;
    /* couleur de bord par défaut */
    border-bottom: 2px solid transparent;
  }

  .wrapper-rating .star {
    display: inline-flex;
    color: var(--coulStrokeSelected);
    cursor: pointer;
  }

  .wrapper-rating .star svg {
    width: 1em;
    height: 1em;
    transition: .25s;
    stroke-width: 1;
    stroke: var(--coulStrokeSelected);
    fill: var(--coulFillSelected);
  }

  .wrapper-rating .star:hover>label svg {
    fill: var(--coulFillHover);
    stroke: var(--coulStrokeHover);
  }
</style>
<form class="box" action="index.php" method="post">
  <fieldset>
    <legend>Donnez une note</legend>
    <input type="hidden" name="id" value="sessionID">
    <p class="wrapper-rating">
      <input name="note" id="note_0" value="-1" type="radio" checked autofocus>
      <span class="star">
        <input name="note" id="note_1" value="1" type="radio">
        <label for="note_1" title="Très mauvaise">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
            <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
          </svg>
        </label>
        <span class="star">
          <input name="note" id="note_2" value="2" type="radio">
          <label for="note_2" title="Médiocre">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
              <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
            </svg>
          </label>
          <span class="star">
            <input name="note" id="note_3" value="3" type="radio">
            <label for="note_3" title="Moyenne">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
                <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
              </svg>
            </label>
            <span class="star">
              <input name="note" id="note_4" value="4" type="radio">
              <label for="note_4" title="Bonne">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
                  <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
                </svg>
              </label>
              <span class="star">
                <input name="note" id="note_5" value="5" type="radio">
                <label for="note_5" title="Excellente">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
                    <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
                  </svg>
                </label>
              </span>
            </span>
          </span>
        </span>
      </span>
    </p>
    <p>
      <button type="reset" title="Effacer la note en cours">Effacer</button>
      <button type="submit" title="Envoyer votre note">Voter</button>
    </p>
  </fieldset>

  <fieldset>
    <legend>Moyenne des notes en étoiles</legend>
    <?php
    // Calcul de la moyenne des notes
    $sqlAverage = "SELECT AVG(notes_value) as average FROM notes";
    $stmtAverage = $conn->prepare($sqlAverage);
    $stmtAverage->execute();
    $result = $stmtAverage->fetch(PDO::FETCH_ASSOC);
    $average = $result['average'];

    echo "La moyenne des notes est : " . round($average, 2);

    function afficherMoyenneEnEtoiles($moyenne)
    {
      // Nombre total d'étoiles
      $nombreEtoiles = 5;

      // Calculer le pourcentage de la moyenne par rapport au maximum (5 étoiles)
      $pourcentage = ($moyenne / $nombreEtoiles) * 100;

      // Créer une représentation visuelle avec des étoiles pleines et vides
      $etoilesPleines = round($pourcentage / 20);
      $etoilesVides = $nombreEtoiles - $etoilesPleines;

      // Afficher les étoiles
      echo str_repeat('★', $etoilesPleines) . str_repeat('☆', $etoilesVides);
    }
    ?>
  </fieldset>
</form>
