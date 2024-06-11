<!-- Formulario emergente -->
<div id="formModal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-6">
        <div class="flex flex-col space-y-1.5 mb-4">
            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Registro de productos</h3>
            <p class="text-sm text-muted-foreground">Ingresa los datos de los productos</p>
        </div>
        <form id="productForm" method="post">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="nombre">
                    Nombre
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="nombre" name="pro_nombre" placeholder="Ingresa el nombre" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="descripcion">
                    Descripción
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="descripcion" name="pro_descripcion" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="tpro_id">
                    Tipo de producto
                </label>
                <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="tpro_id" name="tpro_id" required>
                    <?php foreach ($data_tproducto["Detalle"] as $tpro) : ?>
                        <option value="<?= $tpro["tpro_id"] ?>"><?= $tpro["tpro_nombre"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="marca">
                    Marca
                </label>
                <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="marca" name="pro_marca" required>
                    <option value="La Panadería">La Panadería</option>
                    <option value="La Repostería">La Repostería</option>
                    <option value="Dulce Delicia">Dulce Delicia</option>
                    <option value="Pan Saludable">Pan Saludable</option>
                    <option value="Galletería Fina">Galletería Fina</option>
                    <option value="Pasteles Gourmet">Pasteles Gourmet</option>
                    <option value="Bagels & More">Bagels & More</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="imagen">
                    Imagen
                </label>
                <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="imagen" name="pro_imagen" required />
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
        document.getElementById('productForm').reset();
    }

    $(document).ready(function() {
        $('#productForm').on('submit', function(event) {
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
                        $('#productForm')[0].reset();
                        location.reload();
                    } else {
                        alertify.error('Error al registrar producto: ' + (response.Error || 'Desconocido'));
                    }
                },
                error: function(xhr, status, error) {
                    alertify.error('Error al realizar la solicitud: ' + error);
                }
            });
        });
    });
</script>