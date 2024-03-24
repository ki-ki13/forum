<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;
    protected $table = 'tbl_forum_category';
    protected $fillable = [
        'id',
        'fc_forum_id',
        'fc_category_id'
    ];
}
