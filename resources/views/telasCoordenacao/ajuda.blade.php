@extends('layouts.app')

@section('content')

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Ajuda</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Central de Ajuda</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Central de Ajuda e Suporte</h1>
            <p class="text-sm text-[#5c706b]">Acesse manuais, tutoriais e canais de atendimento</p>
        </div>
    </div>

    <!-- Grade de Cards de Ajuda -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card: Manual de Uso -->
        <a href="{{ asset('manual/Manual Maruge - Coordenacao.pdf') }}" target="_blank" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="book-open" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Manual</h2>
                <h3 class="text-xs text-[#5c706b]">Manual de Uso (PDF)</h3>
            </div>
        </a>

        <!-- Card: YouTube -->
        <a href="#" data-toggle="modal" data-target="#youtube" class="bg-white border border-[#e3e8e6] hover:border-red-500 rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="video" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-red-600 transition-colors">YouTube</h2>
                <h3 class="text-xs text-[#5c706b]">Canal Oficial</h3>
            </div>
        </a>

        <!-- Card: FaceBook -->
        <a href="#" data-toggle="modal" data-target="#facebook" class="bg-white border border-[#e3e8e6] hover:border-blue-600 rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="globe" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-blue-600 transition-colors">FaceBook</h2>
                <h3 class="text-xs text-[#5c706b]">Página Oficial</h3>
            </div>
        </a>

        <!-- Card: Sugestões -->
        <a href="#" data-toggle="modal" data-target="#sugestoes" class="bg-white border border-[#e3e8e6] hover:border-amber-500 rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="message-square-plus" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-amber-600 transition-colors">Sugestões</h2>
                <h3 class="text-xs text-[#5c706b]">Deixe aqui sua opinião!</h3>
            </div>
        </a>

        <!-- Card: Bate-Papo -->
        <a href="#" data-toggle="modal" data-target="#chat" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="messages-square" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Bate-Papo</h2>
                <h3 class="text-xs text-[#5c706b]">08:00am às 05:00pm</h3>
            </div>
        </a>

        <!-- Card: Contatos -->
        <a href="#" data-toggle="modal" data-target="#contatos" class="bg-white border border-[#e3e8e6] hover:border-indigo-600 rounded-2xl p-6 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="phone-call" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-indigo-600 transition-colors">Contatos</h2>
                <h3 class="text-xs text-[#5c706b]">Ligue pra Gente</h3>
            </div>
        </a>

    </div>

</div> <!--Fim do caminho-din-->

<!-- Modal Youtube -->
<div class="modal fade" tabindex="-1" role="dialog" id="youtube" aria-labelledby="exampleModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
      <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
        <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
            <i data-lucide="video" class="w-5 h-5 text-red-600"></i> Canal Oficial Youtube
        </h4>
        <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body py-4 text-sm text-[#5c706b]">
        <p>Em breve! Vídeos tutoriais e treinamentos estarão disponíveis neste canal.</p>
      </div>
      <div class="modal-footer pt-3 border-t border-[#e3e8e6] flex justify-end">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal facebook -->
<div class="modal fade" tabindex="-1" role="dialog" id="facebook" aria-labelledby="exampleModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
      <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
        <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
            <i data-lucide="globe" class="w-5 h-5 text-blue-600"></i> Página Oficial FaceBook
        </h4>
        <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body py-4 text-sm text-[#5c706b]">
        <p>Em breve! Acompanhe as novidades em nossa página oficial.</p>
      </div>
      <div class="modal-footer pt-3 border-t border-[#e3e8e6] flex justify-end">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Sugestão -->
<div class="modal fade" tabindex="-1" role="dialog" id="sugestoes" aria-labelledby="exampleModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
      <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
        <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
            <i data-lucide="message-square-plus" class="w-5 h-5 text-amber-500"></i> Sugestões
        </h4>
        <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body py-4 text-sm text-[#5c706b]">
        <p>Envie sua sugestão ou melhoria para nossa equipe técnica de atendimento.</p>
      </div>
      <div class="modal-footer pt-3 border-t border-[#e3e8e6] flex justify-end">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal chat -->
<div class="modal fade" tabindex="-1" role="dialog" id="chat" aria-labelledby="exampleModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
      <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
        <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
            <i data-lucide="messages-square" class="w-5 h-5 text-[#008a4b]"></i> Bate-Papo
        </h4>
        <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body py-4 text-sm text-[#5c706b]">
        <p>Nosso suporte ao vivo está disponível das 08:00h às 17:00h.</p>
      </div>
      <div class="modal-footer pt-3 border-t border-[#e3e8e6] flex justify-end">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Contatos -->
<div class="modal fade" tabindex="-1" role="dialog" id="contatos" aria-labelledby="exampleModalLabel" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
      <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
        <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
            <i data-lucide="phone-call" class="w-5 h-5 text-indigo-600"></i> Contatos
        </h4>
        <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body py-4 text-sm text-[#5c706b]">
        <p>Telefone / WhatsApp de atendimento: (00) 00000-0000</p>
      </div>
      <div class="modal-footer pt-3 border-t border-[#e3e8e6] flex justify-end">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@endsection