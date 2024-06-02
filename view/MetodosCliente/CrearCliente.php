<!-- Formulario emergente -->
<div id="formModal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-6">
        <div class="flex flex-col space-y-1.5 mb-4">
            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Registro de cliente</h3>
            <p class="text-sm text-muted-foreground">Ingresa los datos personales</p>
        </div>
        <form action="crear_cliente.php" method="post">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="nombre">
                        Nombre
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="apellido">
                        Apellido
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="apellido" name="apellido" placeholder="Ingresa tu apellido" required />
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="td_id">
                    Tipo de documento
                </label>
                <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="td_id" name="td_id" required>
                    <?php foreach($data_tdocumento["Detalle"] as $td): ?>
                    <option id="<?= $td["td_id"] ?>" value="<?= $td["td_id"] ?>"><?= $td["td_nombre"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="dni">
                    DNI
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="dni" name="dni" placeholder="Ingresa tu DNI" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="telefono">
                    Teléfono
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="telefono" name="telefono" placeholder="Ingresa tu teléfono" type="tel" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">
                    Email
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="email" placeholder="Ingresa tu email" type="email" required />
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" class="mr-2 bg-red-500 text-white px-4 py-2 rounded-md" onclick="hideForm()">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript para mostrar y ocultar el formulario -->
    <script>
    function showForm() {
        document.getElementById('formModal').classList.remove('hidden');
    }

    function hideForm() {
        document.getElementById('formModal').classList.add('hidden');
        // Limpiar los valores de los campos del formulario
        document.getElementById('nombre').value = '';
        document.getElementById('apellido').value = '';
        document.getElementById('dni').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('email').value = '';
    }
    </script>