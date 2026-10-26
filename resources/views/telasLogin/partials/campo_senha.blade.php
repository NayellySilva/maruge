<div class="flex flex-col gap-2">
    <label for="password" class="text-sm font-semibold">Senha</label>
    <div class="flex h-12 items-center gap-2.5 rounded-xl border bg-white pl-3.5 pr-1.5 focus-within:border-[#008a4b] focus-within:ring-2 focus-within:ring-[#008a4b]/15 {{ $errors->has('password') ? 'border-red-400' : 'border-[#d8e2de]' }}">
        <svg class="h-[18px] w-[18px] flex-none text-[#5c706b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        <input id="password" name="password" type="password" inputmode="numeric" autocomplete="current-password" required
               placeholder="8 dígitos" data-mascara="digitos8"
               class="min-w-0 flex-1 border-0 bg-transparent text-base text-[#0a241e] outline-none placeholder:text-[#95aba5]">
        <button type="button" data-alternar-senha="password" aria-label="Mostrar senha" aria-pressed="false"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-[#5c706b] hover:bg-[#f1f5f3] hover:text-[#0a241e]">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
    </div>
    @error('password')<p class="text-sm text-red-700">{{ $message }}</p>@enderror
</div>
