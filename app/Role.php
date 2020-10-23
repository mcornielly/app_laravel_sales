<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Spatie\Permission\Models\Permission;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Role extends Model
{
    use LaravelVueDatatableTrait, HasRoles;

        /**
    * The accessors to append to the model's array form.
    *
    * @var array
    */

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'display_name' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name'
    ];

    public function permissions()
    {
        return $this->belongsTo(Permission::class);
    }

}
