<?php

namespace App\Modules\PublicacionVehiculos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use App\Models\MER\Marca;
use App\Models\MER\User;
use App\Models\MER\Accesorios;
use App\Models\MER\CiudadVehiculo;
use App\Models\MER\DepartamentoVehiculo;
use App\Models\MER\Linea;
use App\Models\MER\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehController extends Controller
{
    public function index()
    {
        return view('modules.PublicacionVehiculo.registroVeh', [
            'vehiculoClase' => Clase::all(),
            'vehiculoMarca' => Marca::all(),
            'vehiculoAccesorios' => Accesorios::all(),
            'vehiculoCombustible' => Combustible::all(),
            'deptoVehiculo' => DepartamentoVehiculo::all(),

        ]);
    }

    public function lineasPorMarca(int $cod)
    {
        $lineas = Linea::query()
            ->select('cod', 'des')
            ->where('codmar', $cod)
            ->orderBy('des')
            ->get();

        return response()->json($lineas);
    }

    public function ciudadesPorDepartamento(int $coddepveh)
    {
        $ciudades = CiudadVehiculo::query()
            ->select('codciuveh', 'nomciuveh')
            ->where('coddepveh', $coddepveh)
            ->orderBy('nomciuveh')
            ->get();

        return response()->json($ciudades);
    }

    public function create() {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'vin' => ['required', 'string'],
            'mod' => ['required', 'integer', 'between:1900,' . (date('Y') + 1)],
            'col' => ['required', 'string', 'max:30'],
            'pas' => ['required', 'integer', 'min:1', 'max:99'],
            'cil' => ['required', 'integer', 'min:50', 'max:10000'],
            'codpol' => ['nullable', 'integer'],
            'codmar' => ['required', 'integer'],
            'codlin' => ['required', 'integer'],
            'codcla' => ['required', 'integer'],
            'codcom' => ['required', 'integer'],

            'codciuveh' => ['required', 'integer', 'exists:ciudad_vehiculo,codciuveh'],

            'accesorios' => ['nullable', 'array'],
            'accesorios.*' => ['integer', 'exists:accesorios,id']
        ]);

        return DB::transaction(function () use ($data) {

            $vehiculo = \App\Models\MER\Vehiculo::create([
                'user_id' => Auth::id(),
                'vin' => $data['vin'],
                'mod' => $data['mod'],
                'col' => $data['col'],
                'pas' => $data['pas'],
                'cil' => $data['cil'],
                'codpol' => $data['codpol'] ?? null,
                'codmar' => $data['codmar'],
                'codlin' => $data['codlin'],
                'codcla' => $data['codcla'],
                'codcom' => $data['codcom'],
                'codciuveh' => $data['codciuveh']
            ]);

            $vehiculo->accesorios()->sync($data['accesorios'] ?? []);

            // return redirect()->route('vehiculo-ver');
            return redirect()->route('vehiculo.documentos.create', ['codveh' => $vehiculo->cod]);
        });
    }

    public function vehiculo()
    {
        return view('modules.PublicacionVehiculo.documentVehic', [
            'vehiculo' => Vehiculo::all(),
        ]);
    }


    // public function show(ClaseVeh $claseVeh) 
    // {

    // }

    // public function edit(ClaseVeh $claseVeh) 
    // {

    // }

    // public function update(Request $request, ClaseVeh $claseVeh) 
    // {

    // }

    // public function destroy(ClaseVeh $claseVeh) 
    // {

    // }
}
