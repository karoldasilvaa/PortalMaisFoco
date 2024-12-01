<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comunicado;

use App\Models\User;

use App\Models\Status;

class ComunicadoController extends Controller
{
    // função para mostrar o conteudo na tela
    public function index() {
        // aqui é pra pegar os parâmetros da url
        $search = request('search');
        $status_id = request('status_id');
        $sort_date = request('sort_date');
        // aqui é pra quando o usuario tiver logado
        $user = auth()->user();   


        if($user != null){
            // função para ver se o usuario é administrador
            if($user->access == 1) {
                if ($status_id != null && $status_id > 0 ) {
                    // consultar pelo status_id
                    $comunicados = Comunicado::where([
                        ['status_id', $status_id]
                    ])->get();
                }
                // função para quando o usuario pesquisar a comunicado vai trazer comunicados relacionado com oque ele digitou
                elseif($search) {
                    $comunicados = Comunicado::where([
                        ['title', 'like', '%' .$search. '%']
                    ])->get();
                }else {
                    // se não pesquisar a comunicado vai mostrar todas
                    $comunicados = Comunicado::all();
                } 

            } else {
                // se o status_id não for null e maior que zero 
                if ($status_id != null && $status_id > 0 ) {
                    // consultar pelo status_id
                    $comunicados = Comunicado::where([                        
                        ['status_id', $status_id],
                        ['user_id', $user->id]
                    ])->get();
                }
                // se quando o pesquisar não for null
                elseif($search != null) {
                    // vai pesquisar pelo titulo
                    $comunicados = Comunicado::where([
                        ['title', 'like', '%' .$search. '%'],
                        ['user_id', $user->id]
                    ])->get();
                }else {
                    // senão vai trazer todas as comunicados de um usuario pelo id
                    $comunicados = Comunicado::where([
                        ['user_id', $user->id]
                    ])->get();
                } 
            }

            // se valor do select foi 1 vai entrar nessa função e ordenar as comunicados pelas datas em ordem decrescente
            if ($sort_date == 1) {
                $comunicados = $comunicados->sortByDesc('date');
            }elseif ($sort_date == 2){
            //  se o valor for 2 vai ordenar em ordem crescente
                $comunicados = $comunicados->sortBy('date');
            }
            else {
                // se o usuario não clicar no select de ordenar vai trazer em ordem decrescente por padrão
                $comunicados = $comunicados->sortByDesc('date');
            }

            foreach ($comunicados as $comunicado) {
                // aqui vai fazer um laço e preencher o usuário e o status
                $comunicado->user = User::where('id', $comunicado->user_id)->first();
                $comunicado->status = Status::where('id', $comunicado->status_id)->first();
            }


            return view('welcome', ['comunicados' => $comunicados, 'search' => $search]);
        } else {
            // se o usuario tiver desconectado vai ir pra view do login
            return redirect('/login');
        }        
    }

    // função para criar e editar a comunicados
    public function create($id = null) {

        // se o id for null irá criar uma nova comunicado
        if($id == null){            
            return view('comunicados.create');
        }

        // se o id não for null irá editar uma nova comunicado
        // aqui vai encontrar a comunicado
        $comunicado = Comunicado::findOrFail($id);
        
        // e retornar pra view create com a comunicado preenchida para o usuario pode editar
        return view('comunicados.create', ['comunicado' => $comunicado ]);
    }

    // função prara deletar comunicado pelo id da comunicado
    public function delete($id) {
        try {
            // encontrar a comunicado pelo id
            $comunicado = Comunicado::find($id);
            // deletar a comunicado
            $comunicado->delete();

            // retornar para a view principal e mostrar a mensagem 
            return redirect('/')->with('msg-success', 'Comunicado excluída com sucesso!');
        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao excluir comunicado. Favor tentar novamente mais tarde.');
        }
    }

    // função para salvar comunicado
    public function store(Request $request) {

        try {
            if($request->id > 0){
                // buscar a comunicado e se encontrar o usuario vai poder editar a comunicado
                $comunicado = Comunicado::findOrFail($request->id);
            } else {
                // senão vai criar uma nova comunicado
                $comunicado = new Comunicado;
            }
            
            $comunicado->title = $request->title;
            $comunicado->date = $request->date;
            $comunicado->description = $request->description;
            $comunicado->status_id = $request->status_id;

            // aqui vai verificar se o arquivo é valido 
            if($request->hasFile('image') && $request->file('image')->isValid()) {

                // obter a imagem
                $requestImage = $request->image;

                // obter a extensão png, jpg etc...
                $extension = $requestImage->extension();

                // criar um nome para imagem
                $imageName = md5($requestImage->getClientOriginalName() . Strtotime("now")) . "." . $extension;

                // colocar a imagem na pasta comunicados onde a imagem fica no servidor
                $request->image->move(public_path('img/comunicados'), $imageName);

                // atualiza o campo image no banco de dados
                $comunicado->image = $imageName;
            }

            // usuario logado
            $user = auth()->user();

            // a coluna user_id  recebe o id da tabela user
            $comunicado -> user_id = $user->id;

            $comunicado->save();

            // quando salvar retorna a view principal e mostra a mensagem na view
            return redirect('/')->with('msg-success', 'Comunicado criada com sucesso!');

        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao criar comunicado. Favor tentar novamente mais tarde.');
        }
    }
}
