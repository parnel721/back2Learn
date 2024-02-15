<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Class
 * 
 * @property int $idclasses
 * @property string|null $nom
 * @property string|null $Lieu
 * @property string|null $commune_quartier
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $cours_idcours
 * @property int $administareur_idgestionnaires
 * 
 * @property Administareur $administareur
 * @property Cour $cour
 *
 * @package App\Models
 */
class Classe extends Model
{
	protected $table = 'classes';

	protected $casts = [
		'cours_idcours' => 'int',
		'administareur_idgestionnaires' => 'int'
	];

	protected $fillable = [
		'nom',
		'Lieu',
		'commune_quartier',
		'administareur_idgestionnaires'
	];

	public function administareur()
	{
		return $this->belongsTo(Administareur::class, 'administareur_idgestionnaires');
	}

	public function cour()
	{
		return $this->belongsTo(Cour::class, 'cours_idcours');
	}
}
