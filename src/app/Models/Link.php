<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'hash'];


    public function isExpired(): bool
    {
        return $this->created_at->diffInDays(now()) > 7;
    }
}
