@foreach (['ERRO-LOGIN', 'Inativo', 'SEMPERMISSOES'] as $chave)
    @if ($errors->has($chave))
        <div role="alert" class="flex items-start gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-3 text-sm font-medium text-red-700">
            <svg class="mt-px h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ $errors->first($chave) }}</span>
        </div>
    @endif
@endforeach
