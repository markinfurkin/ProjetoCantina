<?php

class Produto {
	var $nome;
	var $preco;
	var $descricao;
	//public function __construct()  
	public function Produto($nome, $preco, $descricao) {
		$this->nome = $nome;
		$this->preco = $preco;
		$this->descricao = $descricao;
	}
	
	public function cadastaProduto() {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$last_user_id = $conexaoCantina->insert("produto", [
		"nome" => $this->nome,
		"preco" => $this->preco,
		"descricao" => $this->descricao
		]);
		return $last_user_id;
	}
	
	public static function getProduto($idProduto) {
		$conexaoCantina = conectaCantina();
		$produto = $conexaoCantina->get("produto", "*",["id" => $idProduto]);
		return $produto;
	}
	
	public static function getProdutos() {
		//simular sobrecarga de metodo
		//arg[0]= filtro por nome 
		$conexaoCantina = conectaCantina();
		$numArgs = (int)func_num_args();
        $args = func_get_args();
        if($numArgs == 1 && (strlen($args[0]))>0){
			$produto = $conexaoCantina->select("produto", "*",["nome[~]" =>"%".$args[0]."%"]);
		} else {
			$produto = $conexaoCantina->select("produto", "*");
		}
		//var_dump($conexaoCantina->log());
		return $produto;
	}
	
	public function atualizaProduto($idProduto) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->update("produto", [
		"nome" => $this->nome,
		"preco" => $this->preco,
		"descricao" => $this->descricao
		],["id" =>$idProduto]);
		return $rows_affected;
	}
	
	public static function excluiProduto($idProduto) {
		require_once ('../lib/libdba.php');
		$conexaoCantina = conectaCantina();
		$rows_affected = $conexaoCantina->delete("produto", ["id" =>$idProduto]);
		return $rows_affected;
	}
	
	public static function getPreco($idProduto) {
		$conexaoCantina = conectaCantina();
		$preco = $conexaoCantina->get("produto", "preco",[
		"id" =>$idProduto]);
		return $preco;
	}
}
?>