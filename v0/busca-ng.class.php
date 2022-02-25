<?php

class Busca
{
  private $encontrados = array();
  
  private $palavra_chave;
  
  private $extensoes = array('txt', 'html', 'htm', 'log', 'srt', 'SRT');
  
  public $ocorrencias;
  
  public function __construct()
  {
  }
  
  public function __set($atributo, $valor)
  {
    switch ($atributo) {
      case 'palavra_chave':
        $this->$atributo = $valor;
        break;
      default:
        throw new Exception('Atributo desconhecido dentro da classe Busca');
        break;
    }
  }
  
  public function __get($atributo)
  {
    switch ($atributo) {
      case 'encontrados':
        return $this->$atributo;
        break;
      default:
        throw new Exception('Atributo desconhecido dentro da classe Busca');
        break;
    }
  }
  
  public function busca($pasta)
  {
    $pastas   = array();
    $arquivos = array();
    
    foreach (glob($pasta . "*") as $listagem) {
      if (is_dir($listagem))
        $pastas[] = $listagem;
      else if ($this->checarExtensao($listagem))
        $arquivos[] = $listagem;
    }
    
    sort($pastas);
    sort($arquivos);
    $contador = 0;
    $total    = count($pastas);
    
    while ($contador < $total) {
      $this->busca($pastas[$contador] . '/');
      unset($pastas[$contador]);
      $contador++;
    }
    $contador         = 0;
    $total            = count($arquivos);
    $result_file_find = 0;
    
    
    while ($contador < $total) {
      $texto = file_get_contents($arquivos[$contador]);
      if (strpos($texto, $this->palavra_chave) !== false) {
        $arquivo_nome        = str_replace($pasta, '', $arquivos[$contador]);
        $arquivo_link        = str_replace(PATH_RAIZ, URL_RAIZ, $arquivos[$contador]);
        $arquivo_formatado   = substr($texto, ((int) strpos($texto, $this->palavra_chave) - 90), 230);
        $arquivo_formatado   = str_replace($this->palavra_chave, '<b>' . $this->palavra_chave . '</b>', $arquivo_formatado);
        $arquivo_formatado   = str_replace('  ', '', str_replace("\n", '', $arquivo_formatado)) . " ...";
        $this->encontrados[] = array(
          "nome" => $arquivo_nome,
          "link" => $arquivo_link,
          "texto" => $arquivo_formatado
        );
        $ocorrencias         = substr_count($arquivo_formatado, $this->palavra_chave);
        $result_file_find    = $result_file_find + $ocorrencias;
        
        $marcador = $contador + 1;
        if ($marcador == $total) {
          $this->ocorrencias = $result_file_find;
          echo "{
                            \"result\": $this->ocorrencias,
                            \"word\": \"$this->palavra_chave\"
                         }";
        }
      }
      $contador++;
    }
  }
  
  
  private function checarExtensao($arquivo)
  {
    $quebra   = explode(".", $arquivo);
    $extensao = strtolower(array_pop($quebra));
    if (array_search($extensao, $this->extensoes) === false)
      return false;
    return true;
  }
}
?>