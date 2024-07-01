<style>
    .custom-bg {
        background-color: #996839;
        /* Asegúrate de que este color esté aplicado */
        height: 100%;
    }

    .custom-text {
        color: #D9C39C;
        /* Asegúrate de que este color esté aplicado */
    }

    .hover-effect:hover {
        background-color: #D9C39C;
        color: #996839;
    }

    body {
        background-color: #D9C39C;
    }

    .oleo-script {
        font-family: 'Oleo Script', cursive;
    }
</style>
<div class="flex h-screen w-full">
    <div class="custom-bg custom-text w-full sm:w-64 p-6 flex flex-col gap-6">
        <div class="">
            <a href="home.php" class="flex items-center gap-2 rounded-md px-3 py-2">
                <img src="../img/logo-app-fondoBlanco.jpg" alt="Logo" class="h-12 w-12 sm:h-16 sm:w-16 rounded-full">
                <span class="text-xl sm:text-2xl font-semibold">Mana Pan Del Cielo</span>
            </a>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="produccion.php">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3 11v3a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-3"></path>
                    <path d="M12 19H4a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3.83"></path>
                    <path d="m3 11 7.77-6.04a2 2 0 0 1 2.46 0L21 11H3Z"></path>
                    <path d="M12.97 19.77 7 15h12.5l-3.75 4.5a2 2 0 0 1-2.78.27Z"></path>
                </svg>
                <span class="text-base sm:text-lg">Producción</span>
            </a>
            <div>
                <button type="button" aria-controls="dropdown-inventory" aria-expanded="false" data-state="closed" class="rounded-md hover-effect flex items-center w-full gap-2 px-3 py-2" onclick="toggleDropdown('dropdown-inventory')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 sm:h-8 sm:w-8">
                        <path d="M22 8.35V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.35A2 2 0 0 1 3.26 6.5l8-3.2a2 2 0 0 1 1.48 0l8 3.2A2 2 0 0 1 22 8.35Z"></path>
                        <path d="M6 18h12"></path>
                        <path d="M6 14h12"></path>
                        <rect width="12" height="12" x="6" y="10"></rect>
                    </svg>
                    <span class="text-base sm:text-lg">Almacen</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-auto">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </button>
                <ul id="dropdown-inventory" class="hidden pl-8 mt-2 space-y-2">
                    <li>
                        <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="productos.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 sm:h-6 sm:w-6">
                                <path d="m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"></path>
                                <path d="m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"></path>
                                <path d="M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"></path>
                                <path d="m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"></path>
                                <path d="M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"></path>
                            </svg>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="inventario.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 sm:h-6 sm:w-6">
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                            <span>Inventario</span>
                        </a>
                    </li>
                </ul>
            </div>
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="clientes.php">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="text-base sm:text-lg">Clientes</span>
            </a>
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="pedidos.php">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                <span class="text-base sm:text-lg">Pedidos</span>
            </a>
        </nav>
    </div>
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const isExpanded = dropdown.classList.contains('hidden');
            dropdown.classList.toggle('hidden', !isExpanded);
            dropdown.classList.toggle('block', isExpanded);
        }
    </script>