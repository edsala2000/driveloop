<div class="container-fluid page cont__gral_public">

    <section class="card">
        <header class="head">
            <h1>Registro de vehículo</h1>
            <p>Por favor llene toda la información solicitada, se verificará en las próximas 48 horas.</p>
            <div class="rule"></div>
        </header>

        <form class="veh-form" action="#" method="post"> @csrf
            <!-- Columna izquierda -->
            <div class="veh-col">
                <div class="veh-field"> {{-- <label class="veh-label" for="placa">Placa</label> --}} <input type="hidden" name="vin" value="pendiente">
                </div>
                <div class="veh-field"> <label class="veh-label" for="clase">Clase de vehículo</label>
                    <div class="veh-select"> <select id="clase" name="codcla" required> {{-- <option value="" selected disabled></option> --}}
                            @foreach ($vehiculoClase as $item)
                                <option value="{{ $item->cod }}">{{ $item->des }}</option>
                            @endforeach
                        </select> </div>
                </div>
                <div class="veh-field"> <label class="veh-label" for="marca">Marca</label>
                    <div class="veh-select"> <select id="marca" name="codmar" required> {{-- <option value="" selected disabled></option> --}}
                            @foreach ($vehiculoMarca as $itemMarca)
                                <option value="{{ $itemMarca->cod }}">{{ $itemMarca->des }}</option>
                            @endforeach
                        </select> </div>
                </div>
                <div class="veh-field"> <label class="veh-label" for="linea">Linea</label>
                    <div class="veh-select"> <select id="linea" name="codlin" required disabled>
                            <option value="" selected disabled>Seleccione una marca primero</option>
                        </select> </div>
                </div> {{-- <div class="veh-field"> <label class="veh-label" for="placa">Placa</label> <input id="placa" name="placa" type="text" required /> </div> --}} <div class="veh-field"> <label class="veh-label" for="modelo_anio">Modelo
                        (año)</label> <input id="modelo_anio" name="mod" type="number" inputmode="numeric"
                        min="1900" max="2026" step="1" placeholder="Ej: 2026" required /> </div>
                <div class="veh-field"> <label class="veh-label" for="pasajeros">Capacidad pasajeros</label> <input
                        id="pasajeros" name="pas" type="number" inputmode="numeric" min="1" max="4"
                        step="1" placeholder="" required /> </div>
                <div class="veh-field"> <label class="veh-label" for="color">Color</label> <input id="color"
                        name="col" type="text" required /> </div>
                <div class="veh-field"> <label class="veh-label" for="Cilindraje">Cilindraje</label> <input
                        id="Cilindraje" name="cil" type="number" inputmode="numeric" min="1000" max="2500"
                        step="1" placeholder="Ej: 2000" required /> </div>
                <div class="veh-field"> {{-- <label class="veh-label" for="placa">Poliza</label> --}} <input type="hidden" name="codpol" value="1">
                </div>
                <div class="veh-field"> <label class="veh-label" for="combustible">Tipo de combustible</label>
                    <div class="veh-select"> <select id="combustible" name="codcom" required> {{-- <option value="" selected disabled></option> --}}
                            @foreach ($vehiculoCombustible as $itemComb)
                                <option value="{{ $itemComb->cod }}">{{ $itemComb->des }}</option>
                            @endforeach
                        </select> </div>
                </div>
            </div> <!-- Columna derecha -->
            <div class="veh-col">
                <div class="veh-block">
                    <div class="veh-block">
                        <h3>Por favor seleccione los accesorios del vehículo.</h3>
                        <div class="veh-accessories">

                            @foreach ($vehiculoAccesorios as $acc)
                                <label class="veh-check"> <input type="checkbox" name="accesorios[]"
                                        value="{{ $acc->id }}"> <span class="veh-dot"></span> {{ $acc->des }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="veh-block">
                        <h3>Por favor seleccione la ubicación donde se encuentra el vehículo.</h3>
                        <div class="veh-row2">
                            <div class="veh-field"> <label class="veh-label" for="depto">Departamento</label>
                                <div class="veh-select"> <select id="depto" name="depto" required>
                                        <option value="" selected disabled></option>
                                        <option value="valle">Valle del Cauca</option>
                                    </select> </div>
                            </div>
                            <div class="veh-field"> <label class="veh-label" for="municipio_bottom">Municipio</label>
                                <div class="veh-select"> <select id="municipio_bottom" name="municipio_bottom"
                                        required>
                                        <option value="" selected disabled></option>
                                        <option value="cali">Cali</option>
                                    </select> </div>
                            </div>
                        </div>
                    </div> 
                    <button class="veh-btn" type="submit">Siguiente</button>
                </div>
        </form>
    </section>
</div>
