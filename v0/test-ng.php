<?php error_reporting(0);

$palavraChave = $_GET['palavra'];

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

$server = "http://localhost/detect-structure-language/v0/";
$path = "series/";
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
// Deterctor de sentenças atua
    for ($i=0; $i < $limitDictionary; $i++) {
        $j = $i + 1;
        $k = $j + 1; 
        $l = $k + 1; 
        $sentenca = "$result[$i] $result[$j] $result[$k] $result[$l]";
        // Cada sentença detectada é pesquisada e retorna a quantidade
        $read = file_get_contents("http://localhost/detect-structure-language/v0/api.php?acao=busca&palavra=".$palavraChave);
        $data = json_decode($read);
        $number = $data->result;
        // A sentença é salva no banco de dados com
        echo "<p>$sentenca ===> $number";
    }
}
    
        
            





?>