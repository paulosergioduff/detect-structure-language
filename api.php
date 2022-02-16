<?php

	if(!defined('URL_RAIZ'))
		define('URL_RAIZ', 'http://' . $_SERVER["HTTP_HOST"] . str_replace ('api.php', '', $_SERVER["PHP_SELF"]));
	if(!defined('PATH_RAIZ'))
		define('PATH_RAIZ', str_replace ('api.php', '', $_SERVER["SCRIPT_FILENAME"]));
	include('Busca.class.php');


	if(isset($_GET['acao']) && isset($_GET['palavra']) && $_GET['palavra'] != '')
	{
		$tempo = microtime();
		try
		{
			$Busca = new Busca();
			$Busca->palavra_chave = $_GET['palavra'];
			$Busca->busca(PATH_RAIZ);
		}
		catch (Exception $e)
		{
			echo "Exceção disparada: " . $e->getMessage();
		}
	}
?>
	
