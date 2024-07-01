<!-- Formulario emergente -->
<div id="formModal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-6">
        <div class="flex flex-col space-y-1.5 mb-4">
            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Productos</h3>
        </div>
        <form id="productorderForm" method="post">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="pro_id">
                    Nombre del producto
                </label>
                <select class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="pro_id" name="pro_id" required>
                    <?php foreach ($data_products["Detalle"] as $proid) : ?>
                        <option value="<?= $proid["pro_id"] ?>"><?= $proid["pro_nombre"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="prope_numorden">
                    Número de orden
                </label>
                <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="prope_numorden" name="prope_numorden" required />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="prope_descripcion">
                    Descripción
                </label>
                <input type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="prope_descripcion" name="prope_descripcion" required />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="prope_cantidad">Cantidad</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="number" id="prope_cantidad" name="prope_cantidad" required />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="prope_precio">Precio S/.</label>
                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" type="number" step="0.01" id="prope_precio" name="prope_precio" required />
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" class="mr-2 bg-red-500 text-white px-4 py-2 rounded-md" onclick="hideForm()">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
            </div>
        </form>
    </div>
</div>
<script>
    function showForm() {
        document.getElementById('formModal').classList.remove('hidden');
    }

    function hideForm() {
        document.getElementById('formModal').classList.add('hidden');
        document.getElementById('productorderForm').reset();
    }
</script>