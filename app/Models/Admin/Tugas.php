<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    /**
     * Set tablename.
     *
     */
    protected $table = 'sys_tr_tugas';
    /**
     * Set timestamps true for created_at and updated_at.
     *
     * @var array
     */

	public $timestamps = true;
}
