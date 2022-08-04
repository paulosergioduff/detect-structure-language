<?php error_reporting(0);

// Esse código trará algum problema de dependência para a arquitetura por compartilhar a constante str_replace
if(!defined('URL_RAIZ'))
define('URL_RAIZ', 'http://' . $_SERVER["HTTP_HOST"] . str_replace ('test-ng.php', '', $_SERVER["PHP_SELF"]));
if(!defined('PATH_RAIZ'))
define('PATH_RAIZ', str_replace ('test-ng.php', '', $_SERVER["SCRIPT_FILENAME"]));
include('busca-ng.class.php');

include ("model/registerSentence.php");

//
function counterInFiles($word){
        $tempo = microtime();
            try
            {
                $Busca = new Busca();
                $Busca->palavra_chave = $word;
                return $Busca->busca(PATH_RAIZ);
            }
                catch (Exception $e)
                {
                    echo "Exceção disparada: " . $e->getMessage();
                }
}

function captureWords($content, $dictionary){

    $limit_str = strlen($content);
    $last_word = '';
    


    for ($i = 0; $i < $limit_str; $i++) {
        if ($content[$i] == ' '){
            array_push($dictionary, $last_word);
            $last_word = '';            
            }
        
        if (isset($content[$i])){
            $last_word = $last_word.$content[$i];
        }
    }
    
    return $dictionary;
}

$dictionary = [];
$listagemDosArquivos = [];
$listaDeSentencas = [];

$server = "http://localhost/detect-structure-language/v0/";
$path = "series/friends/";
$diretorio = dir($path);

while($arquivo = $diretorio -> read()){
$arquivoFinal = $server.$path.$arquivo;
array_push($listagemDosArquivos, $arquivoFinal);
}
$diretorio -> close();

foreach ($listagemDosArquivos as $key => $value) {
    $source = file_get_contents("$arquivoFinal");
    $source = strip_tags($source);
    $result = captureWords($source, $dictionary);

    $limitDictionary = count($result);
    // Montador de sentenças atua
    for ($i=0; $i < $limitDictionary; $i++) {

        $j = $i + 1;
        $k = $i + 2; 
        $l = $i + 3;
        $m = $i + 4;
        $n = $i + 5;
        $o = $i + 5;

        $sentenca3words = "$result[$i] $result[$j] $result[$k]";
        $sentenca4words = "$result[$i] $result[$j] $result[$k] $result[$l]";
        $sentenca5words = "$result[$i] $result[$j] $result[$k] $result[$l] $result[$m]";
        //$sentenca6words = "$result[$i] $result[$j] $result[$k] $result[$l] $result[$m] $result[$n]";
        //$sentenca7words = "$result[$i] $result[$j] $result[$k] $result[$l] $result[$m] $result[$n] $result[$o]";
        // As sentenças são salvas em um array
        //registerNewSentence($result[$i]);
        registerNewSentence($sentenca3words);
        //array_push($listaDeSentencas, $sentenca3words);
        //array_push($listaDeSentencas, $sentenca4words);
        //array_push($listaDeSentencas, $sentenca5words);
        //array_push($listaDeSentencas, $sentenca6words);
        //array_push($listaDeSentencas, $sentenca7words);

        // Cada sentença detectada é pesquisada e retorna a quantidade
        /*$read = file_get_contents("http://localhost/detect-structure-language/v0/api.php?acao=busca&palavra=".$palavraChave);
        $data = json_decode($read);
        $number = $data->result;*/
        
        //echo "<p>$sentenca ===> $number";
    }
}



// A sentença é salva no banco de dados com
/*
$fimDaLista = count($listaDeSentencas);

foreach ($listaDeSentencas as $key => $value) {
   
    echo "<script>window.document.getElementById(\"status\").innerHTML = '$key / $fimDaLista';</script>";
    registerNewSentence($value);
    //echo "<iframe src='http://localhost/detect-structure-language/v0/api.php?acao=busca&palavra=$value' frameborder='1'></iframe>";
}
*/
//var_dump($listaDeSentencas);





?>



<div id="status"></div>

