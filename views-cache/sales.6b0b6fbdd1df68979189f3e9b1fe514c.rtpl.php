<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Vendas
  </h1>
  <ol class="breadcrumb">
    <li><a href="/sistemamarmita/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/sistemamarmita/admin/sales">Vendas</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Descrição da venda</th>
                    <th>Forma de Pagamento</th>
                    <th>Data/Hora</th>
                    <th>Preço</th>
                    <th style="width: 140px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($listSales) && ( is_array($listSales) || $listSales instanceof Traversable ) && sizeof($listSales) ) foreach( $listSales as $key1 => $value1 ){ $counter1++; ?>
                  <tr>
                    <td><?php echo htmlspecialchars( $value1["idvenda"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo formatDescription($value1["describeVenda"]); ?></td>
                    <td><?php echo htmlspecialchars( $value1["forma_pagamento"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo formatDate($value1["dt_register"]); ?></td>
                    <td>R$ <?php echo htmlspecialchars( $value1["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td/>
                    <td>
                      <a href="/sistemamarmita/admin/sales/<?php echo htmlspecialchars( $value1["idvenda"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                      <a href="/sistemamarmita/admin/sales/<?php echo htmlspecialchars( $value1["idvenda"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->