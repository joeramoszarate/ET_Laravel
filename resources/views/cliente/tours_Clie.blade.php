@extends('cliente.layout_clie')

@section('title', 'Tours - Explora Tumbes')

@section('content')
<style>
    .tours-page { background:#eef0f5; min-height:100vh; padding:40px 20px; }
    .tours-inner { max-width:1100px; margin:0 auto; }
    .tours-header { text-align:center; margin-bottom:32px; }
    .tours-header h1 { font-size:2rem; font-weight:800; color:#1a3c6e; margin:0 0 6px; }
    .tours-header p  { color:#888; font-size:0.95rem; margin:0; }
    .tours-layout { display:grid; grid-template-columns:230px 1fr; gap:24px; align-items:start; }

    /* Sidebar */
    .sidebar { background:#fff; border-radius:14px; padding:22px; box-shadow:0 2px 10px rgba(0,0,0,0.07); position:sticky; top:20px; }
    .sidebar-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .sidebar-head span { font-weight:700; font-size:1rem; color:#1a3c6e; }
    .sidebar-head a { color:#2563eb; font-size:0.82rem; text-decoration:none; }
    .filter-label { font-weight:600; color:#333; font-size:0.88rem; margin:0 0 10px; }
    .filter-section { margin-bottom:20px; }
    .price-labels { display:flex; justify-content:space-between; margin-top:8px; }
    .price-badge { background:#e8f0fe; color:#2563eb; padding:2px 10px; border-radius:6px; font-size:0.8rem; font-weight:600; }
    .check-label { display:flex; align-items:center; gap:8px; margin-bottom:9px; cursor:pointer; font-size:0.86rem; color:#444; }
    .check-label input { width:15px; height:15px; accent-color:#2563eb; border-radius:3px; }
    input[type=range] { width:100%; accent-color:#2563eb; }

    /* Contenido */
    .content-top { display:flex; justify-content:flex-end; align-items:center; gap:10px; margin-bottom:18px; }
    .order-label { color:#555; font-size:0.88rem; }
    .order-select { border:1px solid #ddd; border-radius:8px; padding:7px 14px; font-size:0.88rem; color:#333; background:#fff; cursor:pointer; outline:none; }

    /* Grid cards */
    .cards-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .tour-card { background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.07); transition:transform .2s, box-shadow .2s; }
    .tour-card:hover { transform:translateY(-5px); box-shadow:0 10px 28px rgba(0,0,0,0.13); }
    .card-img-wrap { position:relative; height:200px; overflow:hidden; }
    .card-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .3s; }
    .tour-card:hover .card-img-wrap img { transform:scale(1.05); }
    .card-badges { position:absolute; top:10px; left:10px; display:flex; gap:6px; flex-wrap:wrap; }
    .badge { font-size:0.7rem; font-weight:700; padding:4px 10px; border-radius:20px; color:#fff; }
    .badge-orange { background:#f59e0b; }
    .badge-green  { background:#16a34a; }
    .badge-blue   { background:#2563eb; }
    .card-price { position:absolute; bottom:10px; right:10px; background:rgba(255,255,255,0.95); color:#1a3c6e; font-weight:800; font-size:1rem; padding:5px 12px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.15); }
    .card-body { padding:18px; }
    .card-title { font-size:1.05rem; font-weight:700; color:#1a1a1a; margin:0 0 10px; }
    .card-location { display:flex; align-items:center; gap:5px; margin-bottom:7px; }
    .card-location span { color:#2563eb; font-size:0.84rem; }
    .card-desc { color:#666; font-size:0.84rem; line-height:1.45; margin:0 0 14px; }
    .card-footer { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
    .stars { display:flex; align-items:center; gap:2px; }
    .star-on  { color:#f59e0b; font-size:0.9rem; }
    .star-off { color:#ddd;    font-size:0.9rem; }
    .reviews  { color:#888; font-size:0.78rem; margin-left:4px; }
    .dur-badge { display:flex; align-items:center; gap:4px; background:#fef3c7; padding:4px 12px; border-radius:20px; }
    .dur-badge span { font-size:0.8rem; color:#92400e; font-weight:600; }
    .btn-detail { display:block; text-align:center; background:#1e3a5f; color:#fff; padding:12px; border-radius:9px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:background .2s; }
    .btn-detail:hover { background:#2563eb; color:#fff; }

    /* Empty */
    .empty-box { text-align:center; padding:60px 20px; background:#fff; border-radius:14px; grid-column:1/-1; }

    /* Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; padding:20px; }
    .modal-box { background:#fff; border-radius:16px; max-width:580px; width:100%; max-height:90vh; overflow-y:auto; position:relative; }
    .modal-img { width:100%; height:230px; object-fit:cover; border-radius:16px 16px 0 0; }
    .modal-body { padding:24px; }
    .modal-close { position:absolute; top:12px; right:16px; background:rgba(0,0,0,0.4); border:none; color:#fff; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:1rem; display:flex; align-items:center; justify-content:center; }
    .modal-title { font-size:1.35rem; font-weight:700; color:#1a3c6e; margin:0 0 6px; }
    .modal-price { font-size:1.5rem; font-weight:800; color:#2563eb; }
    .modal-tags { display:flex; gap:8px; flex-wrap:wrap; margin:12px 0; }
    .modal-tag { padding:4px 12px; border-radius:20px; font-size:0.82rem; font-weight:600; }
    .modal-desc { color:#555; line-height:1.65; margin-bottom:20px; font-size:0.9rem; }
    .modal-actions { display:flex; gap:12px; }
    .btn-reservar { flex:1; text-align:center; background:#1e3a5f; color:#fff; padding:12px; border-radius:9px; text-decoration:none; font-weight:600; font-size:0.9rem; }
    .btn-cerrar { flex:1; background:#f3f4f6; color:#333; padding:12px; border-radius:9px; border:none; cursor:pointer; font-weight:600; font-size:0.9rem; }

    @media(max-width:900px) {
        .tours-layout { grid-template-columns:1fr; }
        .sidebar { position:static; }
    }
    @media(max-width:600px) {
        .cards-grid { grid-template-columns:1fr; }
    }
</style>

<div class="tours-page">
<div class="tours-inner">

    {{-- Header --}}
    <div class="tours-header">
        <h1>Explora Nuestros Tours</h1>
        <p>{{ $total }} tour{{ $total != 1 ? 's' : '' }} disponible{{ $total != 1 ? 's' : '' }}</p>
    </div>

    <div class="tours-layout">

        {{-- ===== SIDEBAR ===== --}}
        <form method="GET" action="{{ route('cliente.tours') }}" id="filtroForm">
        <div class="sidebar">
            <div class="sidebar-head">
                <span>Filtros</span>
                <a href="{{ route('cliente.tours') }}">Limpiar todo</a>
            </div>

            {{-- Precio --}}
            <div class="filter-section">
                <p class="filter-label">Rango de Precio</p>
                <input type="range" name="precio_max" id="rangoPrec" min="0" max="500"
                       value="{{ $precioMax }}"
                       oninput="document.getElementById('lblPrec').textContent='$'+this.value"
                       onchange="this.form.submit()">
                <div class="price-labels">
                    <span class="price-badge">$0</span>
                    <span class="price-badge" id="lblPrec">${{ $precioMax }}</span>
                </div>
            </div>

            {{-- Duración --}}
            <div class="filter-section">
                <p class="filter-label">Duración</p>
                @foreach([1=>'1 día', 2=>'2 días', 3=>'3 días'] as $d => $lbl)
                <label class="check-label">
                    <input type="checkbox" name="duracion[]" value="{{ $d }}"
                           {{ in_array($d, request('duracion',[])) ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    {{ $lbl }}
                </label>
                @endforeach
            </div>

            {{-- Categorías --}}
            <div class="filter-section">
                <p class="filter-label">Tipo de Actividad</p>
                @foreach($categorias as $cat)
                <label class="check-label">
                    <input type="checkbox" name="categorias[]" value="{{ $cat->id_catto }}"
                           {{ in_array($cat->id_catto, request('categorias',[])) ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    {{ $cat->descripcion }}
                </label>
                @endforeach
            </div>
        </div>
        </form>

        {{-- ===== CONTENIDO ===== --}}
        <div>
            {{-- Ordenar --}}
            <div class="content-top">
                <span class="order-label">Ordenar por:</span>
                <form method="GET" action="{{ route('cliente.tours') }}">
                    @foreach(request()->except('orden') as $k => $v)
                        @if(is_array($v))
                            @foreach($v as $item)<input type="hidden" name="{{ $k }}[]" value="{{ $item }}">@endforeach
                        @else
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach
                    <select name="orden" class="order-select" onchange="this.form.submit()">
                        <option value="popular"     {{ $orden=='popular'     ? 'selected':'' }}>Más Popular</option>
                        <option value="precio_asc"  {{ $orden=='precio_asc'  ? 'selected':'' }}>Menor Precio</option>
                        <option value="precio_desc" {{ $orden=='precio_desc' ? 'selected':'' }}>Mayor Precio</option>
                        <option value="duracion"    {{ $orden=='duracion'    ? 'selected':'' }}>Duración</option>
                    </select>
                </form>
            </div>

            {{-- Cards --}}
            <div class="cards-grid">
            @forelse($tours as $tour)
            @php
                $imgDefault = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80';
                $badges = [];
                if($tour->precio >= 100) $badges[] = ['Más vendido','badge-orange'];
                if($tour->duracion_dias == 1) $badges[] = ['Últimas cupos','badge-orange'];
                if($tour->precio <= 90)  $badges[] = ['Eco-turismo','badge-green'];
                if($tour->duracion_dias >= 3) $badges[] = ['Aventura extrema','badge-blue'];
                $rating  = min(5, max(3, 3.5 + (crc32($tour->id_tour) % 15)/10));
                $reviews = 50 + (crc32($tour->id_tour) % 200);
            @endphp
            <div class="tour-card">
                <div class="card-img-wrap">
                    <img src="{{ $tour->imagen_url ?: $imgDefault }}" alt="{{ $tour->nombre_tour }}"
                         onerror="this.src='{{ $imgDefault }}'">
                    <div class="card-badges">
                        @foreach(array_slice($badges,0,2) as $b)
                        <span class="badge {{ $b[1] }}">{{ $b[0] }}</span>
                        @endforeach
                    </div>
                    <div class="card-price">${{ number_format($tour->precio,0) }}</div>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $tour->nombre_tour }}</h3>
                    <div class="card-location">
                        <span>📍</span>
                        <span>{{ $tour->ubicacion_exacta ?: ($tour->destino ? $tour->destino->nombre.', Tumbes' : '—') }}</span>
                    </div>
                    <p class="card-desc">{{ Str::limit($tour->descripcion, 65) }}</p>
                    <div class="card-footer">
                        <div class="stars">
                            @for($i=1;$i<=5;$i++)
                                <span class="{{ $i <= round($rating) ? 'star-on' : 'star-off' }}">★</span>
                            @endfor
                            <span class="reviews">({{ $reviews }})</span>
                        </div>
                        <div class="dur-badge">
                            <span>📅</span>
                            <span>{{ $tour->duracion_dias }} día{{ $tour->duracion_dias>1?'s':'' }}</span>
                        </div>
                    </div>
                    <a href="#" class="btn-detail" onclick="abrirModal('{{ $tour->id_tour }}'); return false;">
                        Ver Detalles →
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-box">
                <div style="font-size:3rem;margin-bottom:12px;">🔍</div>
                <p style="color:#666;">No se encontraron tours con los filtros seleccionados.</p>
                <a href="{{ route('cliente.tours') }}" style="color:#2563eb;font-size:0.9rem;">Limpiar filtros</a>
            </div>
            @endforelse
            </div>
        </div>
    </div>
</div>
</div>

{{-- ===== MODAL ===== --}}
<div class="modal-overlay" id="tourModal">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal()">✕</button>
        <img id="mImg" src="" alt="" class="modal-img">
        <div class="modal-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
                <h2 class="modal-title" id="mNombre"></h2>
                <span class="modal-price" id="mPrecio"></span>
            </div>
            <div class="modal-tags">
                <span id="mUbicacion" style="background:#e8f0fe;color:#2563eb;" class="modal-tag">📍</span>
                <span id="mDuracion"  style="background:#fef3c7;color:#92400e;" class="modal-tag">📅</span>
                <span id="mCategoria" style="background:#dcfce7;color:#166534;" class="modal-tag"></span>
            </div>
            <p class="modal-desc" id="mDesc"></p>
            <div class="modal-actions">
                @if(session('cliente_id'))
                  <a href="#" id="btnReservaNow" class="btn-reservar">🎒 Reservar Ahora</a>
                @else
                  <a href="{{ route('cliente.login') }}" class="btn-reservar">🎒 Iniciar Sesión para Reservar</a>
                @endif
                <button class="btn-cerrar" onclick="cerrarModal()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
const toursData = {
    @foreach($tours as $tour)
    "{{ $tour->id_tour }}": {
        nombre:    "{{ addslashes($tour->nombre_tour) }}",
        precio:    "${{ number_format($tour->precio,0) }}",
        desc:      "{{ addslashes($tour->descripcion) }}",
        ubicacion: "{{ addslashes($tour->ubicacion_exacta ?: ($tour->destino ? $tour->destino->nombre.', Tumbes' : '')) }}",
        duracion:  "{{ $tour->duracion_dias }} día{{ $tour->duracion_dias>1?'s':'' }}",
        categoria: "{{ addslashes($tour->categoria ? $tour->categoria->descripcion : '') }}",
        imagen:    "{{ $tour->imagen_url ?: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80' }}"
    },
    @endforeach
};

let tourActualId = null;

function abrirModal(id) {
    const t = toursData[id]; if(!t) return;
    tourActualId = id;
    document.getElementById('mImg').src          = t.imagen;
    document.getElementById('mImg').alt          = t.nombre;
    document.getElementById('mNombre').textContent   = t.nombre;
    document.getElementById('mPrecio').textContent   = t.precio;
    document.getElementById('mDesc').textContent     = t.desc;
    document.getElementById('mUbicacion').textContent= '📍 '+t.ubicacion;
    document.getElementById('mDuracion').textContent = '📅 '+t.duracion;
    document.getElementById('mCategoria').textContent= t.categoria;
    const m = document.getElementById('tourModal');
    m.style.display='flex'; document.body.style.overflow='hidden';
}

function cerrarModal() {
    document.getElementById('tourModal').style.display='none';
    document.body.style.overflow='';
    tourActualId = null;
}

@if(session('cliente_id'))
    const reservaUrlTemplate = "{{ route('cliente.tours.reserva', ['id_tour' => 'ID_PLACEHOLDER']) }}";
    document.getElementById('btnReservaNow').addEventListener('click', function(e) {
    e.preventDefault();
    if (tourActualId) {
        window.location.href = reservaUrlTemplate.replace('ID_PLACEHOLDER', tourActualId);
    }
});
@endif

document.getElementById('tourModal').addEventListener('click', e => { if(e.target===e.currentTarget) cerrarModal(); });
</script>
@endsection
