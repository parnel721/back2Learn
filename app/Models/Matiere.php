<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Matiere
 * 
 * @property int $idmatiere
 * @property string|null $nom_mat
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $cours_idcours
 * 
 * @property Cour $cour
 * @property Collection|Encadreur[] $encadreurs
 *
 * @package App\Models
 */
class Matiere extends Model
{
	protected $table = 'matiere';

	protected $casts = [
		'cours_idcours' => 'int'
	];

	protected $fillable = [
		'nom_mat'
	];

	public function cour()
	{
		return $this->belongsTo(Cour::class, 'cours_idcours');
	}

	public function encadreurs()
	{
		return $this->hasMany(Encadreur::class, 'matiere_idmatiere');
	}
}
