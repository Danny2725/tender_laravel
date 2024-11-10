<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteModel extends Model
{
    use HasFactory;

    protected $table = 'invites';
    protected $primaryKey = 'id';

    protected $fillable = ['tender_id', 'supplier_email'];

    public function tender()
    {
        return $this->belongsTo(TenderModel::class, 'tender_id');
    }
}