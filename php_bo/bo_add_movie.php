<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Inclure jQuery -->
            <div>
            <form id="searchForm" action="api_search.php" method="GET">
                    <div class="flex relative">
                        <input type="text" id="search" name="search" class="w-full border h-10 shadow p-4 pl-10 pr-10 rounded-full placeholder:font-thin" placeholder="Find Movies & TV" required />

                        <button type="submit">
                            <svg class="text-yellow-400 h-5 w-5 absolute top-3 right-3 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background: new 0 0 56.966 56.966" xml:space="preserve">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"></path>
                            </svg>
                        </button>
                        <ul id="searchResults" class=" absolute bg-gray-900 mt-10 rounded-md text-yellow-400 p-2"></ul>
                    </div>
                </form>
            </div>
        </div>
        <?php include("bo_header_script.php"); ?>