<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, Sortable, SearchableTrait;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'title',
        'description',
        'company',
        'created_at'
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

    /**
    * Searchable rules.
    *
    * @var array
    */
    protected $searchable = [
        /**
        * Columns and their priority in search results.
        * Columns with higher values are more important.
        * Columns with equal values have equal importance.
        *
        * @var array
        */
        'columns' => [
            'title' => 10,
            'description' => 5,
            'company' => 10,
            'created_at' => 10
        ]
    ];
}
