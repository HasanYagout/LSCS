<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMedia extends Model
{
    protected $fillable = [
        'chat_id',
        'file',
    ];

    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function file_manager()
    {
        return $this->belongsTo(FileManager::class, 'file');
    }
}
