<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(<<<'SQL'
            CREATE OR REPLACE VIEW view_relatorio_livros_por_autor AS
                SELECT
                    (a.id::text || '-' || l.id::text)    AS id,
                    a.id                                 AS autor_id,
                    a.nome                               AS autor_nome,
                    l.id                                 AS livro_id,
                    l.titulo                             AS livro_titulo,
                    l.editora                            AS editora,
                    l.ano_publicacao                     AS ano_publicacao,
                    l.valor                              AS valor,
                    COALESCE(string_agg(DISTINCT s.descricao, ', ' ORDER BY s.descricao), '') AS assuntos
                FROM autores a
                    JOIN autor_livro al             ON al.autor_id = a.id
                    JOIN livros l                   ON l.id = al.livro_id
                    LEFT JOIN assunto_livro sl      ON sl.livro_id = l.id
                    LEFT JOIN assuntos s            ON s.id = sl.assunto_id
                GROUP BY a.id, a.nome, l.id, 
                    l.titulo, l.editora, l.ano_publicacao, l.valor
                ORDER BY a.nome, l.titulo;
        SQL);
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_relatorio_livros_por_autor;');
    }
};
