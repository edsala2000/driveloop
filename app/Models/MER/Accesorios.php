<?php

namespace App\Models\MER;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class Accesorios extends Model
{
	protected $table = 'accesorios';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'des'
	];

	// public function marca()
	// {
	// 	return $this->belongsTo(Marca::class, 'codmar');
	// }

	// public function vehiculos()
	// {
	// 	return $this->hasMany(Vehiculo::class, 'codlin');
	// }
}
