<?php

namespace App\Modules\PublicacionVehiculos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MER\Clase;
use App\Models\MER\Combustible;
use App\Models\MER\Marca;   
use App\Models\MER\Accesorios;  
use App\Models\MER\Linea;     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehController extends Controller
{
    public function index()
    {
        return view('modules.PublicacionVehiculo.index', [
            'vehiculoClase' => Clase::all(),
            'vehiculoMarca' => Marca::all(),
            'vehiculoAccesorios' => Accesorios::all(),
            'vehiculoCombustible' => Combustible::all(),

            
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

    public function create()
    {
        
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'vin' => ['required', 'string', 'size:17'],
    //         'mod' => ['required', 'integer', 'between:1900,' . (date('Y') + 1)],
    //         'col' => ['required', 'string', 'max:30'],
    //         'pas' => ['required', 'integer', 'min:1', 'max:99'],
    //         'cil' => ['required', 'integer', 'min:50', 'max:10000'],
    //         'codpol' => ['nullable', 'integer'],
    //         'codmar' => ['required', 'integer'],
    //         'codlin' => ['required', 'integer'],
    //         'codcla' => ['required', 'integer'],
    //         'codcom' => ['required', 'integer'],

    //         'accesorios' => ['nullable', 'array'],
    //         // 'accesorios.*' => ['integer', 'exists:accesorios,cod'] // ⚠️ POSIBLE: depende de tu PK real (cod vs id)
    //         'accesorios.*' => ['integer', 'exists:accesorios,id'], // ⚠️ POSIBLE MAL: si tu tabla no tiene 'id' sino 'cod'
    //     ]);

    //     return DB::transaction(function () use ($data) {

    //         $vehiculo = \App\Models\MER\Vehiculo::create([
    //             'vin' => $data['vin'],
    //             'mod' => $data['mod'],
    //             'col' => $data['col'],
    //             'pas' => $data['pas'],
    //             'cil' => $data['cil'],
    //             'codpol' => $data['codpol'] ?? null,
    //             'codmar' => $data['codmar'],
    //             'codlin' => $data['codlin'],
    //             'codcla' => $data['codcla'],
    //             'codcom' => $data['codcom'],
    //         ]);

    //         $vehiculo->accesorios()->sync($data['accesorios'] ?? []); // ⚠️ MAL si la relación accesorios() no existe o pivote/keys no coinciden

    //         return redirect()->back()->with('ok', 'Vehículo y accesorios guardados.');
    //     });
    // }

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
