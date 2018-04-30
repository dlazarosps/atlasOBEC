$('#loading').fadeOut('fast');
var chartHeight = $('.chart').height();
var chartWidth = $('.chart').width()+25;

/*==== Linhas JS ====*/
var config = "?var=" + vrv + "&deg=" + deg + "&uf=" + uf + "&atc=" + atc + "&slc=" + slc + "&cad=" + cad + "&uos=" + uos + "&ano=" + ano + "&prt=" + prt + "&ocp=" + ocp + "&sex=" + sex + "&fax=" + fax + "&esc=" + esc + "&cor=" + cor + "&typ=" + typ + "&prc=" + prc + "&frm=" + frm + "&prv=" + prv + "&snd=" + snd + "&mec=" + mec + "&mod=" + mod + "&pfj=" + pfj + "&eixo=" + eixo;

// var info = [];
var dados = {key: [], value: []};

// import colors.json file
var colorJSON;
var textJSON;
var colors = [];
d3.json('data/colors.json', function (error, data) {
    if (error) throw error;
    colorJSON = data;

    // import pt-br.json file for get the title
    d3.json('data/pt-br.json', function (error, data) {
        if (error) throw error;

        textJSON = data;

        var config = "?var=" + vrv + "&deg=" + deg + "&uf=" + uf + "&atc=" + atc + "&slc=" + slc + "&cad=" + cad + "&uos=" + uos + "&ano=" + ano + "&prt=" + prt + "&ocp=" + ocp + "&sex=" + sex + "&fax=" + fax + "&esc=" + esc + "&cor=" + cor + "&typ=" + typ + "&prc=" + prc + "&frm=" + frm + "&prv=" + prv + "&snd=" + snd + "&mec=" + mec + "&mod=" + mod + "&pfj=" + pfj + "&eixo=" + eixo;

        d3.queue()
            .defer(d3.json, "./db/json_linhas.php" + config)
            .await(analyze);
    });

});

