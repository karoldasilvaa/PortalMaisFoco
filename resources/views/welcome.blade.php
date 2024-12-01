@extends('layouts.main')

@section('title', 'Comunicados - Cadastro e consulta de comunicados')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque um Comunicado</h1>
    <form action="/" method="GET">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Buscar..." />
            <div class="input-group-append">
                <input class="btn btn-primary" type="submit" value="Buscar">
            </div>
        </div>
    </form>
</div>

<div id="comunicados-container" class="col-md-12">
    <div class="row">
        <div class="col-6">
            @if($search)
                <h2>Buscando por: {{ $search }}</h2>
            @else
                <h2>Próximos Comunicados</h2>
            @endif

            @if (count($comunicados) > 0)
                <p class="subtitle">Veja os comunicados dos próximos dias</p>
            @endif
        </div>    
        <div class="col-3">
            <form action="/" method="GET">
                <label for="sort_date">Ordenação:</label>
                <select class="form-control" name="sort_date" id="sort_date" onchange="this.form.submit()">
                    <option value="1" {{ request('sort_date') == 1 ? 'selected' : '' }}>Mais Recente</option>
                    <option value="2" {{ request('sort_date') == 2 ? 'selected' : '' }}>Mais Antigo</option>
                </select>
            </form>
        </div>  
        
        <div class="col-3">
            <form action="/" method="GET">
                <label for="status">Status:</label>
                <select class="form-control" name="status_id" id="status_id" onchange="this.form.submit()">
                    <option value="0" {{ request('status_id') == 0 ? 'selected' : '' }}>Todos</option>
                    <option value="1" {{ request('status_id') == 1 ? 'selected' : '' }}>Concluído</option>
                    <option value="2" {{ request('status_id') == 2 ? 'selected' : '' }}>Em andamento</option>
                    <option value="3" {{ request('status_id') == 3 ? 'selected' : '' }}>Pendente</option>
                </select>
            </form> 
        </div>          
    </div>  

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Publicação</th>
                <th>Criado por</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comunicados as $comunicado)
                <tr>
                    <td><img src="/img/comunicados/{{$comunicado->image}}" alt="{{$comunicado->title}}" width="100"></td>
                    <td>{{ $comunicado->title }}</td>
                    <td>{{ $comunicado->description }}</td>
                    <td>{{ $comunicado->date->format('d/m/Y') }}</td>
                    <td>{{ $comunicado->user->name }}</td>
                    <td>{{ $comunicado->status->name }}</td>
                    <td>
                        <a href="/comunicados/create/{{$comunicado->id}}" class="btn btn-primary">Editar</a>
                        <form action="/comunicados/{{$comunicado->id}}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este comunicado?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($comunicados) == 0 && $search)
        <p>Não foi possível encontrar nenhum comunicado com "{{ $search }}"! <a href="/">Ver todos</a></p>
    @elseif (count($comunicados) == 0)
        <p>Não há comunicados disponíveis</p>
    @endif
</div>

@endsection
