﻿<?php
require_once (dirname(__DIR__).'cantinho//lib/libdba.php');
require_once (dirname(__DIR__).'cantinho/model/Fornecedor.php');
$index = ($_GET['pag']-1)*10;
$fornecedors = Fornecedor::getFornecedores($_GET['nome'],$index);
?>
<script>
	$(function() {
		$('#paginacao a').parent().each(function() {
			$(this).removeClass("active");
		});
		$('#paginacao a:contains(<?=$_GET['pag']?>)').parent().toggleClass("active");
		$("[data-tt=tooltip]").tooltip({container: 'body'});
	});
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
	<tbody>
		<?php for($i=0;$i<sizeof($fornecedors);$i++) { ?>  
		<tr>
			<td><?=$fornecedors[$i]['nome']?></td>
			<td><?=$fornecedors[$i]['descricao']?></td>
			<td class="btn-group btn-group-4">
				<button type="button" class="btn btn-info" onclick="location.href='?page=editaFornecedor&id=<?=$fornecedors[$i]['id']?>'" data-tt='tooltip' title='Editar Fornecedor'><span class="glyphicon glyphicon-pencil"></span></button>
				<button type="button" class="btn btn-danger" onclick="ajaxExcluiFornecedor(<?=$fornecedors[$i]['id']?>)" data-tt='tooltip' title='Excluir Fornecedor'><span class="glyphicon glyphicon-remove"></span></button>
			</td>
		</tr>
		<?php } ?>  
	</tbody>
</table>