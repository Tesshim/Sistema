<?php

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';


session_name('tzLogin');
// Inicia a sessão

session_set_cookie_params(2*7*24*60*60);
// Faz o cookie durar por 2 semanas

session_start();

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// Se você está logado mas não tem o tzRemember cookie (reiniciar o navegador)
	// e não marcou o "Lembrar-me":

	$_SESSION = array();
	session_destroy();
	
	// Destroi a sessão
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: index.php");
	exit;
}

if($_POST['submit']=='Entrar')
{
	// Checando se o form de login foi enviado
	
	$err = array();
	// Variável pra armazenar os erros
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'Todos os campos precisam ser preenchidos!';
	
	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		// Fazendo o escape de todos os dados entrados

		$row = mysql_fetch_assoc(mysql_query("SELECT id,user FROM login WHERE user='{$_POST['username']}' AND pass='".md5($_POST['password'])."'"));

		if($row['user'])
		{
			// Se tudo estiver OK com o login
			
			$_SESSION['user']=$row['user'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			
			// Guarda os dados na sessão
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='Senha e/ou nome de usuário inválidos!';
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Salva as mensagens de erro na seção

	header("Location: index.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// O script abaixo aparece no painel durante o carregamento da página
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
}
include "sql.php";


   	if(isset($_POST['cadastrar'])){
		$nome = $_POST['nome'];
		$cpf = $_POST['cpf'];
		$data = $_POST['data'];
		$sexo = $_POST['sexo'];
		$estado = $_POST['estado'];
		$cidade = $_POST['cidade'];
		$telefone = $_POST['telefone'];
		$telefonealt = $_POST['telefonealt'];
		$email = $_POST['email'];
		$email1 = $_POST['email1'];
		$perfil = $_POST['dropdown'];
		
		//Graduação
		$matriculagrad = $_POST['matriculagrad'];
		$cursograd = $_POST['cursograd'];
		$campusgrad = $_POST['campusgrad'];
		$periodograd = $_POST['periodograd'];
		$turnograd = $_POST['turnograd'];
		$bolsistagrad = $_POST['bolsistagrad'];
		
		//Pos-Graduação
		$matriculapos = $_POST['matriculapos'];
		$cursopos = $_POST['cursopos'];
		$campuspos = $_POST['campuspos'];
		
		//EAD
		$matriculaead = $_POST['matriculaead'];
		$cursoead = $_POST['cursoead'];
		$poloead = $_POST['poloead'];
		$periodoead = $_POST['periodoead'];
		
		//Docente
		$siapedocente = $_POST['siapedocente'];
		$campusdocente = $_POST['campusdocente'];
		
		//Técnico
		$siapeta = $_POST['siapeta'];
		$setorta = $_POST['setorta'];
		$campusta = $_POST['campusta'];
		$departamento = $_POST['departamento'];
		
		//Funcionario
		$empresa = $_POST['empresa'];
		$funcao = $_POST['funcao'];
		$campusterceirizado = $_POST['campusterceirizado'];
		
		
		$consultacpf = mysql_query("SELECT cpf FROM usuarios WHERE cpf = '$cpf'") or die(mysql_error());
		$querycpf = mysql_num_rows($consultacpf);
		
		$consultaemail = mysql_query("SELECT email FROM usuarios WHERE email = '$email'") or die(mysql_error());
		$queryemail = mysql_num_rows($consultaemail);
		
		if ($querycpf >= 1) //verifica se o CPF ja esta cadastrado no BD
		{
			$erro = "CPF já está cadastrado.";
		}
		
		else if ($queryemail >= 1) //verifica se o email ja esta cadastrado no BD
		{
			$erro = "E-mail já está cadastrado.";
		}
		
		else if (!checkEmail($email)) //verifica se o email eh valido
		{
			$erro = "E-mail inválido!";
		}
		else if (!checkEmail($email1)) //verifica se o email eh valido
		{
			$erro = "E-mail inválido!";
		}
		else if ($email != $email1){
			$erro = "Confira se os endereços de email digitados são iguais!";
		}
		
		/*else if (!validarCPF($cpf)) //verifica se o cpf é valido
		{
			$erro = "CPF inválido!";
		}*/
	   
		else if($perfil == 2){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($matriculagrad) || empty ($cursograd) || empty ($campusgrad) || empty ($periodograd) || empty ($turnograd) || empty ($bolsistagrad))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
					VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   if($bolsistagrad == 11) $bolsistagrad = 0;
				   $sql1 = mysql_query("INSERT INTO `graduacao`(`matricula`, `cpf`, `curso`, `campus`, `periodo`, `turno`, `bolsista`) 
					VALUES ('$matriculagrad', '$cpf', '$cursograd', '$campusgrad', '$periodograd', '$turnograd', '$bolsistagrad')") or die(mysql_error());
				   
				   if($sql && $sql1)
					{
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";
		
					}
					else
					{
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}
		}
		elseif($perfil == 3){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($matriculapos) || empty ($cursopos) || empty ($campuspos))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
				   VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   $sql1 = mysql_query("INSERT INTO `posgraduacao`(`matricula`, `cpf`, `curso`, `campus`) 
					VALUES ('$matriculapos', '$cpf', '$cursopos', '$campuspos')") or die(mysql_error());
				   
				  	if($sql && $sql1)
					{			   
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";
					}
					else
					{
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}

		}
		elseif($perfil == 5){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($matriculaead) || empty ($cursoead) || empty ($poloead) || empty ($periodoead))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
				   VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   $sql1 = mysql_query("INSERT INTO `ead`(`matricula`, `cpf`, `curso`, `polo`, `periodo`) 
					VALUES ('$matriculaead', '$cpf', '$cursoead', '$poloead', '$periodoead')") or die(mysql_error());
				   
				   if($sql && $sql1)
				   {
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";   
				   }
				   else
				   {
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}
		}
		elseif($perfil == 4){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($siapedocente) || empty ($campusdocente))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
				   VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   $sql1 = mysql_query("INSERT INTO `docente`(`cpf`, `siape`, `campus`) 
					VALUES ('$cpf', '$siapedocente', '$campusdocente')") or die(mysql_error());
				   
				   if($sql && $sql1)
				   {
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";   
				   }
				   else
				   {
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}
		}
		elseif($perfil == 6){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($siapeta) || empty ($campusta) || empty ($setorta) || empty ($departamento))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
				   VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   $sql1 = mysql_query("INSERT INTO `tecnico`(`cpf`, `siape`,`setor`, `campus`, `departamento`) 
					VALUES ('$cpf', '$siapeta', '$setorta', '$campusta', '$departamento')") or die(mysql_error());
				   
				   if($sql && $sql1)
				   {
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";   
				   }
				   else
				   {
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}
		}
		elseif($perfil == 7){
			if(empty($nome) || empty($cpf) || empty($data) || empty($sexo)|| empty($estado) || empty ($cidade) || empty ($telefone) || empty ($telefonealt) || empty ($email) || empty ($email1)|| empty ($perfil)|| empty ($empresa) || empty ($funcao) || empty ($campusterceirizado))
			{
				$erro = "Você deve preencher todos os campos!";
			}
			else
			{
				   $sql = mysql_query("INSERT INTO `usuarios`(`campus`, `cidade`, `classeusuario`, `cpf`, `email`, `estado`, `nascimento`, `nome`, `sexo`, `telefonepref`, `telefonealt`) 
				   VALUES ('$campusgrad', '$cidade', '$perfil', '$cpf', '$email', '$estado', '$data', '$nome', '$sexo', '$telefone', '$telefonealt')") or die(mysql_error());
				   
				   $sql1 = mysql_query("INSERT INTO `funcionario`(`cpf`, `empresa`,`funcao`, `campus`) 
					VALUES ('$cpf', '$empresa', '$funcao', '$campusterceirizado')") or die(mysql_error());
				   
				   if($sql && $sql1)
				   {
						$pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6); //Cria um password aleatorio
						$sql2 = mysql_query("INSERT INTO `login`(`user`, `pass`, `cpf`, `regIP`, `dt`)
						VALUES ('$email', '".md5($cpf)."', '$cpf', '".$_SERVER['REMOTE_ADDR']."', NOW())") or die(mysql_error());
						
						if($sql2)
						{
							//send_mail(	'demo-test@tutorialzine.com',
							//$_POST['email'],
							//'Sistema DASA/PROACE - Seus dados cadastrais',
							//'Seu login no sistema é o seu endereço de email. Sua senha é: '.$pass);

							$erro = "Cadastro realizado com sucesso. Utilize seu e-mail para conectar-se ao sistema, com seu CPF (apenas números) como senha. Sugerimos que você altere a sua senha imediatamente ao se conectar ao sistema.";
						}
						else $erro = "Erro ao efetuar cadastro.";   
				   }
				   else
				   {
						$erro = "Cadastro não realizado. Tente novamente.";
					}
			}

		} else{
		$erro =  "Selecione um perfil";
		
		}
	
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DASA/PROACE - Diretoria de Atenção à Saúde e Acessibilidade</title>
    
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />
    
    <script src="https://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>
	 <script type="text/javascript" src="mascara.js"></script>
    
    <!-- PNG FIX for IE6 -->
    <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
    <!--[if lte IE 6]>
        <script type="text/javascript" src="login_panel/js/pngfix/supersleight-min.js"></script>
    <![endif]-->
    
    <script src="login_panel/js/slide.js" type="text/javascript"></script>
    
    <?php echo $script; ?>
</head>

<body>

<style type="text/css">

.tabela{

background:#fff;

width:200px;

padding:0px;

border:1px solid #f0f0f0;

float:left;

margin-right:20px;

}

.td{

background:#f8f8f8;

width:20px;

height:20px;

text-align:center;



}

.hj{

background: #FFFFCC;

width:20px;

height:20px;

text-align:center;

}

.dom{

background: #FFCC99;

width:20px;

height:20px;

text-align:center;

}

.evt{

background: #CCFF99;

width:20px;

height:20px;

text-align:center;

}

.mes{

background:#fff;

width:auto;

height:20px;

text-align:center;

}

.show{

background:#202020;

width:300px;

height:30px;

text-align:left;

font-size:12px;

font-weight:bold;

color:#CCFF00;

padding-left:5px;

}

.linha{

background:#404040;

width:300px;

height:20px;

text-align:left;

font-size:11px;

color:#f0f0f0;

padding:1px 1px 1px 10px;

}

.sem{

background: #ECE6D9;

width:auto;

height:20px;

text-align:center;

font-size:12px;

font-weight:bold;

font-family:Verdana;

}

#mostrames{

width:300px;

padding:5px;

}



a:link {

    color: #000000;

    text-decoration: none;

}

a:visited {

    text-decoration: none;

    color: #000000;

}

a:hover {

    text-decoration: underline;

    color: #FF9900;

}

a:active {

    text-decoration: none;

}

</style>

<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>DASA/PROACE</h1>
				<h2>Diretoria de Atenção à<br>Saúde e Acessibilidade</h2>		
				<p class="grey" style="color: #B7DD76" >Campus JK – Diamantina/MG.<br>  
				PABX: (38) 3532-1200 Ramal 8126<br>
				E-mail: dasa.proace@ufvjm.edu.br<br></p>
			</div>
            
            
            <?php
			
			if(!$_SESSION['id']):
			
			?>
            
			<div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="" method="post">
					<h1>Login de Usuário</h1>
                    
                    <?php
						
						if($_SESSION['msg']['login-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>
					
					<label class="grey" for="username">Usuário:</label>
					<input class="field" type="text" name="username" id="username" value="" size="23" />
					<label class="grey" for="password">Senha:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Lembrar-me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Entrar" class="bt_login" />
				</form>
			</div>
			<div class="left right">			
				<!-- Register Form -->
				<form action="registrar.php" method="post">
					<h1>Não possui cadastro?<br>Registre-se!</h1>		
                    
                    <?php
						
						if($_SESSION['msg']['reg-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
							unset($_SESSION['msg']['reg-err']);
						}
						
						if($_SESSION['msg']['reg-success'])
						{
							echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
							unset($_SESSION['msg']['reg-success']);
						}
					?>
                    		

					<input type="submit" name="submit" value="Registrar" class="bt_register" />
				</form>
			</div>
            
            <?php
			
			else:
			
			?>
            
            <div class="left">
            
            <h1>Painel do Usuário</h1>
            
			<h3><a href="alterardados.php" style="color: #B7DD76">Alterar Dados</a><br></h3>
			<h3><a href="alterarsenha.php" style="color: #B7DD76">Alterar Senha</a><br></h3>
            <h3><a href="?logoff" style="color: #B7DD76">Sair</a></h3>
            
            </div>
            
            <div class="left right">
			<center><img width="230" height="173" src="images/ufvjm.png"></center>
            </div>
            
            <?php
			endif;
			?>
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li><?php echo $_SESSION['user'] ? $_SESSION['user'] : 'Convidado';?></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#" style="color: #B7DD76"><?php echo $_SESSION['id']?'Abrir Painel':'Entrar | Registrar';?></a>
				<a id="close" style="display: none;" class="close" href="#" style="color: #B7DD76"><font color="#B7DD76">Fechar Painel</font></a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->

<div class="pageContent">
    <div id="main">
      <div class="container">
	  <center>
        <a href="index.php"><img src="images/proace.jpg"></a>
		<h2>Pró-Reitoria de Assuntos Comunitários e Estudantis</h2>
		</center>
        </div>
        
        <div class="container">
			
			<?php
	if($_SESSION['id']):
	//echo 'Usuario logado nao se cadastra nao, vaza daqui';
	echo
	'<script language="JavaScript"> 
	window.location="index.php"; 
	</script>'; 
	
	else:
    //AQUI O USUARIO TA DESLOGADO
    //MUDA AQUI O NOME DA PAGINA PRA ONDE VAI MANDAR O POST (ELA MESMA)
	echo '<form name="form1" action="registrar.php" method="POST" style="padding-top:10px;">';
	//MSG DE ERRO E DE CONFIRMACAO, NAO PRECISA MEXER
	if(isset($erro)){
		print '<div style="width:100%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center; margin: 0 auto;">'.$erro.'</div>';
	}

			?>
			<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:relative;">

				<thead>

				<tr>

				<th colspan="2">Cadastro</th>

				</tr>

				</thead>
				<tbody>

					<tr>

					<td width="30%">Nome:</td>

					<td width="auto"><input type="text" name="nome" class="campo" id="nome" /></td>

					</tr>
					<tr>

					<td width="30%">CPF (Apenas números):</td>

					<td width="auto"><input type="text" name="cpf" class="campo" id="cpf" /></td>

					</tr>
					<tr>

					<td width="30%">Data de Nascimento:</td>

					<td width="auto"><input type="date" name="data" class="campo" id="data" /></td>

					</tr>
					<tr>

					<td width="30%">Gênero:</td>

					<td width="auto">
					<input type="radio" name="sexo" value="M" class="campo" id="sexo"> Masculino<br>
					<input type="radio" name="sexo" value ="F" class="campo" id="sexo" > Feminino<br> 
					<input type="radio" name="sexo" value ="O" class="campo" id="sexo" > Outro<br> </td>

					</tr>
					<tr>

					<td width="30%">Estado:</td>

					<td width="auto"><select name="estado"> 
						<option value="">Selecione o Estado</option> 
						<option value="AC">Acre</option> 
						<option value="AL">Alagoas</option> 
						<option value="AM">Amazonas</option> 
						<option value="AP">Amapá</option> 
						<option value="BA">Bahia</option> 
						<option value="CE">Ceará</option> 
						<option value="DF">Distrito Federal</option> 
						<option value="ES">Espírito Santo</option> 
						<option value="GO">Goiás</option> 
						<option value="MA">Maranhão</option> 
						<option value="MT">Mato Grosso</option> 
						<option value="MS">Mato Grosso do Sul</option> 
						<option value="MG">Minas Gerais</option> 
						<option value="PA">Pará</option> 
						<option value="PB">Paraíba</option> 
						<option value="PR">Paraná</option> 
						<option value="PE">Pernambuco</option> 
						<option value="PI">Piauí</option> 
						<option value="RJ">Rio de Janeiro</option> 
						<option value="RN">Rio Grande do Norte</option> 
						<option value="RO">Rondônia</option> 
						<option value="RS">Rio Grande do Sul</option> 
						<option value="RR">Roraima</option> 
						<option value="SC">Santa Catarina</option> 
						<option value="SE">Sergipe</option> 
						<option value="SP">São Paulo</option> 
						<option value="TO">Tocantins</option> 
				</select> </td>
				</tr>
				
					<tr>

					<td width="30%">Cidade:</td>

					<td width="auto"><input type="text" name="cidade" class="campo" id="cidade" /></td>

					</tr>	
					<tr>

					<td width="30%">Telefone:</td>

					<td width="auto"><input type="text" name="telefone"class="campo" id="telefone" /></td>

					</tr>	
					<tr>

					<td width="30%">Telefone Alternativo:</td>

					<td width="auto"><input type="text" name="telefonealt"  class="campo" id="telefonealt" /></td>

					</tr>
					
					<tr>

					<td width="30%">Email:</td>

					<td width="auto"><input type="email" name="email"  class="campo" id="email" /></td>

					</tr>
					<tr>

					<td width="30%">Confirmar Email:</td>

					<td width="auto"><input type="email" name="email1"  class="campo" id="email1" /></td>

					</tr>
					
					

					<td width="30%">Perfil:</td>

					<script type="text/javascript">
				 function mostrarOpcao1() {
				   var div = document.getElementById("graduacao"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divF = document.getElementById("pos");
				   var divD = document.getElementById("docente");
				   var divTA = document.getElementById("ta");
				   var divE = document.getElementById("ead");
				   var divT = document.getElementById("terceirizado");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divF.style.display = 'none';
					 divD.style.display = 'none';
					 divE.style.display = 'none';
					 divTA.style.display = 'none';
					 divT.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
				   }
				 }
				</script>

				<script type="text/javascript">
				 function mostrarOpcao2() {
				   var div = document.getElementById("pos"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divM = document.getElementById("graduacao");
				   var divD = document.getElementById("docente");
				   var divTA = document.getElementById("ta");
				   var divE = document.getElementById("ead");
				   var divT = document.getElementById("terceirizado");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divM.style.display = 'none';
					 divD.style.display = 'none';
					 divE.style.display = 'none';
					 divTA.style.display = 'none';
					 divT.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
					 
				   }
				 }
				</script>
				
				<script type="text/javascript">
				 function mostrarOpcao3() {
				   var div = document.getElementById("ead"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divM = document.getElementById("graduacao");
				   var divF = document.getElementById("pos");
				   var divD = document.getElementById("docente");
				   var divTA = document.getElementById("ta");
				   var divT = document.getElementById("terceirizado");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divM.style.display = 'none';
					 divF.style.display = 'none';
					 divD.style.display = 'none';
					 divTA.style.display = 'none';
					 divT.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
					 
				   }
				 }
				</script>
				
				<script type="text/javascript">
				 function mostrarOpcao4() {
				   var div = document.getElementById("docente"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divM = document.getElementById("graduacao");
				   var divF = document.getElementById("pos");
				   var divE = document.getElementById("ead");
				   var divTA = document.getElementById("ta");
				   var divT = document.getElementById("terceirizado");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divM.style.display = 'none';
					 divF.style.display = 'none';
					 divE.style.display = 'none';
					 divTA.style.display = 'none';
					 divT.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
					 
				   }
				 }
				</script>
				
				<script type="text/javascript">
				 function mostrarOpcao5() {
				   var div = document.getElementById("ta"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divM = document.getElementById("graduacao");
				   var divF = document.getElementById("pos");
				   var divE = document.getElementById("ead");
				   var divD = document.getElementById("docente");
				   var divT = document.getElementById("terceirizado");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divM.style.display = 'none';
					 divF.style.display = 'none';
					 divE.style.display = 'none';
					 divD.style.display = 'none';
					 divT.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
					 
				   }
				 }
				</script>
				<script type="text/javascript">
				 function mostrarOpcao6() {
				   var div = document.getElementById("terceirizado"); //Se liga aqui que quando um for selecionado temos que fazer os outros sumirem da tela
				   var divM = document.getElementById("graduacao");
				   var divF = document.getElementById("pos");
				   var divE = document.getElementById("ead");
				   var divD = document.getElementById("docente");
				   var divTA = document.getElementById("ta");
				   if (div.style.display == 'none') { //"none" deixa o div invisivel, vazio deixa o div visivel
					 div.style.display = '';
					 divM.style.display = 'none';
					 divF.style.display = 'none';
					 divE.style.display = 'none';
					 divD.style.display = 'none';
					 divTA.style.display = 'none';
				   }
				   else {
					 div.style.display = 'none';
					 
				   }
				 }
				</script>

				<script type="text/javascript">
				$(function(){ 
					$('#dropdown').change(function(){ //dropdown é o id do dropdown
						var opcao =$("#dropdown option:selected").val(); //Aqui ele pega o valor que ta selecionado no momento
						if (opcao == 2)
							mostrarOpcao1();
						if (opcao == 3)
							mostrarOpcao2();
						if (opcao == 5)
							mostrarOpcao3();
						if (opcao == 4)
							mostrarOpcao4();
						if (opcao == 6)
							mostrarOpcao5();
						if (opcao == 7)
							mostrarOpcao6();
					});
				});
				</script>
				<td width="auto">
				<select name="dropdown" id="dropdown" size=1>
					<option value="<?php echo "0"; ?>" selected="selected" >Escolha...</option>
					<option value="<?php echo "2"; ?>">Estudante de Graduação</option>
					<option value="<?php echo "3"; ?>">Estudante de Pós Graduação</option>
					<option value="<?php echo "5"; ?>">Estudante de EAD</option>
					<option value="<?php echo "4"; ?>">Docente</option>
					<option value="<?php echo "6"; ?>">Técnico Administrativo</option>
					<option value="<?php echo "7"; ?>">Funcionário Terceirizado</option>

				</select>
				</td>
			</tbody>
			</table>

				 <div id="graduacao" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
				<td width="30%">Matrícula:</td>
				<td width="auto"> <input type="text" name="matriculagrad"  class="campo" id="matriculagrad" /></td>
				</tr>
				<tr>
				<td width="30%">Curso:</td>
				<td width="auto"> <select name="cursograd"> 
						<option value="">Selecione o Curso</option> 
						<option value="Agronomia">Agronomia</option> 
						<option value="Engenharia Florestal">Engenharia Florestal</option> 
						<option value="Zootecnia">Zootecnia</option> 
						<option value="Enfermagem">Enfermagem</option> 
						<option value="Farmácia">Farmácia</option> 
						<option value="Fisioterapia">Fisioterapia</option> 
						<option value="Ciências Biológicas">Ciências Biológicas</option> 
						<option value="Educação Física">Educação Física</option> 
						<option value="Nutrição">Nutrição</option> 
						<option value="Odontologia">Odontologia</option> 
						<option value="Química">Química</option> 
						<option value="Sistemas de Informação">Sistemas de Informação</option> 
						<option value="Humanidades">Humanidades</option> 
						<option value="Geografia">Geografia</option> 
						<option value="História">História</option> 
						<option value="Letras Português/Inglês">Letras Português/Inglês</option> 
						<option value="Letras Português/Espanhol">Letras Português/Espanhol</option> 
						<option value="Pedagogia">Pedagogia</option> 
						<option value="Turismo">Turismo</option> 
						<option value="Licenciatura em Educação do Campo">Licenciatura em Educação do Campo</option> 
						<option value="Medicina">Medicina</option> 
						<option value="Ciência e Tecnologia">Ciência e Tecnologia</option> 
						<option value="Engenharia de Alimentos">Engenharia de Alimentos</option> 
						<option value="Engenharia Mecânica">Engenharia Mecânica</option> 
						<option value="Engenharia Química">Engenharia Química</option> 
						<option value="Engenharia Geológica">Engenharia Geológica</option> 
				</select></td>
				</tr>
				<tr>
				<td width="30%">Campus:</td>
				<td width="auto"> <select name="campusgrad"> 
						<option value="">Selecione o Campus</option> 
						<option value="Campus JK / Diamantina">Campus JK / Diamantina</option> 
						<option value="Campus Unaí">Campus Unaí</option> 
						<option value="Campus Mucuri / Teófilo Otoni">Campus Mucuri / Teófilo Otoni</option>
						<option value="Campus Janaúba">Campus Janaúba</option>
						</select></td>
				</tr>
				<tr>
				<td width="30%">Período:</td>
				<td width="auto"> <input type="text" name="periodograd"  class="campo" id="periodograd" /></td>
				</tr>
				<tr>
				<td width="30%">Turno:</td>
				<td width="auto"> <input type="text" name="turnograd"  class="campo" id="turnograd" /></td>
				</tr>
				<tr>
				<td width="30%">Bolsista:</td>
				<td width="auto"> 
					<input type="radio" name="bolsistagrad" value="1" class="campo" id="bolsistagrad"> Sim<br>
					<input type="radio" name="bolsistagrad" value="11" class="campo" id="bolsistagrad" > Não<br></td>
				</tr>
				
				</table>
				 </div>

				 <div id="pos" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					<td width="30%">Matrícula:</td>
					<td width="auto"> <input type="text" name="matriculapos"  class="campo" id="matriculapos" /></td>
					</tr>
					<tr>
					<td width="30%">Curso:</td>
					<td width="auto"> <select name="cursopos"> 
						<option value="">Selecione o Curso</option> 
						<option value="Agronomia">Agronomia</option> 
						<option value="Engenharia Florestal">Engenharia Florestal</option> 
						<option value="Zootecnia">Zootecnia</option> 
						<option value="Enfermagem">Enfermagem</option> 
						<option value="Farmácia">Farmácia</option> 
						<option value="Fisioterapia">Fisioterapia</option> 
						<option value="Ciências Biológicas">Ciências Biológicas</option> 
						<option value="Educação Física">Educação Física</option> 
						<option value="Nutrição">Nutrição</option> 
						<option value="Odontologia">Odontologia</option> 
						<option value="Química">Química</option> 
						<option value="Sistemas de Informação">Sistemas de Informação</option> 
						<option value="Humanidades">Humanidades</option> 
						<option value="Geografia">Geografia</option> 
						<option value="História">História</option> 
						<option value="Letras Português/Inglês">Letras Português/Inglês</option> 
						<option value="Letras Português/Espanhol">Letras Português/Espanhol</option> 
						<option value="Pedagogia">Pedagogia</option> 
						<option value="Turismo">Turismo</option> 
						<option value="Licenciatura em Educação do Campo">Licenciatura em Educação do Campo</option> 
						<option value="Medicina">Medicina</option> 
						<option value="Ciência e Tecnologia">Ciência e Tecnologia</option> 
						<option value="Engenharia de Alimentos">Engenharia de Alimentos</option> 
						<option value="Engenharia Mecânica">Engenharia Mecânica</option> 
						<option value="Engenharia Química">Engenharia Química</option> 
						<option value="Engenharia Geológica">Engenharia Geológica</option> 
				</select></td>
					</tr>
					<tr>
					<td width="30%">Campus:</td>
					<td width="auto"> <select name="campuspos"> 
						<option value="">Selecione o Campus</option> 
						<option value="Campus JK / Diamantina">Campus JK / Diamantina</option> 
						<option value="Campus Unaí">Campus Unaí</option> 
						<option value="Campus Mucuri / Teófilo Otoni">Campus Mucuri / Teófilo Otoni</option>
						<option value="Campus Janaúba">Campus Janaúba</option>
						</select></td>
				</tr>
				</table>
				 </div>
				 
				<div id="ead" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					<td width="30%">Matrícula:</td>
					<td width="auto"> <input type="text" name="matriculaead"  class="campo" id="matriculaead" /></td>
					</tr>
					<tr>
					<td width="30%">Curso:</td>
					<td width="auto"> <select name="cursoead"> 
						<option value="">Selecione o Curso</option> 
						<option value="Agronomia">Agronomia</option> 
						<option value="Engenharia Florestal">Engenharia Florestal</option> 
						<option value="Zootecnia">Zootecnia</option> 
						<option value="Enfermagem">Enfermagem</option> 
						<option value="Farmácia">Farmácia</option> 
						<option value="Fisioterapia">Fisioterapia</option> 
						<option value="Ciências Biológicas">Ciências Biológicas</option> 
						<option value="Educação Física">Educação Física</option> 
						<option value="Nutrição">Nutrição</option> 
						<option value="Odontologia">Odontologia</option> 
						<option value="Química">Química</option> 
						<option value="Sistemas de Informação">Sistemas de Informação</option> 
						<option value="Humanidades">Humanidades</option> 
						<option value="Geografia">Geografia</option> 
						<option value="História">História</option> 
						<option value="Letras Português/Inglês">Letras Português/Inglês</option> 
						<option value="Letras Português/Espanhol">Letras Português/Espanhol</option> 
						<option value="Pedagogia">Pedagogia</option> 
						<option value="Turismo">Turismo</option> 
						<option value="Licenciatura em Educação do Campo">Licenciatura em Educação do Campo</option> 
						<option value="Medicina">Medicina</option> 
						<option value="Ciência e Tecnologia">Ciência e Tecnologia</option> 
						<option value="Engenharia de Alimentos">Engenharia de Alimentos</option> 
						<option value="Engenharia Mecânica">Engenharia Mecânica</option> 
						<option value="Engenharia Química">Engenharia Química</option> 
						<option value="Engenharia Geológica">Engenharia Geológica</option> 
				</select></td>
					</tr>
					<tr>
					<td width="30%">Polo:</td>
					<td width="auto"> <input type="text" name="poloead"  class="campo" id="poloead" /></td>
				</tr>
				<tr>
					<td width="30%">Período:</td>
					<td width="auto"> <input type="text" name="periodoead"   class="campo" id="periodoead" /></td>
				</tr>
				</table>
				 </div>
				 
				 <div id="ta" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					<td width="30%">SIAPE:</td>
					<td width="auto"> <input type="text" name="siapeta"  class="campo" id="siapeta" /></td>
					</tr>
					<tr>
					<td width="30%">Setor:</td>
					<td width="auto"> <input type="text" name="setorta"  class="campo" id="setorta" /></td>
				</tr>
					<tr>
					<td width="30%">Campus:</td>
					<td width="auto"> <select name="campusta"> 
						<option value="">Selecione o Campus</option> 
						<option value="Campus JK / Diamantina">Campus JK / Diamantina</option> 
						<option value="Campus Unaí">Campus Unaí</option> 
						<option value="Campus Mucuri / Teófilo Otoni">Campus Mucuri / Teófilo Otoni</option>
						<option value="Campus Janaúba">Campus Janaúba</option>
						</select></td>
				</tr>
				<tr>
					<td width="30%">Departamento:</td>
					<td width="auto"> <input type="text" name="departamento"   class="campo" id="departamento" /></td>
				</tr>
				</table>
				 </div>
				 
				 <div id="docente" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					<td width="30%">SIAPE:</td>
					<td width="auto"> <input type="text" name="siapedocente"   class="campo" id="siapedocente" /></td>
					</tr>
					<tr>
					<td width="30%">Campus:</td>
					<td width="auto"> <select name="campusdocente"> 
						<option value="">Selecione o Campus</option> 
						<option value="Campus JK / Diamantina">Campus JK / Diamantina</option> 
						<option value="Campus Unaí">Campus Unaí</option> 
						<option value="Campus Mucuri / Teófilo Otoni">Campus Mucuri / Teófilo Otoni</option>
						<option value="Campus Janaúba">Campus Janaúba</option>
						</select></td>
				</tr>
				</table>
				 </div>
				 <div id="terceirizado" style="display: none">
				<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					<td width="30%">Empresa:</td>
					<td width="auto"> <input type="text" name="empresa"  class="campo" id="empresa" /></td>
					</tr>
					<tr>
					<td width="30%">Função:</td>
					<td width="auto"> <input type="text" name="funcao"  class="campo" id="funcao" /></td>
					</tr>
					<tr>
					<td width="30%">Campus:</td>
					<td width="auto"> <select name="campusterceirizado"> 
						<option value="">Selecione o Campus</option> 
						<option value="Campus JK / Diamantina">Campus JK / Diamantina</option> 
						<option value="Campus Unaí">Campus Unaí</option> 
						<option value="Campus Mucuri / Teófilo Otoni">Campus Mucuri / Teófilo Otoni</option>
						<option value="Campus Janaúba">Campus Janaúba</option>
						</select></td>
				</tr>
				
				</table>
				 </div>
				 <div>
				 <table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:;">
				<tr>
					
					<td width="auto"> <center><input type="submit" value="Cadastrar" /><input type="hidden" name="cadastrar" value="" /></center></td>
					</tr>
								
				</table>
				
				 </div>
			
        </div>
		
	</form>
<?php endif; ?>	
      <div class="container tutorial-info">
      Campus JK. Rodovia MGT 367 - km 583, nº 5000 – Alto da Jacuba. Diamantina-MG. CEP: 39100-000.  
<br>PABX: (38) 3532-1200. Ramal 8126. </div>
    </div>
</div>

</body>
</html>
