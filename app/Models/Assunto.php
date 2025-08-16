<?php

namespace App\Models;

use App\Observers\AssuntoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([AssuntoObserver::class])]
class Assunto extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class);
    }

}
