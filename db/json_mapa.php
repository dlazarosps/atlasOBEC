<?php 
/*-----------------------------------------------------------------------------
Função: Mapa
    função para gerar um JSON para o Gráfico Mapa
Entrada: 
    $_GET = Parâmetros para consulta EixoUm::getter_mapa
Saída:
    Dados formatados para o JSON Mapa
-----------------------------------------------------------------------------*/

header('charset=utf-8');

if (!empty($_GET["var"])) {

	$var = $_GET["var"];

	$atc = $_GET["atc"];
	$cad = $_GET["cad"];
	$prt = $_GET["prt"];
    $ocp = $_GET["ocp"];
	$ano = $_GET["ano"];
	$eixo = $_GET['eixo'];
}
else{
	$var = 1;
	
	$atc = 0;
	$cad = 0;
	$prt = 0;
	$ocp = 0;
	$ano = 2014;
	$eixo = 0;
}

$mapa = array();
if($eixo == 0) {
    require_once("EixoUm.php");
	foreach (EixoUm::getter_mapa($var, $atc, $cad, $prt, $ano) as $tupla) {

        /*
            $mapa[$tupla->idUF] = [

                'id' => (int) $tupla->idUF,
                'uf' => $tupla->UFNome,
                'valor' => (double) $tupla->Valor
            ];
        */


        $id = $tupla->idUF;
        $mapa[$id]['id'] = (int) $tupla->idUF;
        $mapa[$id]['uf'] = $tupla->UFNome;
        $mapa[$id]['valor'] = (double) $tupla->Valor;
        $mapa[$id]['percentual'] = (double) $tupla->Percentual;
        $mapa[$id]['taxa'] = (double) $tupla->Taxa;


    }
}
else if($eixo == 1) {
    require_once("EixoDois.php");
    foreach (EixoDois::getter_mapa($var, $cad, $ocp, $ano) as $tupla) {

        /*
            $mapa[$tupla->idUF] = [

                'id' => (int) $tupla->idUF,
                'uf' => $tupla->UFNome,
                'valor' => (double) $tupla->Valor
            ];
        */


        $id = $tupla->idUF;
        $mapa[$id]['id'] = (int) $tupla->idUF;
        $mapa[$id]['uf'] = $tupla->UFNome;
        $mapa[$id]['valor'] = (double) $tupla->Valor;
        $mapa[$id]['percentual'] = (double) $tupla->Percentual;
        $mapa[$id]['taxa'] = (double) $tupla->Taxa;


    }
}
else if($eixo == 2) {
    require_once("EixoTres.php");
    foreach (EixoTres::getter_mapa($var, $atc, $cad, $prt, $ano) as $tupla) {

        /*
            $mapa[$tupla->idUF] = [

                'id' => (int) $tupla->idUF,
                'uf' => $tupla->UFNome,
                'valor' => (double) $tupla->Valor
            ];
        */


        $id = $tupla->idUF;
        $mapa[$id]['id'] = (int) $tupla->idUF;
        $mapa[$id]['uf'] = $tupla->UFNome;
        $mapa[$id]['valor'] = (double) $tupla->Valor;
        $mapa[$id]['percentual'] = (double) $tupla->Percentual;
        $mapa[$id]['taxa'] = (double) $tupla->Taxa;


    }
}
else if($eixo == 3) {
    require_once("EixoQuatro.php");
    foreach (EixoQuatro::getter_mapa($var, $atc, $cad, $prt, $ano) as $tupla) {

        /*
            $mapa[$tupla->idUF] = [

                'id' => (int) $tupla->idUF,
                'uf' => $tupla->UFNome,
                'valor' => (double) $tupla->Valor
            ];
        */


        $id = $tupla->idUF;
        $mapa[$id]['id'] = (int) $tupla->idUF;
        $mapa[$id]['uf'] = $tupla->UFNome;
        $mapa[$id]['valor'] = (double) $tupla->Valor;
        $mapa[$id]['percentual'] = (double) $tupla->Percentual;
        $mapa[$id]['taxa'] = (double) $tupla->Taxa;


    }
}

//var_dump($mapa);
// echo json_encode($mapa, JSON_UNESCAPED_UNICODE);
echo json_encode($mapa);

?>
