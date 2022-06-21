<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class MicroLearning extends Model
{
    /**
     * Set tablename.
     *
     */
    protected $table = 'sys_ms_jadwal_ml';
    /**
     * Set timestamps true for created_at and updated_at.
     *
     * @var array
     */
    protected $fillable = [
        'public_id', 'name', 'teach_date_from', 'teach_date_to', 'deadline_date','soal'
    ];

	public $timestamps = true;
}
