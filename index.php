<?php
	/**
	 * Centro Universitário UNA - Sistemas de Informação - Estrutura de dados e Arquivo
	 * Programa de busca por texto em arquivos
	 * @author Joubert Guimarães de Assis <joubert@redrat.com.br>
	 * @version 1.0
	 */

	if(!defined('URL_RAIZ'))
		define('URL_RAIZ', 'http://' . $_SERVER["HTTP_HOST"] . str_replace ('index.php', '', $_SERVER["PHP_SELF"]));
	if(!defined('PATH_RAIZ'))
		define('PATH_RAIZ', str_replace ('index.php', '', $_SERVER["SCRIPT_FILENAME"]));
	include('Busca.class.php');

	$cabecalho  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$cabecalho .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">';
	$cabecalho .= '<head>';
	$cabecalho .=       '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$cabecalho .=       '<title>Buscador Goógle'. (isset($_GET['palavra']) ? ' - ' . $_GET['palavra'] : '') . '</title>';
	$cabecalho .=		'<link href="favicon.ico" rel="shortcut icon"/>';
	$cabecalho .=		'<style>';
	$cabecalho .=		'#cabecalho {
							margin: auto;
							position: fixed;
							top: 0;
							left: 0;
							left: auto;
							width: 100%;
							height: 20px;
							padding-top: 3px;
							background-color: #2D2D2D;
							text-align: center;
							font: bold 10px/1.5em  Verdana;
							color: #C6C6C6;
						}';
	$cabecalho .=		'</style>';
	$cabecalho .= '</head>';
	echo $cabecalho;

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
	<body>
		
	<center>
		<h1 style="font-family: Times New Rowan; font-size: 90px;"><a href="<?php echo URL_RAIZ; ?>" style="text-decoration: none;"> <span style="color: #0040E2;">G</span><span style="color: #D81830;">o</span><span style="color: #FFB400;">ó</span><span style="color: #0040E2;">g</span><span style="color: #0CAC17;">l</span><span style="color: #D81830;">e</span></a></h1>
		<span>Searcheador de arquivos</span>
		<form action="" method="GET">
			<input type="hidden" name="acao" value="buscar" />
			<input type="text" name="palavra" size="60" />
			<button>Buscar no Goógle</button>
		</form>
	</center>
	<?php
	if((isset($_GET['acao']) && $_GET['acao'] == 'buscar' ) && (isset($_GET['palavra']) && $_GET['palavra'] != ''))
	{
		try
		{
			echo '<br/><div align="left" width="20%" style="margin-left: 200px; margin-right: 200px; font-family: Verdana;">';
			if($Busca->encontrados)
			{
				echo 'Sua pesquisa - <b>' . $_GET['palavra'] . '</b> - retornou aproximadamente relativamente	exatamente <b>' . count($Busca->encontrados) . '</b> resultados (' . (number_format((float)$tempo, 2)) . ' segundos)<br/><br/><br/>';
				foreach($Busca->encontrados as $lista)
				{
					echo '<span style="color: #1122CC; font-size: 14px;"><u><b>' . $lista["nome"] . "</b></u></span><br/>";
					echo '<a href="' . utf8_encode($lista["link"]) . '" style="color: #009933; font-size: 12px;">' . utf8_encode($lista["link"]) . "</a><br/>";
					echo '<span style="font-size: 12px;">' . utf8_encode(strip_tags($lista["texto"],'<b>')) . '</span><br/><br/>';
				}
			}
			else
			{
				echo 'Sua pesquisa - <b>' . $_GET['palavra'] . '</b> - não encontrou nenhum documento correspondente.<br/>';
				echo 'Sugestões:<br/>';
				echo '<ul>Vai tomar um café.</ul>';
				echo '<ul>Vai tomar um chá.</ul>';
				echo '<ul>Vai tomar uma cerveja.</ul>';
			}
			echo '</div>';
		}
		catch (Exception $e)
		{
			echo "Exceção disparada: " . $e->getMessage();
		}
	}

	
	?>

	
	</body>
</html>