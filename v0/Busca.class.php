<?php
	/**
	 * Centro Universitário UNA - Sistemas de Informação - Estrutura de dados e Arquivo.
	 * Classe responsável por realizar uma busca nos arquivos de determinada pasta
	 * de acordo com a palavra chave informada.
	 * @author Joubert Guimarães de Assis <joubert@redrat.com.br>
	 * @version 1.0
	 */

	class Busca
	{
		/**
		 * Atributo responsável por armazenar os atributos dos arquivos encontrados
		 * @var array
		 */
		private $encontrados = array();

		/**
		 * Atributo de definição da palavra chave usada na pesquisa.
		 * @var string
		 */
		private $palavra_chave;

		/**
		 * Atributo de delimitação da extensão de arquivo que poderá entrar na listagem
		 * @var array();
		 */
		private $extensoes = array('txt', 'html', 'htm', 'log');

		public $ocorrencias;

		/**
		 * Método construtor da classe, reponsável por apenas instanciar a classe.
		 */
		public function  __construct()
		{
		//Nada a fazer
		}

		/**
		 * Método mágico responsável por popular os atributos da classe ou disparar
		 * exceção caso atributo seja desconhecido.
		 * @param string $atributo nome do atributo que receberá o valor.
		 * @param mixed $valor valor do atributo que será populado.
		 */
		public function  __set($atributo, $valor) {
			switch($atributo)
			{
				case 'palavra_chave':
					$this->$atributo = $valor;
				break;
				default:
					throw new Exception('Atributo desconhecido dentro da classe Busca');
				break;
			}
		}

        /**
         * Método mágico responsável por retornar os atributos da classe ou disparar
         * exceção caso atributo seja desconhecido.
         * @param string $atributo nome do atributo que receberá o valor.
         * @param mixed $valor valor do atributo que será populado.
         */
        public function  __get($atributo) {
            switch($atributo)
            {
                case 'encontrados':
                    return $this->$atributo;
                break;
                default:
                    throw new Exception('Atributo desconhecido dentro da classe Busca');
                break;
            }
        }
		
		/**
		 * Método responsável por gerar a listagem de pastas para fazer chamadas recursivas
		 * e listagem de arquivos que deverão ser checadas de acordo com a extensão e depois
		 * realizar a busca com a palavra chave
		 * @param string $pasta string contendo o endereço da pasta que será realizado o
		 * procedimento citado acima.
		 */
		public function busca($pasta)
		{
			/*
			 * Novo array para pastas e arquivos, note que a cada chamada recursiva
			 * são criadas novos atributos internos dentro do método busca, diferentemente 
			 * dos atributos da classe que independente da quantidade de chamadas recursivas, 
			 * seus valores originais armazenados não são alterados (salvo quando alterado
			 * dentro do método).
			 */
			$pastas = array();
			$arquivos = array();

			/*
			 * Extração dos dados da pasta para obter a listagem de pastas e arquivos
			 */
			foreach(glob($pasta . "*") as $listagem)
			{
				/*
				 * Teste se a 'listagem' é uma pasta
				 */
				if(is_dir($listagem))
					$pastas[] = $listagem;
				/*
				 * Teste se a 'listagem' é um arquivo com extensão dentro da lista de extensões permitidas
				 */
				else if($this->checarExtensao($listagem))
					$arquivos[] = $listagem;
			}

			/*
			 * Ordenaçao dos arrays de pastas e arquivos por ordem alfabética
			 */
			sort($pastas);
			sort($arquivos);
			$contador = 0;
			$total = count($pastas);

			/*
			 * Estrutura de repetição responsável por varrer o array de pastas
			 * e fazer as chamadas recursivas.
			 */
			while($contador < $total)
			{
				$this->busca($pastas[$contador] . '/');
				unset($pastas[$contador]);
				$contador++;
			}
			$contador = 0;
			$total = count($arquivos);
			$result_file_find = 0;

			/*
			 * Estrutura de repetição responsável por varrer o array de arquivos
			 * e fazer as comparações com a palavra chave.
			 */
			
			while($contador < $total)
			{
				$texto = file_get_contents($arquivos[$contador]);
				if(strpos($texto, $this->palavra_chave) !== false)
				{
					$arquivo_nome = str_replace($pasta, '', $arquivos[$contador]);
					$arquivo_link = str_replace(PATH_RAIZ, URL_RAIZ, $arquivos[$contador]);
					$arquivo_formatado = substr($texto, ((int) strpos($texto, $this->palavra_chave) - 90), 230);
					$arquivo_formatado = str_replace($this->palavra_chave, '<b>'. $this->palavra_chave .'</b>', $arquivo_formatado);
					$arquivo_formatado = str_replace('  ', '', str_replace("\n", '', $arquivo_formatado)) . " ...";
					$this->encontrados[] = array("nome" => $arquivo_nome, "link" => $arquivo_link, "texto" => $arquivo_formatado);
					$ocorrencias = substr_count($arquivo_formatado, $this->palavra_chave);
					$result_file_find = $result_file_find+$ocorrencias;

					//echo "<p>$arquivo_link";

					$marcador = $contador + 1;
					//echo "<p><h1>".$result_file_find." - > $marcador/$total</h1>";					
					if ($marcador == $total) {
						$this->ocorrencias = $result_file_find;
						echo "{
							\"result\": $this->ocorrencias
						 }";
					}
				}
				$contador++;
			}
		}


		public function ml_FileList($pasta)
		{
			/*
			 * Novo array para pastas e arquivos, note que a cada chamada recursiva
			 * são criadas novos atributos internos dentro do método busca, diferentemente 
			 * dos atributos da classe que independente da quantidade de chamadas recursivas, 
			 * seus valores originais armazenados não são alterados (salvo quando alterado
			 * dentro do método).
			 */
			$pastas = array();
			$arquivos = array();

			/*
			 * Extração dos dados da pasta para obter a listagem de pastas e arquivos
			 */
			foreach(glob($pasta . "*") as $listagem)
			{
				/*
				 * Teste se a 'listagem' é uma pasta
				 */
				if(is_dir($listagem))
					$pastas[] = $listagem;
				/*
				 * Teste se a 'listagem' é um arquivo com extensão dentro da lista de extensões permitidas
				 */
				else if($this->checarExtensao($listagem))
					$arquivos[] = $listagem;
			}

			/*
			 * Ordenaçao dos arrays de pastas e arquivos por ordem alfabética
			 */
			sort($pastas);
			sort($arquivos);
			$contador = 0;
			$total = count($pastas);

			/*
			 * Estrutura de repetição responsável por varrer o array de pastas
			 * e fazer as chamadas recursivas.
			 */
			while($contador < $total)
			{
				$this->busca($pastas[$contador] . '/');
				unset($pastas[$contador]);
				$contador++;
			}
			$contador = 0;
			$total = count($arquivos);
			$result_file_find = 0;

			/*
			 * Estrutura de repetição responsável por varrer o array de arquivos
			 * e fazer as comparações com a palavra chave.
			 */
			
			while($contador < $total)
			{
				$texto = file_get_contents($arquivos[$contador]);
				if(strpos($texto, $this->palavra_chave) !== false)
				{
					$arquivo_nome = str_replace($pasta, '', $arquivos[$contador]);
					$arquivo_link = str_replace(PATH_RAIZ, URL_RAIZ, $arquivos[$contador]);
					$arquivo_formatado = substr($texto, ((int) strpos($texto, $this->palavra_chave) - 90), 230);
					$arquivo_formatado = str_replace($this->palavra_chave, '<b>'. $this->palavra_chave .'</b>', $arquivo_formatado);
					$arquivo_formatado = str_replace('  ', '', str_replace("\n", '', $arquivo_formatado)) . " ...";
					$this->encontrados[] = array("nome" => $arquivo_nome, "link" => $arquivo_link, "texto" => $arquivo_formatado);
					$ocorrencias = substr_count($arquivo_formatado, $this->palavra_chave);
					$result_file_find = $result_file_find+$ocorrencias;

					echo "<p>ML FileList $arquivo_link";

					$marcador = $contador + 1;
					echo "<p><h1>".$result_file_find." - > $marcador/$total</h1>";					
					if ($marcador == $total) {
						$this->ocorrencias = $result_file_find;
						echo "{
							\"result\": $this->ocorrencias
						 }";
					}
				}
				$contador++;
			}
		}

		/**
		 * Método privado responsável por checar a extensão do arquivo.
		 * @param string $arquivo endereço absoluto do arquivo
		 * @return boolean retorna true se o arquivo é válido ou false para não válido.
		 */
		private function checarExtensao($arquivo)
		{
			$quebra = explode(".", $arquivo);
			$extensao = strtolower(array_pop($quebra));
			if(array_search($extensao, $this->extensoes) === false)
				return false;
			return true;
		}
	}
?>
