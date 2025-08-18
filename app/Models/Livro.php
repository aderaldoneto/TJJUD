<?php

namespace App\Models;

use App\Observers\LivroObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LivroObserver::class])]
class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'ano_publicacao',
        'valor',
    ];

    protected $casts = [
        'edicao' => 'integer',
        'valor'  => 'integer',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class);
    }

    public function getValorFormatadoAttribute(): string
    {
        return number_format($this->valor / 100, 2, ',', '.');
    }

    public function setValorFormatadoAttribute($value)
    {
        $this->attributes['valor'] = (int) round($value * 100);
    }


}
