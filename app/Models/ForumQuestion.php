<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumQuestion extends Model
{
    use HasFactory;

    protected $table = 'tbl_forum_question';
    protected $fillable = [
        'id',
        'fq_category_id',
        'fq_question',
        'fq_created_by',
        'fq_updated_by',
        'fq_group_id'
    ];

    public function forum_detail(): HasMany
    {
        return $this->hasMany(ForumDetail::class);
    }
    public function forum_group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'fd_group_id');
    }
    public function forum_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fd_created_by');
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'tbl_forum_category', 'fc_forum_id', 'fc_category_id');
    }
}
