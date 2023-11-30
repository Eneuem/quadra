         <!-- Nav Container -->
         <nav class="relative  mx-auto p-2  bg-gray-800 bg-opacity-70">

             <!-- Flex Container For All Items -->
             <div class="flex items-center justify-between">

                 <!-- Flex Container For Logo/Search -->
                 <div class="flex items-center space-x-6">

                     <!-- Logo -->
                     <img src="img/Q.JPG" alt="" class="h-10 w-10 rounded-full" />

                     <!-- Search -->
                     <div>
                         <form action="/search">
                             <div class="flex relative ">
                                 <input type="text" name="q" class="w-full border h-10 shadow p-4 pl-10 pr-10 rounded-full placeholder:font-thin" placeholder="Find Movies & TV">
                                 <button type="submit">
                                     <svg class="text-yellow-400 h-5 w-5 absolute top-3 right-3 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                                         <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z">
                                         </path>
                                     </svg>
                                 </button>
                             </div>
                         </form>
                     </div>
                 </div>

                 <!-- Right Buttons Menu -->

                 <div class="hidden items-center space-x-6 font-bold text-yellow-400 lg:flex">
                     <div class=" hidden space-x-8 font-bold lg:flex">
                         <a href="#" class="text-yellow-400 hover:text-lime-100">Wishlist</a>
                         <a href="#" class="text-yellow-400 hover:text-lime-100">Categories</a>
                         <a href="#" class="text-yellow-400 hover:text-lime-100">Random Movie</a>
                     </div>
                     <a href="#" class="text-yellow-400 hover:text-lime-100">|</a>
                     <div class="items-center space-x-6 font-bold text-yellow-400 lg:flex">
                         <div id="loginBtn" class="hover:text-lime-100">Login</div>
                         <a href="#" id="signupBtn" class="px-4 py-1 font-bold text-lime-100 bg-yellow-400 rounded-xl hover:opacity-70">Sign Up</a>
                         <div id="userName" class="hidden hover:text-lime-100">User Name</div>
                         <div id="userIcon">
                             <svg class="hidden text-yellow-400 h-8 w-8 top-3 fill-current" xmlns="http://www.w3.org/2000/svg" height="34" viewBox="0 -960 960 960" width="24">
                                 <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"></path>
                             </svg>
                         </div>
                     </div>
                 </div>


                 <!-- Hamburger Button -->
                 <button id="menu-btn" class="block hamburger lg:hidden focus:outline-none" type="button">
                     <span class="hamburger-top"></span>
                     <span class="hamburger-middle"></span>
                     <span class="hamburger-bottom"></span>
                 </button>
             </div>

             <!-- Mobile Menu -->
             <div id="menu" class="absolute hidden p-6 bg-gray-800   left-6 right-6 top-20 z-100">

                 <div class="flex flex-col items-center justify-center w-full space-y-6 font-bold text-yellow-400 rounded-md">
                     <div class=" items-center justify-center space-x-2">
                         <a href="#" class="w-6 py-2 px-4 text-center rounded-md bg-yellow-400 text-lime-100">Sign Up</a>
                         <a href="#" class="w-6 py-2 px-6 text-center rounded-md border">Login</a>

                     </div>

                     <a href=" #" class="w-full text-center border-t border-b border-gray-400">Categories</a>
                     <a href="#" class="w-full text-center border-b border-gray-400">Wishlist</a>
                     <a href="#" class="w-full text-center border-b border-gray-400">Random Movie</a>

                 </div>
             </div>
         </nav>
