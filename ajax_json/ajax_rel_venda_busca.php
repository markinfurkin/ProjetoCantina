﻿<?php
require_once ('../lib/libdba.php');
require_once('../model/Venda.php');
$vendas = Venda::getVendas(inverteDataBD($_GET['dti']),inverteDataBD($_GET['dtf']));
$vendas_qnt = Venda::getCount();
$venda_total = 0;
for($i=0;$i<sizeof($vendas);$i++) {
	$vendas[$i]['data'] = ConverteDataBD($vendas[$i]['data']);
	$vendas[$i]['data_hora'] = explode(" ", $vendas[$i]['data'])[0];
	$vendas[$i]['data_dia'] = explode(" ", $vendas[$i]['data'])[1];
	$venda_total += $vendas[$i]['valor'];
}
$qnt_page = $vendas_qnt/10;
$qnt_page = (substr($qnt_page, 2, 1) > 0)?(substr($qnt_page, 0, 1)+1):substr($qnt_page, 0, 1);
?>
<script>
	$(function() {
		$('#paginacao a').click(function (e) {
			e.preventDefault();
			console.log(e);
			var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
			$.ajax({
					url: "./ajax_json/ajax_rel_venda_busca_pagina.php",
					type: "GET",
					data: 'dti='+$('#start').val()+'&dtf='+$('#end').val()+'&pag='+$(this).html(),
					beforeSend: function(){
						$("#rel_venda").html("");
						$("#rel_venda").append(img)
					},
					complete: function(){
						//$("#rel_venda").append(img);
					},
					success:function(result){
						//$("#rel_venda").html(result);
					}
					}).done(function(result) {
						//alert(result);
					});
		});
		$('#paginacao a:contains(1)').parent().toggleClass("active");
	});
</script>
<div id="rel_venda">
	<table class="table table-hover table-striped" >
		<thead>
			<th>Data</th>
			<th>Cliente</th>
			<th>Valor(R$)</th>
			<th>Produtos</th>
		</thead>
		<tbody>
			<?php for($i=0;$i<sizeof($vendas);$i++) { ?>
				<tr>
					<td><?=$vendas[$i]['data_hora']?><br/><?=$vendas[$i]['data_dia']?></td>
					<td><?=$vendas[$i]['cliente']?></td>
					<td><?=number_format($vendas[$i]['valor'], 2, ',', '.')?></td>
					<td>
						<button class="btn btn-default" type="button" data-target="#produtos_modal" data-toggle="modal" data-idvenda="<?=$vendas[$i]['id']?>">
							<span class=" glyphicon glyphicon-info-sign"></span>
						</button>
					</td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">Total</td>
				<th><?=number_format($venda_total, 2, ',', '.')?></th>
		</tfoot>
	</table>
</div>
<!--<div class="divCentro centralizado">
	<ul class="pagination" id="paginacao">
	  <?php for($i=1;$i<=$qnt_page;$i++) { ?>
		<li><a href="#"><?=$i?></a></li>
	  <?php } ?>
	</ul>
</div>-->