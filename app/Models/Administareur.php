<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administareur
 * 
 * @property int $idgestionnaires
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $date_Naissance
 * @property string|null $email
 * @property string|null $contact
 * @property string|null $password
 * @property string|null $cni
 * @property string|null $ville
 * @property string|null $commune_quatier
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $zone_supervision_idzone
 * @property int $id_users
 * 
 * @property ZoneSupervision $zone_supervision
 * @property Collection|Class[] $classes
 * @property Collection|Cour[] $cours
 * @property Collection|Elefe[] $eleves
 * @property Collection|Encadreur[] $encadreurs
 *
 * @package App\Models
 */
class Administareur extends Model
{
	protected $table = 'administareur';

	protected $casts = [
		'zone_supervision_idzone' => 'int',
		'id_users' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'date_Naissance',
		'email',
		'telephone',
		'password',
		'cni',
		'ville',
		'commune_quatier',
		'id_users'
	];

	public function zone_supervision()
	{
		return $this->belongsTo(ZoneSupervision::class, 'zone_supervision_idzone');
	}

	public function classes()
	{
		return $this->hasMany(Classe::class, 'administareur_idgestionnaires');
	}

	public function cours()
	{
		return $this->hasMany(Cour::class, 'administareur_idgestionnaires');
	}

	public function eleves()
	{
		return $this->hasMany(Eleve::class, 'administareur_idgestionnaires');
	}

	public function encadreurs()
	{
		return $this->hasMany(Encadreur::class, 'administareur_idgestionnaires');
	}
}
