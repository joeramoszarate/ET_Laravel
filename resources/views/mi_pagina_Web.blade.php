<x-app-layout>
<x-slot name="header">Mi Página Web</x-slot>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<style>
.web-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
.web-tab{padding:8px 18px;border-radius:8px;border:1.5px solid #e8ecf4;background:#fff;cursor:pointer;font-size:0.85rem;font-weight:600;color:#64748b;transition:all .2s}
.web-tab.active{background:#3b5bdb;color:#fff;border-color:#3b5bdb}
.web-section{display:none}
.web-section.active{display:block}
.sec-card{background:#fff;border:1px solid #e8ecf4;border-radius:12px;padding:24px;margin-bottom:20px}
.sec-title{font-size:1rem;font-weight:700;color:#1a1f2e;margin:0 0 18px;padding-bottom:10px;border-bottom:1px solid #e8ecf4;display:flex;align-items:center;gap:8px}
.sec-title i{color:#3b5bdb}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.fg{margin-bottom:14px}
.fg label{display:block;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px}
.fg input[type=text],.fg input[type=url],.fg textarea{width:100%;border:1.5px solid #dde3f0;border-radius:8px;padding:9px 12px;font-size:0.88rem;color:#1a1f2e;background:#f8f9fc;outline:none;transition:border .2s}
.fg input:focus,.fg textarea:focus{border-color:#3b5bdb;background:#fff}
.fg textarea{resize:vertical;min-height:90px}
.img-wrap{position:relative;border:2px dashed #dde3f0;border-radius:10px;overflow:hidden;background:#f8f9fc;cursor:pointer;transition:border .2s}
.img-wrap:hover{border-color:#3b5bdb}
.img-wrap img{width:100%;height:170px;object-fit:cover;display:block}
.img-wrap.logo-h img{height:110px;object-fit:contain;padding:14px}
.img-overlay{position:absolute;inset:0;background:rgba(59,91,219,.55);display:flex;flex-direction:column;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;color:#fff;font-size:0.82rem;font-weight:600;gap:6px}
.img-wrap:hover .img-overlay{opacity:1}
.img-overlay i{font-size:1.4rem}
.img-wrap input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer}
.color-row{display:flex;align-items:center;gap:10px}
.color-row input[type=color]{width:44px;height:36px;padding:2px;border-radius:6px;cursor:pointer;border:1.5px solid #dde3f0}
.color-row input[type=text]{flex:1;border:1.5px solid #dde3f0;border-radius:8px;padding:9px 12px;font-size:0.88rem;background:#f8f9fc;outline:none}
.btn-save{background:#3b5bdb;color:#fff;border:none;border-radius:8px;padding:11px 28px;font-size:0.9rem;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:background .2s}
.btn-save:hover{background:#2f4ac4}
</style>

<div class="web-tabs">
    <button class="web-tab active" onclick="switchTab('identidad',this)"><i class="fas fa-store mr-1"></i> Identidad</button>
    <button class="web-tab" onclick="switchTab('hero',this)"><i class="fas fa-image mr-1"></i> Hero / Portada</button>
    <button class="web-tab" onclick="switchTab('banners',this)"><i class="fas fa-bullhorn mr-1"></i> Banners</button>
    <button class="web-tab" onclick="switchTab('nosotros',this)"><i class="fas fa-info-circle mr-1"></i> Nosotros</button>
    <button class="web-tab" onclick="switchTab('colores',this)"><i class="fas fa-palette mr-1"></i> Colores y Redes</button>
</div>

<form method="POST" action="{{ route('mipagina.update') }}" enctype="multipart/form-data">
@csrf

{{-- IDENTIDAD --}}
<div class="web-section active" id="tab-identidad">
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-id-card"></i> Logo y Marca</p>
        <div class="grid2">
            <div class="fg">
                <label>Logo — clic para cambiar</label>
                <div class="img-wrap logo-h" onclick="this.querySelector('input').click()">
                    <img id="prev-logo" src="{{ $config->logo_url ?: 'https://via.placeholder.com/300x100?text=Logo' }}" alt="Logo">
                    <div class="img-overlay"><i class="fas fa-upload"></i> Subir logo</div>
                    <input type="file" name="logo" accept="image/*" onchange="previewImg(this,'prev-logo')">
                </div>
            </div>
            <div>
                <div class="fg">
                    <label>Nombre de la empresa</label>
                    <input type="text" name="nombre_empresa" value="{{ $config->nombre_empresa ?? 'Explore Tu Tumbes' }}">
                </div>
                <div class="fg">
                    <label>Slogan</label>
                    <input type="text" name="slogan" value="{{ $config->slogan ?? '' }}" placeholder="Descubre el paraíso del norte...">
                </div>
                <div class="fg">
                    <label>WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ $config->whatsapp ?? '' }}" placeholder="+51 999 999 999">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- HERO --}}
<div class="web-section" id="tab-hero">
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-image"></i> Imagen y Texto Principal</p>
        <div class="grid2">
            <div class="fg">
                <label>Imagen de fondo</label>
                <div class="img-wrap" onclick="this.querySelector('input').click()">
                    <img id="prev-hero" src="{{ $config->hero_imagen_url ?: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80' }}" alt="Hero">
                    <div class="img-overlay"><i class="fas fa-upload"></i> Cambiar imagen</div>
                    <input type="file" name="hero_imagen" accept="image/*" onchange="previewImg(this,'prev-hero')">
                </div>
            </div>
            <div>
                <div class="fg">
                    <label>Título principal</label>
                    <input type="text" name="hero_titulo" value="{{ $config->hero_titulo ?? 'Descubre Tumbes' }}">
                </div>
                <div class="fg">
                    <label>Subtítulo</label>
                    <textarea name="hero_subtitulo">{{ $config->hero_subtitulo ?? 'El destino de playa más hermoso del Perú te espera' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BANNERS --}}
<div class="web-section" id="tab-banners">
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-ad"></i> Banner Promocional 1</p>
        <div class="grid2">
            <div class="fg">
                <label>Imagen</label>
                <div class="img-wrap" onclick="this.querySelector('input').click()">
                    <img id="prev-b1" src="{{ $config->banner1_imagen ?: 'https://via.placeholder.com/800x300?text=Banner+1' }}" alt="Banner 1">
                    <div class="img-overlay"><i class="fas fa-upload"></i> Cambiar</div>
                    <input type="file" name="banner1_imagen" accept="image/*" onchange="previewImg(this,'prev-b1')">
                </div>
            </div>
            <div>
                <div class="fg"><label>Título</label><input type="text" name="banner1_titulo" value="{{ $config->banner1_titulo ?? '' }}" placeholder="¡Oferta de verano!"></div>
                <div class="fg"><label>Enlace</label><input type="text" name="banner1_link" value="{{ $config->banner1_link ?? '' }}" placeholder="/cliente/tours"></div>
            </div>
        </div>
    </div>
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-ad"></i> Banner Promocional 2</p>
        <div class="grid2">
            <div class="fg">
                <label>Imagen</label>
                <div class="img-wrap" onclick="this.querySelector('input').click()">
                    <img id="prev-b2" src="{{ $config->banner2_imagen ?: 'https://via.placeholder.com/800x300?text=Banner+2' }}" alt="Banner 2">
                    <div class="img-overlay"><i class="fas fa-upload"></i> Cambiar</div>
                    <input type="file" name="banner2_imagen" accept="image/*" onchange="previewImg(this,'prev-b2')">
                </div>
            </div>
            <div>
                <div class="fg"><label>Título</label><input type="text" name="banner2_titulo" value="{{ $config->banner2_titulo ?? '' }}" placeholder="Paquetes familiares"></div>
                <div class="fg"><label>Enlace</label><input type="text" name="banner2_link" value="{{ $config->banner2_link ?? '' }}" placeholder="/cliente/paquetes"></div>
            </div>
        </div>
    </div>
</div>

{{-- NOSOTROS --}}
<div class="web-section" id="tab-nosotros">
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-users"></i> Sección "¿Quiénes Somos?"</p>
        <div class="grid2">
            <div class="fg">
                <label>Imagen</label>
                <div class="img-wrap" onclick="this.querySelector('input').click()">
                    <img id="prev-nos" src="{{ $config->seccion_nosotros_imagen ?: 'https://via.placeholder.com/600x400?text=Nosotros' }}" alt="Nosotros">
                    <div class="img-overlay"><i class="fas fa-upload"></i> Cambiar</div>
                    <input type="file" name="nosotros_imagen" accept="image/*" onchange="previewImg(this,'prev-nos')">
                </div>
            </div>
            <div>
                <div class="fg"><label>Título</label><input type="text" name="seccion_nosotros_titulo" value="{{ $config->seccion_nosotros_titulo ?? '¿Por qué elegirnos?' }}"></div>
                <div class="fg">
                    <label>Descripción</label>
                    <textarea name="seccion_nosotros_texto" style="min-height:140px">{{ $config->seccion_nosotros_texto ?? 'Somos una agencia especializada en turismo en Tumbes con más de 10 años de experiencia.' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- COLORES Y REDES --}}
<div class="web-section" id="tab-colores">
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-palette"></i> Colores del Sitio</p>
        <div class="grid2">
            <div class="fg">
                <label>Color Primario</label>
                <div class="color-row">
                    <input type="color" id="cp1" value="{{ $config->color_primario ?? '#1a3c6e' }}" oninput="document.getElementById('cp1t').value=this.value">
                    <input type="text" id="cp1t" name="color_primario" value="{{ $config->color_primario ?? '#1a3c6e' }}" oninput="document.getElementById('cp1').value=this.value">
                </div>
            </div>
            <div class="fg">
                <label>Color Secundario</label>
                <div class="color-row">
                    <input type="color" id="cp2" value="{{ $config->color_secundario ?? '#f59e0b' }}" oninput="document.getElementById('cp2t').value=this.value">
                    <input type="text" id="cp2t" name="color_secundario" value="{{ $config->color_secundario ?? '#f59e0b' }}" oninput="document.getElementById('cp2').value=this.value">
                </div>
            </div>
        </div>
    </div>
    <div class="sec-card">
        <p class="sec-title"><i class="fas fa-share-alt"></i> Redes Sociales</p>
        <div class="grid2">
            <div class="fg">
                <label><i class="fab fa-facebook mr-1" style="color:#1877f2"></i> Facebook</label>
                <input type="text" name="facebook_url" value="{{ $config->facebook_url ?? '' }}" placeholder="https://facebook.com/tuagencia">
            </div>
            <div class="fg">
                <label><i class="fab fa-instagram mr-1" style="color:#e1306c"></i> Instagram</label>
                <input type="text" name="instagram_url" value="{{ $config->instagram_url ?? '' }}" placeholder="https://instagram.com/tuagencia">
            </div>
        </div>
    </div>
</div>

<div style="display:flex;align-items:center;gap:16px;padding:8px 0 24px">
    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
    <a href="{{ route('home') }}" target="_blank" style="color:#3b5bdb;font-size:0.85rem;text-decoration:none">
        <i class="fas fa-external-link-alt mr-1"></i> Ver sitio web
    </a>
</div>
</form>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.web-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.web-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
function previewImg(input, id) {
    if (!input.files[0]) return;
    const r = new FileReader();
    r.onload = e => document.getElementById(id).src = e.target.result;
    r.readAsDataURL(input.files[0]);
}
</script>
</x-app-layout>
