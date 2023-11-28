<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<main class="w-full flex-col">
    <img src="./img/illustration.jpg" class="w-full h-3/6 object-cover hover:opacity-75 hover:cursor-pointer ">
    <img src="./img/cover.jpg" class="w-40 relative bottom-48 left-12 rounded-md hidden md:block shadow-md">
    <div class="h-1/2 absolute top-1/2 w-full p-12">
        <div class="flex items-center justify-center md:justify-start gap-1">
            <h1 class="font-bold text-5xl">Titre</h1>
            <span class="material-symbols-outlined relative top-1 left-4">
                star
            </span>
            <span class="material-symbols-outlined relative top-2 left-4 cursor-pointer">
                favorite
            </span>
        </div>
    </div>
    <video class="w-full flex items-center justify-center" controls>
        <source src="./img/joker-trailer.mp4" type="video/mp4">
    </video>

</main>

<script src="https://cdn.tailwindcss.com"></script>