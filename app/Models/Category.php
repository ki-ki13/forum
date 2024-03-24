<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table ='tbl_category';
    protected $fillable = [
        'id',
        'c_nama',
        'c_created_by'
    ];
    
    public function forum()
    {
        return $this->belongsToMany(ForumQuestion::class, 'tbl_forum_category', 'fc_forum_id', 'fc_category_id');
    }
}
