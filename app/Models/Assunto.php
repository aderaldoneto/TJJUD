<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class);
    }

}
