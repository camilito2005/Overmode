@extends('layouts.menu')
@section('titulo', 'Opiniones')

@section('contenido')
    @if (session('mensaje'))
        @include('layouts.alertas', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif
<h4>Opiniones</h4>

@foreach($opinionesVisible as $opinion)
    <div class="card mb-2">
        <div class="card-body">
            <p class="mb-1"><strong>{{ $opinion->usuario_nombre ?? 'Usuario anónimo' }}</strong></p>
            <p class="mb-0">{{ $opinion->contenido }}</p>
        </div>
    </div>
@endforeach

@if($opiniones->count() > 3)
    <button class="btn btn-link p-0 mb-3" id="verTodasBtn">Ver todas las opiniones</button>

    <div id="todasOpiniones" class="d-none">
        @foreach($opiniones->slice(3) as $opinion)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $opinion->usuario_nombre ?? 'Usuario anónimo' }}</strong></p>
                    <p class="mb-0">{{ $opinion->contenido }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif

@push('js')
<script>
    document.getElementById('verTodasBtn')?.addEventListener('click', function () {
        const seccion = document.getElementById('todasOpiniones');
        seccion.classList.toggle('d-none');
        this.innerText = seccion.classList.contains('d-none') 
            ? 'Ver todas las opiniones' 
            : 'Ocultar opiniones';
    });
</script>
@endpush
@endsection
