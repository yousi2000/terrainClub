<?php

namespace App\Models;

use App\Policies\ReservationPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $table = 'clients';
    public $timestamps=false;
    protected $fillable = ['Prenom', 'Nom', 'Email', 'Tel'];
 /*   protected $fillable = [
        'Prenom',
        'Nom',
        'Email',
        'Tel',
        
    ];
    public function reservation()
{
    return $this->hasMany(Reservation::class);

}*/

}
