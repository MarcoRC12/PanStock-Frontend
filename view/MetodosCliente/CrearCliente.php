<!-- Formulario emergente -->
<div id="formModal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-6">
        <div class="flex flex-col space-y-1.5 mb-4">
            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Registro de cliente</h3>
            <p class="text-sm text-muted-foreground">Ingresa los datos personales</p>
        </div>
        <form id="clientForm" method="post">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="nombre">
                        Nombre
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombre" name="cl_nombre" placeholder="Ingresa tu nombre" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="apellido">
                        Apellido
                    </label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="apellido" name="cl_apellido" placeholder="Ingresa tu apellido" required />
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="td_id">
                    Tipo de documento
                </label>
                <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="td_id" name="td_id" required>
                    <?php foreach ($data_tdocumento["Detalle"] as $td) : ?>
                        <option value="<?= $td["td_id"] ?>"><?= $td["td_nombre"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="dni">
                    DNI
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="dni" name="cl_documento" placeholder="Ingresa tu DNI" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="telefono">
                    Teléfono
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="telefono" name="cl_telefono" placeholder="Ingresa tu teléfono" type="tel" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">
                    Email
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" name="cl_email" placeholder="Ingresa tu email" type="email" required />
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
        document.getElementById('clientForm').reset();
    }

    $(document).ready(function() {
        $('#clientForm').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize() + '&ajax=1';

            $.ajax({
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.Status === 200) {
                        alertify.success('Registro exitoso');
                        hideForm();
                        $('#clientForm')[0].reset();
                        location.reload();
                    } else {
                        alertify.error('Error al registrar cliente: ' + (response.Error || 'Desconocido'));
                    }
                },
                error: function(xhr, status, error) {
                    alertify.error('Error al realizar la solicitud: ' + error);
                }
            });
        });
    });
</script>