<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /** @use HasFactory<\Database\Factories\FolderFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_folder_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'parent_folder_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'parent_folder_id');
    }
}
