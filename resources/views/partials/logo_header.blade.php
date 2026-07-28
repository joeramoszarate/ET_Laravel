@php $cfgLogo = \App\Models\Configuracion::first(); @endphp
<div style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:2px solid #e8ecf4;margin-bottom:20px;">
    @if($cfgLogo && $cfgLogo->logo_url)
        <img src="{{ $cfgLogo->logo_url }}" alt="Logo" style="height:48px;width:auto;object-fit:contain;">
    @else
        <div style="background:#1a3c6e;border-radius:8px;width:48px;height:48px;display:flex;align-items:center;justify-content:center;">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                <circle cx="12" cy="9" r="2.5" fill="#fff" stroke="none"/>
            </svg>
        </div>
    @endif
    <div>
        <div style="font-size:1.1rem;font-weight:800;color:#1a3c6e;">{{ $cfgLogo->nombre_empresa ?? 'ExploreTuTumbes' }}</div>
        <div style="font-size:0.75rem;color:#64748b;">{{ $cfgLogo->slogan ?? 'Región Tumbes, Perú' }}</div>
    </div>
    <div style="margin-left:auto;text-align:right;font-size:0.75rem;color:#64748b;">
        <div>Generado: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
</div>
