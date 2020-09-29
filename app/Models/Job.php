<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, Sortable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'title',
        'description',
        'company',
        'reference'
    ];

    /**
    * The attributes that are available for eloquoent sorting.
    *
    * @var array
    */
    public $sortable = [
        'id', 
        'title', 
        'company', 
        'created_at'
    ];
}
