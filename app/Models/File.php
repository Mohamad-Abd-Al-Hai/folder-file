<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_folder_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
