<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'data',
        'sender_id',
        'read_at'
    ];

    private function getData()
    {
        return json_decode($this->data, true);
    }

    public function content()
    {
        return $this->getData()['content'];
    }

    public function title()
    {
        return $this->getData()['title'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
