<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Facture
 * 
 * @property int $idfactures
 * @property string|null $numero_fact
 * @property string|null $description_fact
 * @property string|null $niveau
 * @property string|null $serie
 * @property string|null $MontantFact
 * @property Carbon|null $date_fact
 * @property string|null $payement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Eleve[] $eleves
 *
 * @package App\Models
 */
class Facture extends Model
{
	protected $table = 'factures';
	protected $primaryKey = 'idfactures';

	protected $casts = [
		'date_fact' => 'datetime'
	];

	protected $fillable = [
		'numero_fact',
		'description_fact',
		'niveau',
		'serie',
		'MontantFact',
		'date_fact',
		'payement'
	];

	public function eleves()
	{
		return $this->hasMany(Eleve::class, 'factures_idfactures');
	}
}
