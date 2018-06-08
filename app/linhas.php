<head>
    <?php include 'head.php';?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- D3 JS v4 -->
    <script src="js/d3/d3.min.js" charset="utf-8"></script>

    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.21.0/d3-legend.min.js"></script>

    <!-- D3 QUEUE -->
    <script src="https://d3js.org/d3-queue.v3.min.js"></script>

    <!-- Utilidades -->
    <script src="js/functions.js"></script>
    <script src="js/descricoes.js"></script>

    <div id="corpo" class="fadeIn"></div>

</head>

<?php if(isset($_GET["var"])):?>

    <?php
    /* GETS! */
    $uf     =   isset($_GET["uf"])    ?   $_GET["uf"]   :   0;	   /*== uf ==*/
    $ano    =   isset($_GET["ano"])   ?   $_GET["ano"]  :   2014;	   /*== ano ==*/
    $prt    =   isset($_GET["prt"])   ?   $_GET["prt"]  :   0;	   /*== porte ==*/
    $cad    =   isset($_GET["cad"])   ?   $_GET["cad"]  :   0;	   /*== ocupacao ==*/
    $var    =   isset($_GET["var"])   ?   $_GET["var"]  :   0;	   /*== variavel ==*/
    $ocp    =   isset($_GET["ocp"])   ?   $_GET["ocp"]  :   1;	   /*== ocupacao ==*/
    $view   =   isset($_GET["view"])  ?   $_GET["view"] :   "mapa";	   /*== visualizacao ==*/
    $eixo   =   isset($_GET["eixo"])  ?   $_GET["eixo"] :   "empreendimento";	   /*== eixo ==*/
    $slc    =   isset($_GET["slc"])   ?   $_GET["slc"]  :   0;	   /*== Visualização ==*/
    $deg    =   isset($_GET["deg"])   ?   $_GET["deg"]  :   0;	   /*== Desagregação ==*/
    $mec    =   isset($_GET["mec"])   ?   $_GET["mec"]  :   0;	   /*== Mecanismo ==*/
    $mod    =   isset($_GET["mod"])   ?   $_GET["mod"]  :   0;	   /*== Modalidade ==*/
    $pfj    =   isset($_GET["pfj"])   ?   $_GET["pfj"]  :   0;	   /*== Tipo de pessoa ==*/
    $uos    =   isset($_GET["uos"])   ?   $_GET["uos"]  :   0;	   /*== UF ou Setor ==*/
    $prc    =   isset($_GET["prc"])   ?   $_GET["prc"]  :   0;	   /*== Parceiro ==*/
    $typ    =   isset($_GET["typ"])   ?   $_GET["typ"]  :   0;	   /*== Tipo de atividade ==*/

    /* informações JSON */
    $json = file_get_contents('data/pt-br.json');
    $json_text = json_decode($json, true);

    foreach($json_text['var'][3] as $key=>$vrbs){
        if($vrbs['id'] == $_GET["var"]){
            $vrb = $key;
            break;
        }
    }

    if($eixo == "empreendimentos") {
        $text = $json_text['var'][0][$key]; /*== informações da variável ==*/
    }
    else if($eixo == "mercado") {
        $text = $json_text['var'][1][$key]; /*== informações da variável ==*/
    }
    else if($eixo == "politicas") {
        $text = $json_text['var'][2][$key]; /*== informações da variável ==*/
    }
    else if($eixo == "comercio") {
        $text = $json_text['var'][3][$key]; /*== informações da variável ==*/
    }
    $select = $json_text['select'];			   /*== informação dos selects ==*/

    /*
        busca a view do gráfico,
        se esta não existir busca a
        primeira declarada no json
    */
    $eixo_num = 0;
    switch($eixo) {
        case "empreendimento":
            $eixo_num = 0;
            break;
        case "mercado":
            $eixo_num = 1;
            break;
        case "politicas":
            $eixo_num = 2;
            break;
        case "comercio":
            $eixo_num = 3;
    }

    if(!isset($text[$view])) $view = $text['type'][0]['id'];

    $descView = $json_text[$view];			   /*== descrição da visualização ==*/
    ?>
<?php endif; ?>

