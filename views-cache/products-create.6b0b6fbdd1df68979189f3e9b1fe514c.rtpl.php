<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/sistemamarmita/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/sistemamarmita/admin/categories">Categorias</a></li>
    <li class="active"><a href="/sistemamarmita/admin/categories/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/sistemamarmita/admin/products/create" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desproduct">Nome do produto</label>
              <input type="text" class="form-control" id="desproduct" name="desproduct" placeholder="Digite o nome do produto">
            </div>
            <div class="form-group">
              <label for="vlprice">Preço</label>
              <input type="number" class="form-control" id="vlprice" name="vlprice" step="0.01" placeholder="0.00">
            </div>
            <div class="form-group">
              <label for="vlsize">Tamanho</label>
              <input type="text" class="form-control" id="vlsize" name="vlsize" placeholder="Digite o tamanho : P, M ou G">
            </div>
            <div class="form-group">
              <label for="vlsize">desurl</label>
              <input type="text" class="form-control" id="desurl" name="desurl" placeholder="Digite a URL">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->