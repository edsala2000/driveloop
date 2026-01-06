<?php

namespace App\Modules\PublicacionVehiculos\Controllers;

use App\Http\Controllers\Controller;

use App\Models\MER\Vehiculo;              // ajusta el namespace real
use App\Models\MER\DocumentoVehiculo;      // ajusta el namespace real
use App\Models\MER\FotoVehiculo;           // ajusta el namespace real
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehiculoDocumentosController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'placa' => ['required', 'string', 'max:10'],
            'codveh' => ['required', 'integer'],

            'documentos' => ['required', 'array', 'size:2'],
            'documentos.*.idtipdoc' => ['required', 'integer', 'in:1'],
            'documentos.*.archivo' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],

            'fotos' => ['nullable', 'array', 'max:10'],
            'fotos.*' => ['image', 'max:6144'],
        ]);

        // Placa limpia para carpeta y para numdoc
        $placa = strtoupper(preg_replace('/[^A-Z0-9]/', '', $request->placa));

        $codveh = (int) $request->codveh;

        // (Opcional pero recomendado) Verifica que el vehículo exista
        if (!Vehiculo::whereKey($codveh)->exists()) {
            return back()->withInput()->withErrors(['codveh' => 'El vehículo no existe.']);
        }

        $docsDir  = "vehiculos/{$placa}/documentos";
        $fotosDir = "vehiculos/{$placa}/fotos";

        DB::transaction(function () use ($request, $placa, $codveh, $docsDir, $fotosDir) {

            foreach ($request->documentos as $idx => $doc) {

                $idtipdoc = (int) $doc['idtipdoc']; // siempre 1
                $file = $doc['archivo'];
                $ext  = $file->getClientOriginalExtension();

                // ✅ nombre por índice: 0 tarjeta, 1 soat
                $nombre = $idx === 0
                    ? "tarjeta_propiedad.{$ext}"
                    : "soat.{$ext}";

                $path = $file->storeAs($docsDir, $nombre, 'public');


                DocumentoVehiculo::create([
                    'idtipdocveh' => $idtipdoc, // <- nombre real
                    'numdoc'      => $placa,
                    'empexp'      => '',        // NOT NULL en tu BD
                    'descdoc'     => $path,     // <- nombre real
                    'codveh'      => $codveh,
                ]);
            }


            if ($request->hasFile('fotos')) {
                // foreach ($request->file('fotos') as $i => $foto) {
                //     $ext = $foto->getClientOriginalExtension();

                //     // ⚠️ nombre corto si tu columna nom es corta
                //     $token = substr(Str::uuid()->toString(), 0, 8);
                //     $nombre = 'f' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . "_{$token}.{$ext}";

                //     // Dimensiones
                //     $imgSize = @getimagesize($foto->getRealPath());
                //     $dim = $imgSize ? ($imgSize[0] . 'x' . $imgSize[1]) : '';

                //     // Mime + peso
                //     $mim = $foto->getMimeType() ?? '';
                //     $pes = (int) $foto->getSize(); // bytes

                //     $path = $foto->storeAs($fotosDir, $nombre, 'public');

                //     FotoVehiculo::create([
                //         'nom'    => $nombre,
                //         'ruta'   => $path,
                //         'dim'    => $dim,
                //         'mim'    => $mim,
                //         'pes'    => $pes,
                //         'codveh' => $codveh,
                //     ]);
                // }
                if ($request->hasFile('fotos')) {
                    foreach ($request->file('fotos') as $i => $foto) {

                        $ext = strtolower($foto->getClientOriginalExtension() ?: 'jpg');

                        // ✅ Nombre basado en placa + consecutivo
                        $nombre = $placa . '_' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . '.' . $ext;

                        // Dimensiones
                        $imgSize = @getimagesize($foto->getRealPath());
                        $dim = $imgSize ? ($imgSize[0] . 'x' . $imgSize[1]) : '';

                        // Mime + peso
                        $mim = $foto->getMimeType() ?? '';
                        $pes = (int) $foto->getSize();

                        // ✅ Guarda en carpeta de la placa
                        $path = $foto->storeAs($fotosDir, $nombre, 'public');

                        FotoVehiculo::create([
                            'nom'    => $nombre, // ✅ PLACA_01.ext
                            'ruta'   => $path,
                            'dim'    => $dim,
                            'mim'    => $mim,
                            'pes'    => $pes,
                            'codveh' => $codveh,
                        ]);
                    }
                }
            }
        });

        return back()->with('ok', 'Guardado OK');
    }
}
