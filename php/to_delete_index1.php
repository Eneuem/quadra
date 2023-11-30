<?php
include 'notes.php';

include 'moyenne.php';

?>

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
    // Utiliser la fonction pour afficher la moyenne en étoiles
    afficherMoyenneEnEtoiles($average);
    ?>
  </fieldset>
</form>