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

if(isset($_POST['done'])){

    

    $_POST['nova1'] = mysql_real_escape_string($_POST['nova1']);

    $_POST['nova2'] = mysql_real_escape_string($_POST['nova2']);
	
	$_POST['atual'] = mysql_real_escape_string($_POST['atual']);

    $cpf = $_POST['cpf'];
	
	$consulta = mysql_query("SELECT * FROM login WHERE pass = '".md5($_POST['atual'])."' AND cpf = '$cpf'") or die(mysql_error());
	
	if ($_POST['nova2'] != $_POST['nova1'])
	{
		$erro = "Senhas não conferem!";		
	}
	else if (!($resultado = mysql_num_rows($consulta)))
	{
		$erro = "Senha incorreta!";		
	}
	else
	{
    $sql = mysql_query("UPDATE login SET pass = '".md5($_POST['nova1'])."' WHERE cpf = '$cpf'") or die(mysql_error());
	
            if($sql){

                $erro = "Senha alterada com sucesso!";

              } else{

                  $erro = "Não foi possivel alterar a senha.";

              }
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
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    
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
					<label><a href="validardados.php">Esqueceu a senha?</a></label>
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
	
echo '<form name="form1" action="alterarsenha.php" method="POST" style="padding-top:10px;">';

if(isset($erro)){

    print '<div style="width:100%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center; margin: 0 auto;">'.$erro.'</div>';

}

$usuario = $_SESSION['user'];
$consultacpf = mysql_query("SELECT cpf FROM login WHERE user = '$usuario'") or die(mysql_error());
$querycpf = mysql_fetch_assoc($consultacpf);
$cpfusuario = $querycpf["cpf"];
$consulta = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpfusuario'") or die(mysql_error());
$dadosusuario = mysql_fetch_array($consulta);
?>
<center><h1>Alterar Senha</h1><br></center>
<tbody>
<table>
<tr>
<td>Digite sua senha atual:</td>
<td><input type="password" name="atual" type="text" class="campo" id="atual" /></td>
</tr>
<tr>
<td>Digite sua nova senha:</td>
<td><input type="password" name="nova1" type="text" class="campo" id="nova1" /></td>
</tr>
<tr>
<td>Digite a nova senha novamente:</td>
<td><input type="password" name="nova2" type="text" class="campo" id="nova2"/></td>
</tr>
</table>
</tbody>
<br>
<input name="cpf" type="hidden" class="campo" id="cpf" value="<?php echo $querycpf["cpf"]; ?>" />
<center><input type="submit" value="Alterar Senha" /><input type="hidden" name="done" value="" /></center>
</form>
<?php
	
	else:
    ?>

          <p><center><h1>Bem-Vindo!</h1><br><br>
<font size=4>Sistema de Serviços Online da Diretoria de Atenção à Saúde e Acessibilidade</font>
<br><br>
Para acessar os serviços disponíveis, entre com seus dados ou faça seu registro.
</center></p>
          <div class="clear"></div>
		    <?php
			endif;
			?>

        </div>
        
      <div class="container tutorial-info">
      Campus JK. Rodovia MGT 367 - km 583, nº 5000 – Alto da Jacuba. Diamantina-MG. CEP: 39100-000.  
<br>PABX: (38) 3532-1200. Ramal 8126. </div>
    </div>
</div>

</body>
</html>
