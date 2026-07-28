<x-app-layout>
<x-slot name="header">
    <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('tours') }}" style="color:#64748b;text-decoration:none;display:flex;align-items:center;gap:4px;font-size:0.875rem;">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Tours
        </a>
        <span style="color:#d1d5db;">/</span>
        <h2 style="font-size:1.1rem;font-weight:700;color:#1e3a5f;margin:0;">
            {{ isset($tour) ? 'Editar Tour' : 'Nuevo Tour' }}
        </h2>
    </div>
</x-slot>

<div style="padding:24px;background:#f8fafc;min-height:calc(100vh - 120px);">
    <div style="max-width:720px;margin:0 auto;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:32px;">

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#dc2626;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;">
            <ul style="margin:0;padding-left:16px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($tour) ? route('tours.update', $tour->id_tour) : route('tours.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($tour)) @method('PUT') @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Nombre del Tour *</label>
                    <input type="text" name="nombre_tour" value="{{ old('nombre_tour', $tour->nombre_tour ?? '') }}" required maxlength="150"
                        style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div>
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Destino *</label>
                    <select name="id_destino" required style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;background:#fff;box-sizing:border-box;" onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Selecciona un destino</option>
                        @foreach($destinos as $d)
                            <option value="{{ $d->id_destino }}" {{ old('id_destino', $tour->id_destino ?? '') == $d->id_destino ? 'selected' : '' }}>{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Categoría *</label>
                    <select name="id_catto" required style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;background:#fff;box-sizing:border-box;" onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id_catto }}" {{ old('id_catto', $tour->id_catto ?? '') == $c->id_catto ? 'selected' : '' }}>{{ $c->descripcion }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Precio (S/) *</label>
                    <input type="number" name="precio" value="{{ old('precio', $tour->precio ?? '') }}" required min="0" step="0.01"
                        style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div>
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Duración (días) *</label>
                    <input type="number" name="duracion_dias" value="{{ old('duracion_dias', $tour->duracion_dias ?? 1) }}" required min="1"
                        style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div>
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Estado *</label>
                    <select name="estado" required style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;background:#fff;box-sizing:border-box;" onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="activo" {{ old('estado', $tour->estado ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $tour->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Ubicación Exacta *</label>
                    <input type="text" name="ubicacion_exacta" value="{{ old('ubicacion_exacta', $tour->ubicacion_exacta ?? '') }}" required maxlength="150"
                        style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Descripción *</label>
                    <textarea name="descripcion" rows="4" required style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:0.875rem;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">{{ old('descripcion', $tour->descripcion ?? '') }}</textarea>
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:0.82rem;font-weight:600;color:#374151;margin-bottom:6px;">Imagen del Tour</label>
                    <input type="file" name="imagen" accept="image/*" style="width:100%;border:1.5px solid #e5e7eb;border-radius:8px;padding:9px 12px;font-size:0.875rem;box-sizing:border-box;">
                    <p style="font-size:0.75rem;color:#94a3b8;margin:4px 0 0;">JPG, PNG o WEBP. Máx 4MB. Se guardará en storage/tours/</p>
                    @if(isset($tour) && $tour->imagen_url)
                        <div style="margin-top:10px;">
                            <img src="{{ $tour->imagen_url }}" alt="imagen actual" style="height:80px;border-radius:8px;object-fit:cover;">
                            <p style="font-size:0.75rem;color:#94a3b8;margin:4px 0 0;">Imagen actual — sube una nueva para reemplazarla</p>
                        </div>
                    @endif
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:16px;border-top:1px solid #f1f5f9;">
                <a href="{{ route('tours') }}" style="padding:10px 20px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:0.875rem;font-weight:600;border-radius:8px;text-decoration:none;">Cancelar</a>
                <button type="submit" style="padding:10px 24px;background:#16a34a;color:#fff;font-size:0.875rem;font-weight:700;border:none;border-radius:8px;cursor:pointer;" onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                    {{ isset($tour) ? 'Guardar Cambios' : 'Crear Tour' }}
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
