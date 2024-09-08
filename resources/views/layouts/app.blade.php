<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vendas</title>
    @vite('resources/css/app.css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/sales">Vendas</a>
        <a class="navbar-brand" href="/products">Produtos</a>
        <a class="navbar-brand" href="/customers">Clientes</a>
        <a class="navbar-brand" href="/sellers">Vendedores</a>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    @vite('resources/js/app.js')

    @stack('scripts')
</body>

</html>