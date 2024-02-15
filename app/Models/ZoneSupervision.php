<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ZoneSupervision
 * 
 * @property int $idzone_supervision
 * @property string|null $ville
 * @property string|null $commune_quartier
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Administareur[] $administareurs
 *
 * @package App\Models
 */
class ZoneSupervision extends Model
{
	protected $table = 'zone_supervision';
	protected $primaryKey = 'idzone_supervision';

	protected $fillable = [
		'ville',
		'commune_quartier'
	];

	public function administareurs()
	{
		return $this->hasMany(Administareur::class, 'zone_supervision_idzone');
	}
}
