<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumDetail extends Model
{
    use HasFactory;

    protected $table ='tbl_forum_detail';
    protected $fillable = [
        'id',
        'fd_forum_id',
        'fd_detail',
        'fd_user_id',
    ];

    public function forum(): BelongsTo
    {
        return $this->belongsTo(ForumQuestion::class, 'fd_forum_id');
    }

}
