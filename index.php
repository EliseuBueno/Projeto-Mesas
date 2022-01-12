
<?php include_once("../../conexao.php");
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os cursos da tabela
@$catego = $_GET['cat'];


if($catego == ""){
$result_loja = "SELECT * FROM lojas WHERE id_status =2";
$resultado_loja = mysqli_query($conn, $result_loja);
}else{
$result_loja = "SELECT * FROM lojas WHERE id_status =2 AND id_categoria = $catego";
$resultado_loja = mysqli_query($conn, $result_loja);
}

//Contar o total de cursos
$total_loja = mysqli_num_rows($resultado_loja);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 15;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total_loja/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;
      
//Selecionar os cursos a serem apresentado na página
$result_lojas = "SELECT * FROM lojas WHERE id_status =2 limit $incio, $quantidade_pg";
$resultado_lojas = mysqli_query($conn, $result_lojas);
$total_lojas = mysqli_num_rows($resultado_lojas);

session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../../img/nelore.ico" />
		<title>Mesas</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<link rel="stylesheet" href="css/fontello.css">
		<!--<link rel="stylesheet" type="text/css" href="css/style.css"/>-->

	</head>
    <style>

    header{
        width: 100%;
        height: 100%;
        overflow: hidden;

    }

    .img-site{
    background-image: url(../../img/pes.jpg);
	background-position: center top;
	background-repeat: no-repeat;
	background-size: cover;
	background-attachment: fixed;
	color: #ffffff;
	padding-top: 250px;
	padding-bottom: 250px;
        }

    .footer-site{
    background-image: url(../../img/pes.jpg);
	background-position: center top;
	background-repeat: no-repeat;
	background-size: cover;
	background-attachment: fixed;
	color: #ffffff;
	padding-top: 100px;
	padding-bottom: 100px;
}
.rodape{
    background-color: rgba(0,0,0,0.7);
}

.footer{
	background: black;
    opacity: 0.8;    
}
.rodape:hover{
	background: black;
    opacity: 0.8;
}
.grow:hover
{
        -webkit-transform: scale(1.1);
        -ms-transform: scale(1.1);
        transform: scale(1.1);
        /* background: blue; */
        opacity: 0.7;
}

    </style>    
	<body>
			<!--<nav class="navbar navbar-inverse navbar-fixed-top">-->
      <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top bg-dark">

        <div class="container">
          <a class="navbar-brand" href="#">NELORE</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="#"> 
                  <i class="icon-home" aria-hidden="true"></i>
                  Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../meus-pedidos.php">Meus Pedidos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#">
                  <i class="icon-basket" aria-hidden="true"></i>
                  Comanda
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Buscar Por
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Produtos</a>
                  <a class="dropdown-item" href="#">Mesas</a>
                  <div class="dropdown-divider"></div>
                  <?php
                    if(empty($_SESSION['id'])){?> 
                        <a class="dropdown-item" href="login.php">Login</a>  
                <?php } ?>
                <?php
                  if(!empty($_SESSION['id'])){?>
                    <a class="dropdown-item" href="sair.php">Sair</a>
                <?php } ?>
                </div>
              </li>
              

                </a>
              </li>
            </ul>
            
            <form class="form-inline my-2 my-lg-0" method="GET" action="pesquisar.php">
            <div class="container">
              <input type="search" name="pesquisar" class="form-control" id="exampleInputName2" placeholder="Pesquisar..." aria-label="Pesquisar">
              <button class="btn btn-primary" type="submit">
                <i class="icon-search" aria-hidden="true"></i>
              </button>
            </div>
          </form>
          </div>
        </div>
    </nav>
  <br><br><br>
    <div class="container">
      <p class="h6">
        <?php
          if(!empty($_SESSION['id'])){
            echo "Olá ".$_SESSION['nome'].", Bem vindo à Espetaria Nelore!";
          }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Área restrita!</div>";
            header("Location: login.php");  
          }
        ?>
      </p>
    </div>
	<div class="container">
		
		<div class="row">
			

		<div class="container theme-showcase" role="main">
		
		<div class="page-header">
				<div class="row text-center">
					<div class="col-sm-12 col-md-12">
						<h1>MESAS</h1>
					</div>
					
				</div>
			</div>
		<br>
			<div class="row">
				<?php 
		            if(isset($_GET['cat']) && $_GET['cat'] !=''){
		              $id_cat = $_GET['cat'];
		              $sql_categoria = "AND id_categoria = '".$id_cat."'";
		            }else{
              			$sql_categoria = "";
            		}
              		$read_loja = mysqli_query($conn, "SELECT * FROM lojas WHERE id_status=2 AND id_loja != '' {$sql_categoria} limit $incio, $quantidade_pg"); 
          		?>
				<?php while($rows_lojas = mysqli_fetch_assoc($read_loja)){ ?>
					<div class="col-lg-2 col-md-6 mb-2 grow">
			            <div class="card h-100">
			              
			              <div class="card-body">
			                <h4 class="card-title">
			                  <a href="../<?php echo $rows_lojas['link'];?>"><?php echo $rows_lojas['loja'];?></a>
			                </h4>
			                
			              </div>
			            </div>
			          </div>
				<?php } ?>
			</div>
			<?php
				//Verificar a pagina anterior e posterior
				$pagina_anterior = $pagina - 1;
				$pagina_posterior = $pagina + 1;
			?>
			<nav aria-label="Navegação de página">
				<ul class="pagination justify-content-center">
					<li class="page-item">
						<?php
						@$get = $_GET['cat'];
						if($pagina_anterior != 0){ ?>
							<a href="index.php?cat=<?php echo $get; ?>&pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous" class="page-link">
								<span aria-hidden="true">&laquo;</span>
        						<span class="sr-only">Anterior</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true" class="sr-only">&laquo;</span>
					<?php }  ?>
					</li>
					<?php 
					//Apresentar a paginacao
					for($i = 1; $i < $num_pagina + 1; $i++){ ?>
						<?php
						if (@$_GET['pagina']==$i){ ?>
						<li class="page-item active">
						<?php } ?>
							<a href="index.php?cat=<?php echo $get; ?>&pagina=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
					<?php } ?>
					<li class="page-item">
						<?php
						if($pagina_posterior <= $num_pagina){ ?>

							<a href="index.php?cat=<?php echo $get; ?>&pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous" class="page-link">
								<span aria-hidden="true">&raquo;</span>
        						<span class="sr-only">Próximo</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true" class="sr-only disabled">&raquo;</span>

					<?php }  ?>
					</li>
				</ul>
			</nav>
		</div>

	</div>
