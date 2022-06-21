<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    /**
     * Set tablename.
     *
     */
    protected $table = 'sys_ms_jadwal_kuliah';
    /**
     * Set timestamps true for created_at and updated_at.
     *
     * @var array
     */
    protected $fillable = [
        'public_id', 'name','dosen_id', 'teach_date_from', 'teach_date_to', 'deadline_date','weekend_to','is_refleksi'
    ];

	public $timestamps = true;
}
