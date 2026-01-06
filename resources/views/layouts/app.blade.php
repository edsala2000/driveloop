<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Driveloop') }}</title>

    <!-- Icon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/publicacion/pubVeh.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen img-background">
        <div class="mx-4 sm:mx-16 sm:px-6 lg:px-8 min-w-60">
            <div class="py-2">
                <div class="p-2">
                    @include('layouts.navigation')
                </div>
            </div>
            <!-- Page Heading -->
            <!-- @isset($header)
    <header class="shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endisset -->

            <!-- Page Content -->
            <main>
                <div class="py-1">
                    <div class="sm:rounded-lg">
                        <div class="p-2">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const marcaSelect = document.getElementById('marca');
            const lineaSelect = document.getElementById('linea');

            if (!marcaSelect || !lineaSelect) {
                console.error('No existe #marca o #linea en el DOM');
                return;
            }

            const endpointTemplate = @json(route('marcas.lineas', ['cod' => '__COD__']));

            function resetLineas(texto) {
                lineaSelect.innerHTML = `<option value="" selected disabled>${texto}</option>`;
                lineaSelect.disabled = true;
            }

            marcaSelect.addEventListener('change', async () => {
                const codMarca = marcaSelect.value;
                resetLineas('Cargando líneas...');

                try {
                    const url = endpointTemplate.replace('__COD__', encodeURIComponent(codMarca));

                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);

                    const data = await res.json();

                    if (!Array.isArray(data) || data.length === 0) {
                        return resetLineas('Esta marca no tiene líneas');
                    }

                    lineaSelect.disabled = false;
                    lineaSelect.innerHTML =
                        `<option value="" selected disabled>Seleccione una línea</option>`;
                    data.forEach(l => {
                        lineaSelect.insertAdjacentHTML('beforeend',
                            `<option value="${l.cod}">${l.des}</option>`);
                    });

                } catch (e) {
                    console.error(e);
                    resetLineas('No se pudieron cargar las líneas');
                }
            });

            resetLineas('Seleccione una marca primero');
        });
    </script>


</body>

</html>
