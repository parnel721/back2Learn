<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Elefe
 * 
 * @property int $ideleves
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $date_naissance
 * @property string|null $Telephone
 * @property string|null $email
 * @property string|null $password
 * @property string|null $niveau
 * @property string|null $serie
 * @property string|null $nom_parent
 * @property string|null $contact_parent
 * @property string|null $emploi_du_temps
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $administareur_idgestionnaires
 * @property int $factures_idfactures
 * @property int $id_users
 * 
 * @property Administareur $administareur
 * @property Facture $facture
 * @property Collection|Cour[] $cours
 *
 * @package App\Models
 */
class Eleve extends Model
{
	protected $table = 'eleves';

	protected $casts = [
		'administareur_idgestionnaires' => 'int',
		'factures_idfactures' => 'int',
		'id_users' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'date_naissance',
		'Telephone',
		'email',
		'password',
		'niveau',
		'serie',
		'nom_parent',
		'contact_parent',
		'emploi_du_temps',
		'id_users'
	];

	public function administareur()
	{
		return $this->belongsTo(Administareur::class, 'administareur_idgestionnaires');
	}

	public function facture()
	{
		return $this->belongsTo(Facture::class, 'factures_idfactures');
	}

	public function cours()
	{
		return $this->hasMany(Cour::class, 'eleves_ideleves');
	}
}
