
<?php include_once("conexao.php");
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina
session_start();
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
if(!isset($_GET['pesquisar'])){
	header("Location: index.php");
}else{
	$valor_pesquisar = $_GET['pesquisar'];
}


//Selecionar todos os cursos da tabela
$result_loja = "SELECT * FROM lojas WHERE WHERE status =2 AND loja LIKE '%$valor_pesquisar%'";
$resultado_loja = mysqli_query($conn, $result_loja);

//Contar o total de cursos
$total_loja = mysqli_num_rows($resultado_loja);

//Seta a quantidade de cursos por pagina
$quantidade_pg = 20;

//calcular o número de pagina necessárias para apresentar os cursos
$num_pagina = ceil($total_loja/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os cursos a serem apresentado na página
$result_lojas = "SELECT * FROM lojas WHERE status=2 AND loja LIKE '%$valor_pesquisar%' limit $incio, $quantidade_pg";
$resultado_lojas = mysqli_query($conn, $result_lojas);
$total_lojas = mysqli_num_rows($resultado_lojas);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../../img/nelore.ico" />
		<title>Mesas</title>
		<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<link rel="stylesheet" href="css/fontello.css">
		<!--<link rel="stylesheet" type="text/css" href="css/style.css"/>-->

	</head>
    <style>

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
                <a class="nav-link" href="meus-pedidos.php">Meus Pedidos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
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
    </div>	<div class="container">
		
		<div class="row">
			<div class="col-lg-3">

	        <h1 class="my-4">Categorias</h1>
	        <div class="list-group">
	          <?php
	          $read_categoria = mysqli_query($conn, "SELECT * FROM categoria ORDER BY categoria_descricao ASC");
	          if (mysqli_num_rows($read_categoria)> '0'){
	            foreach ($read_categoria as $read_categoria_view) {
	              echo '<a href="index.php?cat='.$read_categoria_view['categoria_id'].'" class="list-group-item">'.utf8_encode($read_categoria_view['categoria_descricao']).'</a>';
	            }
	          }
	          ?>

	        </div>

	      </div>
	      <!-- /.col-lg-3 -->

	      

		<div class="container theme-showcase" role="main">
			<div class="page-header">
				<div class="row text-center">
					<div class="col-sm-12 col-md-12">
						<h1>LOJAS</h1>
					</div>
					
				</div>
			</div>
		<br>
			<div class="row ">
				<?php 
		            if(isset($_GET['cat']) && $_GET['cat'] !=''){
		              $id_cat = $_GET['cat'];
		              $sql_categoria = "AND categoria_id = '".$id_cat."'";
		            }else{
              			$sql_categoria = "";
            		}
              		$read_loja = mysqli_query($conn, "SELECT * FROM lojas WHERE status=2 AND loja LIKE '%$valor_pesquisar%' AND id_loja != '' {$sql_categoria} limit $incio, $quantidade_pg ");
          		?>
				<?php while($rows_lojas = mysqli_fetch_assoc($read_loja)){ ?>
					<div class="col-lg-4 col-md-6 mb-4 grow">
			            <div class="card h-100">
			              <a href="../<?php echo $rows_lojas['link'];?>"><img class="card-img-top" src="<?php echo $rows_lojas['img']; ?>" alt=""></a>
			              <div class="card-body">
			                <h4 class="card-title">
			                  <a href="../<?php echo $rows_lojas['link'];?>"><?php echo utf8_encode($rows_lojas['loja']);?></a>
			                </h4>
			                
			                <p class="card-text"><?php echo utf8_encode($rows_lojas['descricao']);?></p>
			              </div>
			              <div class="card-footer">
			                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
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
							<a href="pesquisar.php?pesquisar=<?php echo $valor_pesquisar; ?>&pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous" class="page-link">
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
							<a href="pesquisar.php?pesquisar=<?php echo $valor_pesquisar; ?>&pagina=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a></li>
					<?php } ?>
					<li class="page-item">
						<?php
						if($pagina_posterior <= $num_pagina){ ?>

							<a href="pesquisar.php?pesquisar=<?php echo $valor_pesquisar; ?>&pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous" class="page-link">
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
			
				<section class="footer-site">
			<div class="container">
				<div class="footer row">
				
					<div class="col-lg-4 col-md-6 mb-4">
                    <br>
			            <div class="rodape card h-100">
			              
			              <div class="card-body text-center">
			                
			                <h1 class="card-title">
			                	<p class="h1">YES NOW</p>
			                </h1>
			                <p class="h6">O Seu shopping é Aqui!</p>
			                <p class="text-center">
							<a href="https://yesnow.ml/cadastrar.php" class="btn btn-danger">Cadastre-se</a>
                            
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
			                		<a href="https://yesnow.ml" class="text-white">Home</a>
			                	<p class="card-text">
			                		<a href="https://yesnow.ml/Vitrine" class="text-white">Produtos</a>
			                		</p>
			                	<p class="card-text">
			                		<a href="https://yesnow.ml/lojas" class="text-white">Lojas</a>
			                	</p>
			                	<p class="card-text">
			                		<a href="https://yesnow.ml/meus-pedidos.php" class="text-white">Pedidos</a>
			                	</p>
			              </div>
			              
			            </div>
			        </div>
					<div class="col-lg-4 col-md-6 mb-4"">
                    <br>
			            <div class="rodape card h-100 ">
			              
			              <div class="card-body">
			                
			                <h4 class="card-title">
			                	<p class="h5">CONTATO:</p>
			                </h4>
			                	<p class="card-text">
			                		<i class="icon-mail" aria-hidden="true">adm@bueno.cf</i>
			                		</p>
			                	<p class="card-text">
			                		<i class="icon-whatsapp text-success" aria-hidden="true"></i>
                                    (19) 9 9457-7247
			                		</p>
			                	<p class="card-text">Cidade: Indaiatuba/SP</p>
			                	<p class="card-text">CNPJ: 27.982.084/0001-62</p>
                                <a class="btn btn-primary text-center" href="https://www.facebook.com"> 
		                        <i class="icon-facebook" aria-hidden="true"></i>
                                <a class="btn btn-danger text-center" href="https://www.instagram.com"> 
		                        <i class="icon-instagram" aria-hidden="true"></i>
		                    </a>
		                    </a>
			              </div>
			              
			            </div>
			        </div>
			        
				</div>
                <div class="col-sm-12 col-md-12">
                    <br><br>
						<p class="m-0 text-center text-white">Copyright &copy; Eliseu S. Bueno - <a href="https://www.yesnow.ml">www.yesnow.ml  </a><?php echo date('Y'); ?></p>
					</div>
			</div>
		</section>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>