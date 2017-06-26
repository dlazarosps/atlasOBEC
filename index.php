<!DOCTYPE html>
<html>
	<head>
		<?php include 'head.php';?>
	</head>
	<body class="home">

		<section>
			<article>
				<div class="container-fluid">

					<div class="row">

						<!--=== logo! ===-->
						<div class="col-lg-4 col-md-5 col-xs-12">
							
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2 col-xxs-10 col-xxs-offset-1">
									<div class="home-info">
										<div class="content">

											<div class="logo-img text-center">
												<img src="images/logo.png" alt="Logo ATLAS" title="Atlas Econômico da Cultura Brasileira"/>
											</div>

											<div class="separator"></div>

											<div class="desc">

												<p>
													O PROJETO ATLAS ECONÔMICO DA CULTURA
													BRASILEIRA BUSCA, PRINCIPALMENTE,
													MENSURAR O IMPACTO DOS SETORES
													CULTURAIS E CRIATIVOS (SCC) SOBRE A
													EVOLUÇÃO DA ECONOMIA BRASILEIRA.
												</p>

												<p>
													ESSE ESFORÇO SERÁ ORGANIZADO EM
													TORNO DE QUATRO EIXOS TEMÁTICOS:
													EMPREENDIMENTOS CULTURAIS, MERCADO
													DE TRABALHO, POLÍTICAS PÚBLICAS E
													COMÉRCIO INTERNACIONAL.
												</p>

												<p>
													AO LONGO DE TODAS AS VARIÁVEIS, SERÁ
													PRIVILEGIADA A ANÁLISE EM TORNO DOS
													RECORTES SETORIAL E REGIONAL.
												</p>

											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<!--=== links ===-->
						<div class="col-lg-7 col-md-6 col-xs-10 col-xs-12 col-md-offset-0 col-xs-offset-1">

							<div class="row menu-home">
								
								<a href="page.php" class="img-link">
									<div class="col-sm-3 col-xs-6 menu-col">
										<div class="menu-item">

											<div class="video">
											    <video autoplay class="thevideo" loop preload="none">
											    	<source src="images/video1.mp4" type="video/mp4">
											    	<source src="images/video1.webm" type="video/webm">
											   		Navegador não compatível.
											    </video>

											</div>

											<div class="menu-content" id="item1">

												<div class="text-wrapper">
													<div class="square-icon"></div>
													<div class="text"><p>EMPRENDIMENTOS<br/> CULTURAIS</p></div>	
												</div>

											</div>
										</div>
									</div>
								</a>

								<a href="#" class="img-link">
									<div class="col-sm-3 col-xs-6 menu-col">
										<div class="menu-item">
											<div class="menu-content" id="item2">

												<div class="text-wrapper">
													<div class="square-icon"></div>
													<div class="text"><p>MERCADO<br/>DE TRABALHO</p></div>
												</div>

												<p class="soon">EM BREVE</p>

											</div>
										</div>
									</div>
								</a>

								<a href="#" class="img-link">
									<div class="col-sm-3 col-xs-6 menu-col">
										<div class="menu-item">
											<div class="menu-content" id="item3">

												<div class="text-wrapper">
													<div class="square-icon"></div>
													<div class="text"><p>POLÍTICAS<br/>PÚBLICAS</p></div>
												</div>

												<p class="soon">EM BREVE</p>

											</div>
										</div>
									</div>
								</a>

								<a href="#" class="img-link">
									<div class="col-sm-3 col-xs-6 menu-col">
										<div class="menu-item">
											<div class="menu-content" id="item4">

												<div class="text-wrapper">
													<div class="square-icon"></div>
													<div class="text"><p>COMÉRCIO<br/>INTERNACIONAL</p></div>
												</div>

												<p class="soon">EM BREVE</p>
												
											</div>
										</div>
									</div>
								</a>

							</div>
						</div>

						<!--=== neccult ===-->
						<div class="col-md-1 col-xs-1 col-xxs-12">
							<div class="row">
								<div class="neccult-info">
									<div class="content">
										<a href="http://obec.ufrgs.br/neccult/" target="_blank">
											<img src="images/neccult.png" class="logo-neccult hidden-xxs" alt="Neccult"/>
											<img src="images/neccult_mobile.png" class="logo-neccult show-xxs" alt="Neccult"/>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
		</section>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">


			/*======
				ALTO CONTRASTE (replicado no main.js)
			======*/
			var createCookie = function(name, value, days) {
			    var expires;
			    if (days) {
			        var date = new Date();
			        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			        expires = "; expires=" + date.toGMTString();
			    }
			    else {
			        expires = "";
			    }
			    document.cookie = name + "=" + value + expires + "; path=/";
			}

			function getCookie(c_name) {
			    if (document.cookie.length > 0) {
			        c_start = document.cookie.indexOf(c_name + "=");
			        if (c_start != -1) {
			            c_start = c_start + c_name.length + 1;
			            c_end = document.cookie.indexOf(";", c_start);
			            if (c_end == -1) {
			                c_end = document.cookie.length;
			            }
			            return unescape(document.cookie.substring(c_start, c_end));
			        }
			    }
			    return "";
			}
			var dark = getCookie('dark');

			function bodyDark(active){

				if(active==1){
					$('body').addClass('dark');
				}else{
					$('body').removeClass('dark');
				}
			}

			/* ajusta o tamanho do vídeo, 
				para seguir da altura do container */
			function videoHeight(){
				$('.menu-item').find('.video').each(function(index){
					var parentHeight = $(this).parents('.menu-item').height();
					$(this).height(parentHeight);
				});
			}

			/* quando a janela é carregada */
			$(window).bind("load", function() { 
				videoHeight();

				bodyDark(dark);/* alto contraste */

			});

			$(document).ready(function(){				

				/* se a janela for redimensionada */
				$(window).resize(function() {
					videoHeight();
				});

				/***************** alto contraste **************** (replicado no main.js )*/
				$(document).on('click', "#contraste", function(){
					
					var darkValue = getCookie("dark");

					if(darkValue==0){
						createCookie('dark',1,'30');
						darkValue=1;
					}else if(darkValue==1){
						createCookie('dark',0,'30');
						darkValue=0;
					}
					bodyDark(darkValue);
				});

			});
		</script>
	</body>
</html>