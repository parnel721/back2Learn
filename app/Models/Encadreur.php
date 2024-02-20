<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Encadreur
 * 
 * @property int $idencadreurs
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $date_naissance
 * @property string|null $email
 * @property string|null $password
 * @property string|null $profession
 * @property string|null $diplome
 * @property string|null $cni
 * @property string|null $ville
 * @property string|null $encadreurscol
 * @property string|null $commune_quatier
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $matiere_idmatiere
 * @property int $administareur_idgestionnaires
 * @property int $id_users
 * 
 * @property Administareur $administareur
 * @property Matiere $matiere
 *
 * @package App\Models
 */
class Encadreur extends Model
{
	protected $table = 'encadreurs';

	protected $casts = [
		'matiere_idmatiere' => 'int',
		'administareur_idgestionnaires' => 'int',
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
		'profession',
		'diplome',
		'cni',
		'ville',
		'encadreurscol',
		'commune_quatier',
		'id_users'
	];

	public function administareur()
	{
		return $this->belongsTo(Administareur::class, 'administareur_idgestionnaires');
	}

	public function matiere()
	{
		return $this->belongsTo(Matiere::class, 'matiere_idmatiere');
	}
}
