 <script>
        // JavaScript pour vérifier l'état de la connexion
        window.addEventListener('DOMContentLoaded', (event) => {
            var userLoggedIn = <?php echo json_encode($userLoggedIn); ?>;

            var loginBtn = document.getElementById('loginBtn');
            var signupBtn = document.getElementById('signupBtn');
            var userName = document.getElementById('userName');
            var userIcon = document.getElementById('userIcon');

            var loginBtnM = document.getElementById('loginBtn-mobile');
            var signupBtnM = document.getElementById('signupBtn-mobile');
            var userNameM = document.getElementById('userName-mobile');
            var userIconM = document.getElementById('userIcon-mobile');

            if (userLoggedIn) {
                // Si l'utilisateur est connecté
                loginBtn.style.display = 'none';
                signupBtn.style.display = 'none';
                userName.style.display = 'block';
                userIcon.style.display = 'block';
                loginBtnM.style.display = 'none';
                signupBtnM.style.display = 'none';
                userNameM.style.display = 'block';
                userIconM.style.display = 'block';
            } else {
                // Si l'utilisateur n'est pas connecté
                loginBtn.style.display = 'block';
                signupBtn.style.display = 'block';
                userName.style.display = 'none';
                userIcon.style.display = 'none';
                loginBtnM.style.display = 'block';
                signupBtnM.style.display = 'block';
                userNameM.style.display = 'none';
                userIconM.style.display = 'none';
            }
        });

        // Ajouter l'événement de clic
        document.addEventListener('DOMContentLoaded', (event) => {
            var userName = document.getElementById('userName');
            var userMenu = document.getElementById('userMenu');

            userName.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });
        });



        window.addEventListener('click', function(event) {
            if (!userMenu.contains(event.target) && event.target !== userName) {
                userMenu.classList.add('hidden');
            }
        });





</script>