<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<main class="container-lg w-full flex flex-col items-center">
    <img src="./img/illustration.jpg" class="w-full h-96 object-cover hidden md:block">
    <div class="flex flex-col md:flex-row w-full md:pl-12">
        <img src="./img/cover.jpg" class="w-full rounded-md md:w-72 md:relative md:bottom-48">
        <div class="flex flex-col pl-4">
            <div class="flex flex-col">
                <div class="flex items-center">
                    <h1 class="font-bold text-5xl">Joker</h1>
                    <span class="material-symbols-outlined cursor-pointer ml-2 mt-2">
                        favorite
                    </span>
                </div>
                <span class="material-symbols-outlined">
                    star
                </span>
            </div>
            <div class="columns-2">
                <h5>année :</h5>
                <h5>Durée :</h5>
                <h5>Genres :</h5>
                <h5>Realisateur :</h5>
                <h5>Acteurs :</h5>
            </div>
            <p class="w-full md:w-2/3 mt-12">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic fugiat quasi nemo fuga, ea animi iusto magni blanditiis odio! Velit aperiam quas vero assumenda atque dolorum soluta, ipsa in aut?</p>
        </div>
    </div>
    <video class="w-full md:w-2/3" controls>
        <source src="./img/joker-trailer.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</main>

<script src="https://cdn.tailwindcss.com"></script>