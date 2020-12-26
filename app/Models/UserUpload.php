<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'caption',
    ];

    public function users() {
        return $this->belongsTo(UserUpload::class);
    }

    public function toArray()
    {
        return [
            'id'     => $this->id,
            'path'   => $this->name,
        ];
    }
}
