<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="../img/logo-app.jpg">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="flex-1 p-6">
            <h1 class="text-5xl text-yellow-800 font-bold mb-6">¡Bienvenido!</h1>
            <p class="text-gray-600 mb-8">Gestiona tu invetario, insumos, reportes y clientes.</p>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
                    <ul class="space-y-2">
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Order #123</span>
                                <span class="font-medium">$250.00</span>
                            </div>
                            <div class="text-gray-600 text-sm">Shipped on 05/25/2023</div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Order #124</span>
                                <span class="font-medium">$180.00</span>
                            </div>
                            <div class="text-gray-600 text-sm">Shipped on 05/22/2023</div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Order #125</span>
                                <span class="font-medium">$320.00</span>
                            </div>
                            <div class="text-gray-600 text-sm">Shipped on 05/20/2023</div>
                        </li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Top Selling Products</h2>
                    <ul class="space-y-2">
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Product A</span>
                                <span class="font-medium">150 units</span>
                            </div>
                            <div class="text-gray-600 text-sm">Sold in the last 30 days</div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Product B</span>
                                <span class="font-medium">120 units</span>
                            </div>
                            <div class="text-gray-600 text-sm">Sold in the last 30 days</div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <span>Product C</span>
                                <span class="font-medium">100 units</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>