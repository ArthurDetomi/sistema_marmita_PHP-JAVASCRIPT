<?php if(!class_exists('Rain\Tpl')){exit;}?><section><!--Area de Conteudo-->
    <div id="area-marmitas" class="container"><!--Inicio area-marmita-->
        <div class="row text-center">
            <h2>Marmitas</h2>
            <hr>
        </div>
        
        <div class="row produtos">
            <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
            <div class="produto col-md-4 text-center"><!--Produto-->
                <div class="col-md-10">
                    <img class="img-thumbnail" src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="marmita">
                    <h3><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["vlsize"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                    <ins><?php echo htmlspecialchars( $value1["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?></ins>
                </div>
                <div class="col-md-2">
                    <div class="botoes">
                        <ul class="list-unstyled pull-right">
                            <li>
                                <input type="button" onclick="alterQtdProduct('up')" class="btn-plus btn btn-danger" value="+">       
                            </li>
                            <li>
                                <input id="setQtdProduct-<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="number number-qtd" size="4" class="qtd-text" title="Qty" value="0" step="1" min="0">
                            </li> 
                            <li>
                                <input type="button" onclick="alterQtdProduct('down')" class="btn-minus btn btn-danger" value="-">       
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
                    <ins id="valor-total">R$100,00</ins>
                </div>
            </div>
         </div><!--Fim Valor Total-->

         <div id="forma-pagamentos" class="container"><!--Container Pagamentos-->
            <div class="row">
                <div class="row text-center payment">
                    <h2>Formas de Pagamento</h2>
                    <hr>
                </div>
                <ul class="nav nav-pills botoes-pagamento">
                    <li role="presentation"><button class="btn btn-primary btn-lg botao">Dinheiro</button></li>
                    <li role="presentation"><button class="btn btn-primary btn-lg botao">Cartão</button></li>
                    <li role="presentation"><button class="btn btn-primary btn-lg botao">Pix</button></li>
                </ul>
            </div>
         </div><!--Fim Container Pagamentos-->

         <div id="forma-dinheiro" class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row text-right">
                        <h3>Valor Recebido:</h3>
                        <input type="number" name="vlrecebido" id="vlrecebido" placeholder="R$">
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
                    <button class="btn btn-danger">Calcular Troco</button>
                </div>
            </div>
         </div>
         
         <div id="cadastro" class="container">
            <div class="row text-center">
                <button class="btn btn-success btn-lg">Cadastrar Venda</button>
            </div>
         </div>
</section><!--Fim section-->