<div class="container-chart">
    <div class="content">
        <div class="chart">
            <?php

            if (!empty($_GET["var"]))
                $var = $_GET["var"];
            else
                $var = 1;

            if (!empty($_GET["uf"]))
                $uf = $_GET["uf"];
            else
                $uf = 0;

            if (!empty($_GET["cad"]))
                $cad = $_GET["cad"];
            else
                $cad = 0;

            if (!empty($_GET["prt"]))
                $prt = $_GET["prt"];
            else
                $prt = 0;

            if (!empty($_GET["ocp"]))
                $ocp = $_GET["ocp"];
            else
                $ocp = 0;

            if (!empty($_GET["deg"]))
                $deg = $_GET["deg"];
            else
                $deg = 0;

            if (!empty($_GET["subdeg"]))
                $subdeg = $_GET["subdeg"];
            else
                $subdeg = 0;

            if (!empty($_GET["slc"]))
                $slc = $_GET["slc"];
            else
                $slc = 0;

            if (!empty($_GET["mec"]))
                $mec = $_GET["mec"];
            else
                $mec = 0;

            if (!empty($_GET["mod"]))
                $mod = $_GET["mod"];
            else
                $mod = 0;

            if (!empty($_GET["pfj"]))
                $pfj = $_GET["pfj"];
            else
                $pfj = 0;

            if (!empty($_GET["uos"]))
                $uos = $_GET["uos"];
            else
                $uos = 0;

            if (!empty($_GET["typ"]))
                $typ = $_GET["typ"];
            else
                $typ = 0;

            if (!empty($_GET["prc"]))
                $prc = $_GET["prc"];
            else
                $prc = 0;

            if (!empty($_GET["ano"]))
                $ano = $_GET["ano"];
            else
                $ano = NULL;


            ?>
            <script type="text/javascript">
                //variaveis configuracao query
                var vrv = <?php echo $var; ?>;
                var cad = <?php echo $cad; ?>;
                var prt = <?php echo $prt; ?>;
                var ocp = <?php echo $ocp; ?>;
                var mec = <?php echo $mec; ?>;
                var mod = <?php echo $mod; ?>;
                var pfj = <?php echo $pfj; ?>;
                var uos = <?php echo $uos; ?>;
                var typ = <?php echo $typ; ?>;
                var prc = <?php echo $prc; ?>;
                var deg = <?php echo $deg; ?>;
                var subdeg = <?php echo $subdeg; ?>;
                var slc = <?php echo $slc; ?>;
                var ano = <?php if($ano == NULL) echo "null"; else echo $ano; ?>;
                var uf = <?php echo $uf; ?>;
                var eixo;
                switch(window.location.hash.substring(1)) {
                    case "empreendimentos":
                        eixo = 0;
                        break;
                    case "mercado":
                        eixo = 1;
                        break;
                    case "politicas":
                        eixo = 2;
                        break;
                    case "comercio":
                        eixo = 3;
                        break;
                    default:
                        eixo = 0;
                }
            </script>

            <script src="js/linhas.js"></script>
        </div>
    </div>
</div>
<div id="loading"></div>
<!---/* url atual para o js */-->
<script type="text/javascript">
    var url = {
        view:"<?php echo $view; ?>",
        var:"<?php echo $var; ?>",
        prt:"<?php echo $prt; ?>",
        cad:"<?php echo $cad; ?>",
        deg:"<?php echo $deg; ?>",
        ocp:"<?php echo $ocp; ?>",
        ano:"<?php echo $ano; ?>",
        uos:"<?php echo $uos; ?>",
        uf:"<?php echo $uf; ?>"
    };
    <?php if ($eixo == "mercado" && $view != "mapa") {?>
    url['subdeg'] = "<?php echo $subdeg; ?>";
    <?php } ?>

    <?php if ($eixo == "mercado" && $view == "lines_scc") {?>
    url['slc'] = "<?php echo $slc; ?>";
    url['deg'] = "<?php echo $deg; ?>";
    url['subdeg'] = "<?php echo $subdeg; ?>";
    <?php } ?>

    <?php if ($eixo == "mercado" && $view == "barras") {?>
    url['slc'] = "<?php echo $slc; ?>";
    url['deg'] = "<?php echo $deg; ?>";
    url['subdeg'] = "<?php echo $subdeg; ?>";
    <?php } ?>

    <?php if ($eixo == "politicas") {?>
    url['mec'] = "<?php echo $mec; ?>";
    url['mod'] = "<?php echo $mod; ?>";
    url['pfj'] = "<?php echo $pfj; ?>";
    url['uos'] = "<?php echo $uos; ?>";
    <?php } ?>

    <?php if ($eixo == "comercio") {?>
    url['typ'] = "<?php echo $typ; ?>";
    url['prc'] = "<?php echo $prc; ?>";
    <?php } ?>
    var pageTitle = "<?php echo strip_tags($text['title'])?>";
</script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/contraste.js"></script>