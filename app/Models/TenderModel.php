<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderModel extends Model
{
    use HasFactory;

    protected $table = 'tenders';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'visibility', 'creator_id'];

    public function invites()
    {
        return $this->hasMany(InviteModel::class, 'tender_id');
    }
}