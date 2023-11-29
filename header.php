   <!-- Nav Container -->
   <nav class="relative container mx-auto p-2 mt-4 bg-gray-800">

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
                           <input type="text" name="q" class="w-full border h-10 shadow p-4 pl-10 pr-10 rounded-full" placeholder="Find Movies & TV">
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
                   <a href="#" class="text-yellow-400 hover:text-lime-100">Free Movies & TV</a>
                   <a href="#" class="text-yellow-400 hover:text-lime-100">Live TV</a>
                   <a href="#" class="text-yellow-400 hover:text-lime-100">Featurs</a>
                   <a href="#" class="text-yellow-400 hover:text-lime-100">Download</a>
               </div>
               <div class="hover:text-lime-100">Login</div>
               <a href="#" class="px-4 py-1 font-bold text-lime-100  bg-yellow-400 rounded-sm hover:opacity-70">Sign Up</a>
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

               <a href=" #" class="w-full text-center border-t border-b border-gray-400">Free Movies & TV</a>
               <a href="#" class="w-full text-center border-b border-gray-400">Live TV</a>
               <a href="#" class="w-full text-center border-b border-gray-400">Featurs</a>

           </div>
       </div>
   </nav>