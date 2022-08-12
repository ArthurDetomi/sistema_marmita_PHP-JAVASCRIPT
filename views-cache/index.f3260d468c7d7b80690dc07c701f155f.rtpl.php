<?php if(!class_exists('Rain\Tpl')){exit;}?><section><!--Area de Conteudo-->
    <div id="area-marmitas" class="container"><!--Inicio area-marmita-->
        <div class="row text-center">
            <h2>Marmitas</h2>
            <hr>
        </div>
        
        <div id="area-produtos" class="row produtos">
            

            <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
            <div class="produto col-md-4 text-center"><!--Produto-->
                <div class="col-md-10">
                    <img class="img-thumbnail" src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="marmita">
                    <h3><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["vlsize"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                    <ins id="price-<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="price-product"><?php echo formatPrice($value1["vlprice"]); ?></ins>
                </div>
                <div class="col-md-2">
                    <div class="botoes">
                        <ul class="botoes-js list-unstyled pull-right">
                            <li>
                                <input id="plus-<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="button" class="btn-plus btn btn-danger" value="+"> 
                            </li>
                            <li>
                                <input id="qtd-<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="number" size="4" class="qtd-text" title="quantidade" value="0" step="1" min="0" disabled>
                            </li> 
                            <li>
                                <input id="minus-<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="button" class="btn-minus btn btn-danger" value="-">       
                            </li>   
                        </ul>
                    </div>
                </div>
            </div><!--Fim Produto-->
            <?php } ?>
         </div><!--Fim area-marmita-->

         <div id="valor-total" class="container"><!--Valor Total-->
            <div class="row text-center">
                <div class="row text-center payment">
                    <h2>Valor Total - Soma</h2>
                    <hr>
                    <ins id="soma-total">0</ins>
                </div>

                
                <div class="row text-center payment"><!--Valor Personalizado-->
                    <h2>Valor Personalizado - % Desconto</h2>
                    <hr>
                </div>
                <div class="row">
                    <div class="valor-personalizado">
                        <div class="input-group">
                          <div id="all-perso" class="input-group-btn">
                            <button id="button-perso" type="button" class="btn button-personalizar btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Desconto %<span class="caret"></span></button>
                            <ul id="opcoes-perso" class="dropdown-menu">
                              <li><a class="item-perso">Personalizar Preço<span class="caret"></span></a></li>
                            </ul>
                          </div><!-- /btn-group -->
                          <input id="value-perso" type="number" class="form-control text-personalizar" aria-label="..." placeholder="%">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->

                    <div class="resultado-personalizado">
                        <div class="input-group">
                          <div class="input-group-btn">
                            <button type="button" class="btn button-personalizar btn-info"  >Novo Valor</button>
                          </div><!-- /btn-group -->
                          <input id="novo-valor-perso" type="number" class="form-control text-personalizar" aria-label="..." placeholder="R$">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->


                </div>

                <div class="row">
                    <div class="button-aplic">
                        <button id="aplicar-alteracoes" class="btn btn-warning">Aplicar Alterações</button>
                    </div>
                </div>
                <!--FIM Valor Personalizado-->
            </div>
         </div><!--Fim Valor Total-->

         <div id="forma-pagamentos" class="container"><!--Container Pagamentos-->
            <div class="row">
                <div class="row text-center payment">
                    <h2>Formas de Pagamento</h2>
                    <hr>
                </div>
                <ul class="nav nav-pills botoes-pagamento">
                    <li role="presentation">
                        <button id="dinheiro" type="button" class="btn btn-primary btn-lg botao">Dinheiro</button>
                    </li>

                    <li role="presentation">
                        <button type="button" id="cartao" class="btn btn-primary btn-lg botao">Cartão</button>
                    </li>

                    <li role="presentation">
                        <button type="button" id="pix" class="btn btn-primary btn-lg botao">Pix</button>
                    </li>
                </ul>
            </div>
         </div><!--Fim Container Pagamentos-->

         <div id="forma-dinheiro" class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row text-right">
                        <h3>Valor Recebido:</h3>
                        <input id="vlrecebido" type="number" name="vlrecebido"  value="" placeholder="R$">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row text-left">
                        <h3>Troco:</h3>
                        <ins id="troco">R$</ins>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button id="botao-troco" type="button" class="btn btn-danger">Calcular Troco</button>
                </div>
            </div>
         </div>
         
         <div id="cadastro" class="container">
            <div class="row text-center">
                <form action="/sistemamarmita/" method="post">
                    <span id="form-cadastro-venda"></span>
                    <button id="cadastrar-venda" type="submit"  class="btn btn-success btn-lg" >Cadastrar Venda</button>
                </form>    
            </div>
         </div>
        
        
</section><!--Fim section-->