<?php 

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Exibir o formulário
    public function create()
    {
        return view('form');
    }

    // Processar o envio do formulário
    public function store(Request $request)
    {
        // Validação dos dados (opcional)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Aqui você pode salvar os dados no banco ou fazer outra lógica
        Article::create($validated);

        return redirect()->back()->with('success', 'Dados enviados com sucesso!');
    }
}
