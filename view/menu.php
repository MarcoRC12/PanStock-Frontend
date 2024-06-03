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
    <div class="custom-bg custom-text w-64 p-6 flex flex-col gap-6">
        <div class="">
            <a href="home.php" class="flex items-center gap-2 rounded-md px-3 py-2">
                <img src="../img/logo-app-fondoBlanco.jpg" alt="Logo" class="h-16 w-16 rounded-full">
                <span class="text-2xl font-semibold">Mana Pan Del cielo</span>
            </a>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="produccion.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8">
                    <path d="M3 11v3a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-3"></path>
                    <path d="M12 19H4a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3.83"></path>
                    <path d="m3 11 7.77-6.04a2 2 0 0 1 2.46 0L21 11H3Z"></path>
                    <path d="M12.97 19.77 7 15h12.5l-3.75 4.5a2 2 0 0 1-2.78.27Z"></path>
                </svg>
                <span class="text-lg">Producción</span>
            </a>
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="inventario.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                    <path d="m3.3 7 8.7 5 8.7-5"></path>
                    <path d="M12 22V12"></path>
                </svg>
                <span class="text-lg">Inventario</span>
            </a>
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="clientes.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="text-lg">Clientes</span>
            </a>
            <a href="pedidos.php" class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                <span class="text-lg">Pedidos</span>
            </a>
            <a class="flex items-center gap-2 rounded-md px-3 py-2 hover-effect" href="reportes.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8">
                    <line x1="12" x2="12" y1="20" y2="10"></line>
                    <line x1="18" x2="18" y1="20" y2="4"></line>
                    <line x1="6" x2="6" y1="20" y2="16"></line>
                </svg>
                <span class="text-lg">Reportes</span>
            </a>
        </nav>
    </div>