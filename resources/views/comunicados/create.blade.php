@extends('layouts.main')

@section('title',  'Criar Comunicado')

@section('content')

<div id="comunicado-create-container" class="col-md-6 offset-md-3">
    <h1 class="text-center mb-4">Cadastro de Comunicado</h1>
    <form action="/comunicados" method="POST" enctype="multipart/form-data">
        @csrf

        @if(!empty($comunicado->image))
            <div class="form-group spacing">
                <img src="/img/comunicados/{{$comunicado->image ?? ''}}" alt="{{$comunicado->title}}">
            </div>   
        @endif   
        
        <input type="hidden" name="id" value="{{$comunicado->id ?? ''}}">

        <div class="form-group spacing">
            <label for="image">Imagem do comunicado:</label>
            <input type="file" id="image" name="image" class="arquivo">
        </div>
        <div class="form-group spacing">
            <label for="title">Título:</label>
            <input type="text" value="{{$comunicado->title ?? ''}}" class="form-control" id="title" name="title" required placeholder="Título da comunicado">
        </div>
        <div class="form-group spacing">
            <label for="date">Publicação:</label>
            <input type="date" value="{{ isset($comunicado->date) ? \Carbon\Carbon::parse($comunicado->date)->format('Y-m-d') : '' }}" class="form-control" id="date" name="date">
            
        </div>
        <div class="form-group spacing">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Descrição da comunicado">{{$comunicado->description ?? ''}}</textarea>
        </div>

        <div class="form-group spacing">
            <label for="status_id">Status:</label>
            <select class="form-control" name="status_id" id="status_id" requered >
                <option value="">Selecione o Status</option>
                <option value="1" {{ isset($comunicado) && $comunicado->status_id == 1 ? 'selected' : '' }}>Concluído</option>
                <option value="2" {{ isset($comunicado) && $comunicado->status_id == 2 ? 'selected' : '' }}>Em andamento</option>
                <option value="3" {{ isset($comunicado) && $comunicado->status_id == 3 ? 'selected' : '' }}>Pendente</option>
            </select>
        </div>

        <div class="form-group spacing">
            <input type="submit" class="btn btn-primary spacing bt-salvar" value="Salvar">
        </div>

    </form>
</div>

@endsection