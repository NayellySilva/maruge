@extends('telasLogin.index')

@section('titulo', 'Portal do aluno')
@section('descricao', 'Portal do aluno: boletim, notas e declarações sempre à mão.')

@section('form')
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold tracking-tight lg:text-[30px]">Portal do aluno</h1>
        <p class="text-[15px] text-[#5c706b]">Use seu RA e a senha recebidos na matrícula.</p>
    </div>

    @include('telasLogin.partials.alertas')

    <form method="POST" action="{{ url('/loginaluno') }}" class="flex flex-col gap-5" data-login-form>
        @csrf

        <div class="flex flex-col gap-2">
            <label for="RA" class="text-sm font-semibold">RA</label>
            <div class="flex h-12 items-center gap-2.5 rounded-xl border bg-white px-3.5 focus-within:border-[#008a4b] focus-within:ring-2 focus-within:ring-[#008a4b]/15 {{ $errors->has('RA') ? 'border-red-400' : 'border-[#d8e2de]' }}">
                <svg class="h-[18px] w-[18px] flex-none text-[#5c706b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <input id="RA" name="RA" type="text" inputmode="numeric" autocomplete="username" required autofocus
                       value="{{ old('RA') }}" placeholder="Seu RA" data-mascara="digitos8"
                       class="min-w-0 flex-1 border-0 bg-transparent text-base text-[#0a241e] outline-none placeholder:text-[#95aba5]">
            </div>
            @error('RA')<p class="text-sm text-red-700">{{ $message }}</p>@enderror
        </div>

        @include('telasLogin.partials.campo_senha')

        <button type="submit" data-texto-enviando="Entrando..."
                class="h-[50px] rounded-full bg-[#008a4b] text-base font-semibold text-white shadow-[0_6px_16px_rgba(0,138,75,0.25)] transition-colors hover:bg-[#00703c] disabled:cursor-wait disabled:opacity-70">
            Entrar
        </button>
    </form>
@endsection

@section('link_alternativo')
    <a href="{{ url('/login') }}" class="p-2 text-sm font-semibold text-[#008a4b] hover:text-[#00703c]">Sou professor ou da coordenação</a>
@endsection
