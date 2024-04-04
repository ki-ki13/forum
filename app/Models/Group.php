<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;
    protected $table = 'tbl_group';
    protected $fillable = [
        'id',
        'g_nama',
        'g_tipe',
        'g_status',
        'g_created_by'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function forum_question(): HasMany
    {
        return $this->hasMany(ForumQuestion::class);
    }
}
