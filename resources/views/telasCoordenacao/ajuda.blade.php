@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Ajuda'}}</h1>

</div> 
<div class="caminho-din">
    
    <div class="formularios">    
 


<div class="caminho-din">
    
    
    <div class="rel-geral col-md-4 sombra">
        <a href="{{asset('manual/Manual Maruge - Coordenacao.pdf')}}" target="_blank">
   
            
        <i class="fa fa-book rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                Manual
            </h2>
            <h3 class="resultado-geral">
                Manual de Uso
            </h3>
        </div>
        </a>
    </div>
    
    
    
    
    <div class="rel-geral col-md-4 sombra">
    <a data-toggle="modal" data-target="#youtube" href="#">
        <i class="fa fa-youtube rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                YouTube
            </h2>
            <h3 class="resultado-geral">
                Canal Oficial
            </h3>
        </div>
    </a>
    </div>
        
        
    <div class="rel-geral col-md-4 sombra">
        <a data-toggle="modal" data-target="#facebook" href="#">
        <i class="fa fa-facebook-official rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                FaceBook
            </h2>
            <h3 class="resultado-geral">
                Página Oficial
            </h3>	
        </div>
        </a>
    </div>
    <div class="rel-geral col-md-4 sombra">
         <a data-toggle="modal" data-target="#sugestoes" href="#">
        <i class="fa fa-commenting rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
               Sugestões
            </h2>
            <h3 class="resultado-geral">
                Deixe aqui sua opnião!
            </h3>
        </div>
         </a>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <a data-toggle="modal" data-target="#chat" href="#">
        <i class="fa fa-comments  rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                Bate-Papo
            </h2>
            <h3 class="resultado-geral">
                 08:00am às 05:00pm
            </h3>	
        </div>
        </a>
    </div>
    

    <div class="rel-geral col-md-4 sombra">
            <a data-toggle="modal" data-target="#contatos" href="#">
        <i class="fa fa-phone-square rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
             Contatos
            </h2>
            <h3 class="resultado-geral">
                Ligue pra Gente
            </h3>
        </div>
        </a>
            </div>
    
    
    
    
    
    
</div> <!--Fim do caminho-din-->
            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->

<!-- Modal Youtube -->
<div class="modal fade" tabindex="-1" role="dialog" id="youtube" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alteraNota-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Canal Oficial Youtube</h4>
      </div>
      <div class="modal-body">
        <p>Em breve!</p>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal facebook -->
<div class="modal fade" tabindex="-1" role="dialog" id="facebook" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alteraNota-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Página Oficial FaceBook</h4>
      </div>
      <div class="modal-body">
        <p>Em breve!</p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal Sugestão -->
<div class="modal fade" tabindex="-1" role="dialog" id="sugestoes" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alteraNota-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sugestões</h4>
      </div>
      <div class="modal-body">
        <p>Em breve!</p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal chat -->
<div class="modal fade" tabindex="-1" role="dialog" id="chat" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alteraNota-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sugestões</h4>
      </div>
      <div class="modal-body">
        <p>Em breve!</p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal Contatos -->
<div class="modal fade" tabindex="-1" role="dialog" id="contatos" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alteraNota-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sugestões</h4>
      </div>
      <div class="modal-body">
        <p>Em breve!</p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@endsection