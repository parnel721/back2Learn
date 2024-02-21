<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cour
 * 
 * @property int $idcours
 * @property string|null $type_cours
 * @property string|null $prix_cours
 * @property string|null $emploi_du_temps
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $eleves_ideleves
 * @property int $administareur_idgestionnaires
 * 
 * @property Administareur $administareur
 * @property Elefe $elefe
 * @property Collection|Class[] $classes
 * @property Collection|Matiere[] $matieres
 *
 * @package App\Models
 */
class Cour extends Model
{
	protected $table = 'cours';

	protected $casts = [
		'eleves_ideleves' => 'int',
		'administareur_idgestionnaires' => 'int'
	];

	protected $fillable = [
		'type_cours',
		'prix_cours',
		'emploi_du_temps'
	];

	public function administareur()
	{
		return $this->belongsTo(Administareur::class, 'administareur_idgestionnaires');
	}

	public function eleve()
	{
		return $this->belongsTo(Eleve::class, 'eleves_ideleves');
	}

	public function classes()
	{
		return $this->hasMany(Classe::class, 'cours_idcours');
	}

	public function matieres()
	{
		return $this->hasMany(Matiere::class, 'cours_idcours');
	}
}
