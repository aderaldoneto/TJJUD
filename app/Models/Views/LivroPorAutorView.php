<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Currency;

class LivroPorAutorView extends Model
{
    protected $table = 'view_relatorio_livros_por_autor';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $casts = [
        'valor'             => 'integer',
        'ano_publicacao'    => 'integer',
    ];

    protected $appends = ['valor_formatado'];

    public function getValorFormatadoAttribute(): string
    {
        return Currency::BRL->symbol() . number_format(($this->valor ?? 0) / 100, 2, ',', '.');
    }
}