$.get("./db/json_linhas.php"+config, function(data) {

});
/*
function getIdCadeia(nomecadeia){
    switch(nomecadeia){
        case "Editorial":
        case "Cultura Digital":
        case "Arquitetura e Design":
        case "Artes Cênicas e Espetáculos":
        case "Editorial":
        case "Editorial":
        case "Editorial":
        case "Editorial":
        case "Editorial":
    }
}
*/
function analyze(error, data) {

    //console.log(colorJSON)

    $('#loading').fadeOut('fast');

    if (error) {
        console.log(error)
    }

    var dados = [];
    var anos = [];

    Object.keys(data).forEach(function (key) {
        dados.push(data[key]);
        anos.push(key);

    });

    var keys = [];

    Object.keys(dados[0]).forEach(function (key) {
        if(key != "ano")
            keys.push(key);
    });






    //tamanho do grafico
    // AQUI automatizar map center
    var margin = {top: 20, right: 20, bottom: 40, left: 25},
        width = chartWidth - margin.left - margin.right,
        height = chartHeight - margin.top - margin.bottom;

    // parse the date / time
    var parseTime = d3.timeParse("%Y");

// set the ranges
    var x = d3.scaleTime().range([0, width]);
    var y = d3.scaleLinear().range([height, 0]);

    var valueline = d3.line()
        .x(function(d) { return x(d.ano); })
        .y(function(d) { return y(d.valor); });



    // append the svg obgect to the body of the page
    // appends a 'group' element to 'svg'
    // moves the 'group' element to the top left margin
    var svg = d3.select("#corpo").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");


        // Get the data


        // format the data
        dados.forEach(function(d) {

            $.each( d, function( i, deg ) {

                if(i == "ano"){
                    d[i] = parseTime(d[i]);
                }
                else{
                    d[i] = +d[i]
                }

            })

        });


        var data = [];
        var valoresBrutos = [];

        $.each( keys, function( i, deg ) {

            var valores = [];
            var obj = {};

            Object.keys(dados).forEach(function (key) {

                obj['ano'] = dados[key]['ano'];
                obj['deg'] = deg;
                obj['valor'] = dados[key][deg];
                valoresBrutos.push(dados[key][deg]);
                valores.push({'ano': dados[key]['ano'], 'deg': deg, 'valor': dados[key][deg]})
            });

            data.push(valores)

        });



        // Scale the range of the data
        x.domain(d3.extent(dados, function(d) { return d.ano; }));

        var tooltipInstance = tooltip.getInstance();


        var min = d3.min(valoresBrutos, function(d) {
           return Math.min(d); });

        var max = d3.max(valoresBrutos, function(d) {
            return Math.max(d); });

        if(!(eixo == 0 && vrv > 9)){
            if(min >= 0)
                min = 0;
        }


        y.domain([min, max]);


        Object.keys(data).forEach(function (i) {

            scc = data[i][0].deg;

            svg.append("path")
                .data([data[i]])
                .attr("class", "line")
                .attr("scc", scc)
                .style("opacity",  function(d){
                    if(url['cad'] != 0 ){
                        if(getCadId(scc) == url['cad'])
                            return 1;
                        else return 0.2;
                    }
                    else
                        return 1;})
                .style("stroke-width", function(d){return 2;})
                .style("stroke", color(scc))
                .attr("d", valueline);
           // d3.selectAll("path").style("opacity", function(d, i){if(deg == i+1 || deg == 0) return 1; else return 0.3})
        });


        // Add the X Axis
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x))
            .attr("class", "x");

        // Add the Y Axis
        svg.append("g")
            .call(d3.axisLeft(y))
            .attr("class", "y");

    svg.selectAll("path")
            .on("mouseover", function (dados) {
                mousemove(dados, (this));

                if(url['cad'] == 0){
                    //d3.selectAll("path").style("opacity",  0.3)
                    d3.select(this).style("opacity", 1)
                }
            })
            .on("mouseout", function () {
                tooltipInstance.hideTooltip();

                if(url['cad'] == 0){
                    d3.selectAll("path").style("opacity", 1)
                }
            })

        var coordsAxisX = [];
        var coordsAxisY = [];


        d3.selectAll('.x g').each(function (d, index) {
            transform = d3.select(this).attr('transform')
            transform = transform.replace('translate(', '');

            x = parseFloat(transform.split(',')[0]);
            y = parseFloat(transform.split(',')[1].replace(')', ''));
            coordsAxisX.push({'ano': anos[index], 'x': x, 'y': y})
        })

        d3.selectAll('.y g').each(function (d, index) {
            transform = d3.select(this).attr('transform')
            transform = transform.replace('translate(', '');

            x = parseFloat(transform.split(',')[0]);
            y = parseFloat(transform.split(',')[1].replace(')', ''));
            coordsAxisY.push({'ano': anos[index], 'x': x, 'y': y})
        })

        function mousemove(d, path) {

            if(!($(path).hasClass("domain")) ){
                var scc = ($(path).attr("scc"));

                var ano = 2007;

                for (var i = 1; i < coordsAxisX.length; i++) {


                     calc1 = (Number(coordsAxisX[i - 1].x) + Number(coordsAxisX[i].x)) / 2;
                     if(i <= coordsAxisX.length - 2)
                        calc2 = (Number(coordsAxisX[i].x) + Number(coordsAxisX[i + 1].x)) / 2;
                     else
                        calc2 = coordsAxisX[i].x;


                    if (d3.mouse(d3.event.currentTarget)[0] >= calc1 && d3.mouse(d3.event.currentTarget)[0] <= calc2) {
                        ano = anos[i];
                        break;
                    }

                }

                var valor = 2;


                Object.keys(dados).forEach(function (key) {
                    if(dados[key].ano.getFullYear() == ano)
                        valor = dados[key][scc];
                })



                if(eixo == 0){
                    if(vrv == 3){
                        valor =  formatNumber(valor*100, 2).toString().replace(".", "");
                        tooltipInstance.showTooltip(d, [
                            ["title", scc],
                            ["", valor+"%"]
                        ])
                    }
                    else if(vrv == 9){
                        valor =  formatNumber(valor*100, 6).toString().replace(".", "");
                        tooltipInstance.showTooltip(d, [
                            ["title", scc],
                            ["", valor+"%"]
                        ])
                    }

                }
                else{
                    valor =  formatNumber(valor, 2).toString().replace(".", "");
                    tooltipInstance.showTooltip(d, [
                        ["title", scc],
                        ["", valor]
                    ])
                }

            }


        }



        ///LEGENDA


        var fontColor = "#000"

        $.each( keys, function( i, deg ) {

            tamanhoVetor = keys.length;

            var height = 10;
            var width = 10;

            var widthTexto = 20;

            var OffsetX = 90;

            var tamanhoX = width + widthTexto;

            var posX = chartWidth - OffsetX - tamanhoX*i;
            var posY =  chartHeight*0.88;

            svg.append("g")
                .append("rect")
                .attr("x", posX)
                .attr("y", posY)
                .attr("height", height)
                .attr("width", width)
                .style("fill", color(deg))
                .style("strok   e-width", 1)
                .style("stroke", color(deg))
                .attr("scc", deg);

            svg.selectAll("rect")
                .on("mouseover", function (dados) {
                    tooltipInstance.showTooltip(dados, [
                        ["title", $(this).attr("scc")]
                    ])
                })
                .on("mouseout", function () {
                    tooltipInstance.hideTooltip();
                })


            svg.append("text")
                .attr("x", posX + widthTexto)
                .attr("y", posY + 8)
                .attr("fill", fontColor)
                //.text(deg);

        });



    function color(deg){
        colors = {
            "Setor": "#071342",
            "UF": "rgb(109, 191, 201)",
            "Relacionadas": "#071342",
            "Culturais": "rgb(109, 191, 201)",
            "Despesa Minc / Receita executivo": "#071342",
            "Financiamento Estatal / Receita executivo": "rgb(109, 191, 201)",

            "ValorTransacionado": "#077DDD",
            "Importação": "#8178AF",
            "Exportação": "#EC8A91",
            "SaldoComercial": "#E96B00",

            "1": "#071342",
            "2": "rgb(109, 191, 201)",
            "3": "#071342",
            "4": "rgb(109, 191, 201)",
            "5": "#071342",
            "6": "rgb(109, 191, 201)",
            "7": "#8178AF",
            "8": "#EC8A91",

            "Sim": "#071342",
            "Não": "rgb(109, 191, 201)",

            "Branca": "#EC8A91",
            "Parda": "rgb(109, 191, 201)",
            "Preta": "black",
            "Amarela": "yellow",
            "Indígena": "green",

            "Micro": "rgb(109, 191, 201)",
            "Médio": "black",
            "Grande": "yellow",
            "Pequeno": "green",

            "Sem instrução": "#071342",
            "Fundamental incompleto": "#077DDD",
            "Fundamental completo": "#8178AF",
            "Médio completo": "#EC8A91",
            "Superior incompleto": "#E96B00",
            "Superior completo": "rgb(109, 191, 201)",
            "Não determinado": "red",


            "10 a 17": "#071342",
            "18 a 29": "#077DDD",
            "30 a 49": "#8178AF",
            "50 a 64": "#EC8A91",
            "65 ou mais": "rgb(109, 191, 201)",
            "Não classificado": "red",

            "Masculino": "#071342",
            "Feminino": "#E96B00",



        }


        Object.keys(colorJSON.cadeias).forEach(function (i, key) {
            colors[colorJSON.cadeias[i].name] = colorJSON.cadeias[i].color;
        });
        return colors[deg];

    }

    function getCadId(cadName){
        switch(cadName){
            case "Arquitetura e Design": return 1;
            case "Artes Cênicas e Espetáculos": return 2;
            case "Audiovisual": return 3;
            case "Cultura Digital": return 4;
            case "Editorial": return 5;
            case "Educação e Criação em Artes": return 6;
            case "Entretenimento": return 7;
            case "Música": return 8;
            case "Patrimônio": return 9;
            case "Publicidade":  return 10;
        }
    }




}


