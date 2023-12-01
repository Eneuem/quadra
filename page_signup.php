<link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<div class="flex justify-center items-center h-screen">
    <div x-data="{ open: false }">
        <!-- Open modal button -->
        <button x-on:click="open = true" class="px-4 py-2 bg-indigo-500 text-white rounded-md"> sign up </button>
        <!-- Modal Overlay -->
        <div x-show="open" class="fixed inset-0 px-2 z-10 overflow-hidden flex items-center justify-center">
            <div x-show="open" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <!-- Modal Content -->
            <div x-data="app()" x-cloak class=" flex items-center justify-center z-0" @click.away="open = false">
                <div class="max-w-2xl border shadow-md rounded-lg bg-white">
                    <div class="w-full mx-auto px-4 py-10">
                        <!---step complete ---->
                        <div x-show.transition="step === 'complete'">
                            <div class="bg-white  p-10 flex items-center justify-between">
                                <div>
                                    <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">Registration Success</h2>
                                    <button @click="step = 1" x-on:click="open = false" class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Back to home</button>
                                </div>
                            </div>
                        </div>
                        <!---/step complete ---->

                        <!---- start step---->
                        <div x-show.transition="step != 'complete'">
                            <!-- Top Navigation -->
                            <div class="border-b-2 py-4">
                                <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight" x-text="`Step: ${step} of 3`"></div>
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex-1 mr-4 mb-1">
                                        <div x-show="step === 1">
                                            <div class="text-lg font-bold text-gray-700 leading-tight">Your Profile</div>
                                        </div>
                                        <div x-show="step === 2">
                                            <div class="text-lg font-bold text-gray-700 leading-tight">Your Password</div>
                                        </div>
                                        <div x-show="step === 3">
                                            <div class="text-lg font-bold text-gray-700 leading-tight">Your Profile Details</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center md:w-64">
                                        <div class="w-full bg-white rounded-full mr-2">
                                            <div class="rounded-full bg-green-500 text-xs leading-none h-2 text-center text-white" :style="'width: '+ parseInt(step / 3 * 100) +'%'"></div>
                                        </div>
                                        <div class="text-xs w-10 text-gray-600" x-text="parseInt(step / 3 * 100) +'%'"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Top Navigation -->


                            <div class="py-10">
                                <!-- Step 1 -->
                                <div x-show.transition.in="step === 1">
                                    <div class="mb-5">
                                        <label for="login" class="font-bold mb-1 text-gray-700 block">Login</label>
                                        <input :type="login" x-model='login' class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login..." require>
                                    </div>
                                    <div class="mb-5">
                                        <label for="email" class="font-bold mb-1 text-gray-700 block">Email</label>
                                        <input :type="email" x-model="email" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Enter your login..." require>
                                    </div>
                                </div>
                                <!-- /Step 1 -->

                                <!-- Step 2 -->
                                <div x-show.transition.in="step === 2">

                                    <div class="mb-5">
                                        <label for="password" class="font-bold mb-1 text-gray-700 block">Set up password</label>
                                        <div class="text-gray-600 mt-2 mb-4">
                                            Please create a secure password including the following criteria below.

                                            <ul class="list-disc text-sm ml-4 mt-2">
                                                <li>lowercase letters</li>
                                                <li>numbers</li>
                                                <li>capital letters</li>
                                                <li>special characters</li>
                                            </ul>
                                        </div>

                                        <div class="relative">

                                            <input :type="togglePassword ? 'text' : 'password'" @keydown="checkPasswordStrength()" x-model="password" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Your strong password...">

                                            <div class="absolute right-0 bottom-0 top-0 px-3 py-3 cursor-pointer" @click="togglePassword = !togglePassword">
                                                <svg :class="{'hidden': !togglePassword, 'block': togglePassword }" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current text-gray-500" viewBox="0 0 24 24">
                                                    <path d="M12 19c.946 0 1.81-.103 2.598-.281l-1.757-1.757C12.568 16.983 12.291 17 12 17c-5.351 0-7.424-3.846-7.926-5 .204-.47.674-1.381 1.508-2.297L4.184 8.305c-1.538 1.667-2.121 3.346-2.132 3.379-.069.205-.069.428 0 .633C2.073 12.383 4.367 19 12 19zM12 5c-1.837 0-3.346.396-4.604.981L3.707 2.293 2.293 3.707l18 18 1.414-1.414-3.319-3.319c2.614-1.951 3.547-4.615 3.561-4.657.069-.205.069-.428 0-.633C21.927 11.617 19.633 5 12 5zM16.972 15.558l-2.28-2.28C14.882 12.888 15 12.459 15 12c0-1.641-1.359-3-3-3-.459 0-.888.118-1.277.309L8.915 7.501C9.796 7.193 10.814 7 12 7c5.351 0 7.424 3.846 7.926 5C19.624 12.692 18.76 14.342 16.972 15.558z" />
                                                </svg>

                                                <svg :class="{'hidden': togglePassword, 'block': !togglePassword }" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current text-gray-500" viewBox="0 0 24 24">
                                                    <path d="M12,9c-1.642,0-3,1.359-3,3c0,1.642,1.358,3,3,3c1.641,0,3-1.358,3-3C15,10.359,13.641,9,12,9z" />
                                                    <path d="M12,5c-7.633,0-9.927,6.617-9.948,6.684L1.946,12l0.105,0.316C2.073,12.383,4.367,19,12,19s9.927-6.617,9.948-6.684 L22.054,12l-0.105-0.316C21.927,11.617,19.633,5,12,5z M12,17c-5.351,0-7.424-3.846-7.926-5C4.578,10.842,6.652,7,12,7 c5.351,0,7.424,3.846,7.926,5C19.422,13.158,17.348,17,12,17z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex items-center mt-4 h-3">
                                            <div class="w-2/3 flex justify-between h-2">
                                                <div :class="{ 'bg-red-400': passwordStrengthText == 'Too weak' ||  passwordStrengthText == 'Could be stronger' || passwordStrengthText == 'Strong password' }" class="h-2 rounded-full mr-1 w-1/3 bg-gray-300"></div>
                                                <div :class="{ 'bg-orange-400': passwordStrengthText == 'Could be stronger' || passwordStrengthText == 'Strong password' }" class="h-2 rounded-full mr-1 w-1/3 bg-gray-300"></div>
                                                <div :class="{ 'bg-green-400': passwordStrengthText == 'Strong password' }" class="h-2 rounded-full w-1/3 bg-gray-300"></div>
                                            </div>
                                            <div x-text="passwordStrengthText" class="text-gray-500 font-medium text-sm ml-3 leading-none"></div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /Step 2 -->

                                <!-- /Step 3 -->
                                <div x-show.transition.in="step === 3">
                                    <div class="mb-5 w-full flex flex-col gap-3">
                                        <label for="login" class="font-bold mb-1 text-gray-700 block">Login</label>
                                        <input :type="text" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none cursor-not-allowed focus:shadow-outline text-gray-600 font-medium" x-bind:value="login" disabled>
                                        <label for="email" class="font-bold mb-1 text-gray-700 block">Email</label>
                                        <input :type="email" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none cursor-not-allowed focus:shadow-outline text-gray-600 font-medium" x-bind:value="email" disabled>
                                        <label for="password" class="font-bold mb-1 text-gray-700 block">Password</label>
                                        <div class="relative">
                                            <input :type="togglePassword ? 'text' : 'password'" x-bind:value="password" class="w-full px-4 py-3 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" disabled>
                                            <div class="absolute right-0 bottom-0 top-0 px-3 py-3 cursor-pointer" @click="togglePassword = !togglePassword">
                                                <svg :class="{'hidden': !togglePassword, 'block': togglePassword }" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current text-gray-500" viewBox="0 0 24 24">
                                                    <path d="M12 19c.946 0 1.81-.103 2.598-.281l-1.757-1.757C12.568 16.983 12.291 17 12 17c-5.351 0-7.424-3.846-7.926-5 .204-.47.674-1.381 1.508-2.297L4.184 8.305c-1.538 1.667-2.121 3.346-2.132 3.379-.069.205-.069.428 0 .633C2.073 12.383 4.367 19 12 19zM12 5c-1.837 0-3.346.396-4.604.981L3.707 2.293 2.293 3.707l18 18 1.414-1.414-3.319-3.319c2.614-1.951 3.547-4.615 3.561-4.657.069-.205.069-.428 0-.633C21.927 11.617 19.633 5 12 5zM16.972 15.558l-2.28-2.28C14.882 12.888 15 12.459 15 12c0-1.641-1.359-3-3-3-.459 0-.888.118-1.277.309L8.915 7.501C9.796 7.193 10.814 7 12 7c5.351 0 7.424 3.846 7.926 5C19.624 12.692 18.76 14.342 16.972 15.558z" />
                                                </svg>
                                                <svg :class="{'hidden': togglePassword, 'block': !togglePassword }" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current text-gray-500" viewBox="0 0 24 24">
                                                    <path d="M12,9c-1.642,0-3,1.359-3,3c0,1.642,1.358,3,3,3c1.641,0,3-1.358,3-3C15,10.359,13.641,9,12,9z" />
                                                    <path d="M12,5c-7.633,0-9.927,6.617-9.948,6.684L1.946,12l0.105,0.316C2.073,12.383,4.367,19,12,19s9.927-6.617,9.948-6.684 L22.054,12l-0.105-0.316C21.927,11.617,19.633,5,12,5z M12,17c-5.351,0-7.424-3.846-7.926-5C4.578,10.842,6.652,7,12,7 c5.351,0,7.424,3.846,7.926,5C19.422,13.158,17.348,17,12,17z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Step 3 -->
                            </div>
                            <!-- / Step Content -->
                        </div>
                        <!---- /start step---->
                    </div>
                    <!-- Bottom Navigation -->
                    <div class="py-5 bg-white " x-show="step != 'complete'">
                        <div class="max-w-3xl mx-auto px-4">
                            <div class="flex justify-between">
                                <div class="w-1/2">
                                    <button x-show="step > 1" @click="step--" class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Previous</button>
                                </div>

                                <div class="w-1/2 text-right">
                                    <button x-show="step < 3" @click="step++" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Next</button>

                                    <button @click="step = 'complete'" x-show="step === 3" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Complete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function app() {
        return {
            step: 1,
            passwordStrengthText: '',
            togglePassword: false,
            password: '',
            login: '',
            email: '',

            checkPasswordStrength() {
                var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
                var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");

                let value = this.password;

                if (strongRegex.test(value)) {
                    this.passwordStrengthText = "Strong password";
                } else if (mediumRegex.test(value)) {
                    this.passwordStrengthText = "Could be stronger";
                } else {
                    this.passwordStrengthText = "Too weak";
                }
            },
        }
    }

    let isVisibilityOn = true;

    function toggleVisibility() {
        let visibility = document.getElementById("visibility");
        let visibility_off = document.getElementById("visibility_off");

        if (isVisibilityOn) {
            visibility.style.display = "none";
            visibility_off.style.display = "block";
        } else {
            visibility.style.display = "block";
            visibility_off.style.display = "none";
        }

        isVisibilityOn = !isVisibilityOn;
    }


    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
</script>