</div>
		</section>

		<section class="footer-site">
			<div class="container">
				<div class="footer row">
				
					<div class="col-lg-4 col-md-6 mb-4">
                    <br>
			            <div class="rodape card h-100">
			              
			              <div class="card-body text-center">
			                
			                <h1 class="card-title">
			                	<p class="h1">NELORE</p>
			                </h1>
			                <p class="h6">A melhor Espetaria de Indaiatuba!</p>
			                <p class="text-center">
							<a href="#" class="btn btn-danger">Cadastre-se</a>
                            
						</p>
			              </div>
			                
			            </div>
			        </div>

					<div class="col-lg-4 col-md-6 mb-4">
                    <br>
			            <div class="rodape card h-100">
			              
			              <div class="card-body">
			                
			                <h4 class="card-title">
			                	<p class="h5">PÁGINAS:</p>
			                </h4>
			                	<p class="card-text">
			                		<a href="http://nelore.epizy.com/loja/espetaria/mesas" class="text-white">Home</a>
			                	<p class="card-text">
			                		<a href="#" class="text-white">Produtos</a>
			                		</p>
			                	<p class="card-text">
			                		<a href="http://nelore.epizy.com/loja/espetaria/mesas" class="text-white">Mesas</a>
			                	</p>
			                	<p class="card-text">
			                		<a href="http://nelore.epizy.com/loja/meus-pedidos.php" class="text-white">Pedidos</a>
			                	</p>
			              </div>
			              
			            </div>
			        </div>
              
					<div class="col-lg-4 col-md-6 mb-4">
                    <br>
			            <div class="rodape card h-100 ">
			              
			              <div class="card-body">
			                
			                <h4 class="card-title">
			                	<p class="h5">CONTATO:</p>
			                </h4>
			                	<p class="card-text">
			                		<i class="icon-mail" aria-hidden="true">neloreespetaria@gmail.com</i>
			                		</p>
			                	<p class="card-text">
			                		<a class="icon-whatsapp text-success" target="_blank" href="https://chatdireto.com/19978151086" aria-hidden="true"></a>
                                    (19) 9 7815-1086
			                		</p>
			                	<p class="card-text">Disk Entrega: (19) 3835-2506</p>
			                	<p class="card-text">Cidade: Indaiatuba/SP</p>
			                	<p class="card-text">CNPJ: 35.056.782/0001-56</p>
                                <a class="btn btn-primary text-center" target="_blank" href="https://facebook.com"> 
		                        <i class="icon-facebook" aria-hidden="true"></i>
                                <a class="btn btn-danger text-center" target="_blank" href="https://www.instagram.com/neloreespetaria/"> 
		                        <i class="icon-instagram" aria-hidden="true"></i>
		                    </a>
		                    </a>
			              </div>
			              
			            </div>
			        </div>
			        
				</div>
                <div class="col-sm-12 col-md-12">
                    <br><br>
						<p class="m-0 text-center text-white">Copyright &copy; Eliseu S. Bueno - <a target="_blank" href="https://www.smarthsystem.com.br">www.smarthsystem.com.br  </a><?php echo date('Y'); ?></p>
					</div>
			</div>
		</section>		
		


		<!--
			<script type="text/javascript">
				$('#exampleModal').on('show.bs.modal', function (event) {
					var button = $(event.relatedTarget)
					var recipient = button.data('whatever')
					var recipientnome = button.data('whatevernome')
					var recipientdetalhes = button.data('whateverdetalhes')
					var modal = $(this)
					modal.find('.modal-title').text('ID do Produto: ' + recipient)
					modal.find('#id_produto').val(recipient)
					modal.find('#recipient-name').val(recipientnome)
					modal.find('#detalhes-text').val(recipientdetalhes)
				})
			</script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		-->

	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>