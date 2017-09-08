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

			
<?php
if($_SESSION['id']):
$CPFPARAPESQUISA = $_GET['id'];

$usuario = $_SESSION['user'];
$consultacpf = mysql_query("SELECT cpf FROM login WHERE user = '$usuario'") or die(mysql_error());
$querycpf = mysql_fetch_assoc($consultacpf);
$cpfuser = $querycpf["cpf"];
$consulta = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpfuser'") or die(mysql_error());
$dadosuser = mysql_fetch_array($consulta);
$nivel = $dadosuser["classeusuario"];

if (!($nivel == 1 || $nivel == 8))
	{
		echo'<script type="text/javascript">
           window.location = "index.php"
      </script>';
	exit;
	}
$consulta = mysql_query("SELECT * FROM usuarios WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
$dadosusuario = mysql_fetch_array($consulta);
$atendimento = mysql_query("SELECT * FROM atendimentopsicologico WHERE cpfusuario = '$CPFPARAPESQUISA'") or die(mysql_error());
$noatendimentos = mysql_num_rows($atendimento);
$dadosatendimento = mysql_fetch_array($atendimento);

	$paciente = mysql_query("SELECT * FROM usuarios WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
	$nomepaciente = mysql_fetch_assoc($paciente);
	
	if ($nomepaciente["sexo"] == "M")
		$genero = "Masculino";
	else if ($nomepaciente["sexo"] == "F")
		$genero = "Feminino";
	else $genero = "Outro";
	
	if ($nomepaciente["classeusuario"] == "2") {
		$categoriausuario = "Graduação";
		$dadospacientesql = mysql_query("SELECT * FROM graduacao WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
		$dadospaciente = mysql_fetch_assoc($dadospacientesql);
	}
	else if ($nomepaciente["classeusuario"] == "3") {
		$categoriausuario = "Pós-Graduação";
		$dadospacientesql = mysql_query("SELECT * FROM posgraduacao WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
		$dadospaciente = mysql_fetch_assoc($dadospacientesql);
	}
	else if ($nomepaciente["classeusuario"] == "4") {
		$categoriausuario = "Docente";
		$dadospacientesql = mysql_query("SELECT * FROM docente WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
		$dadospaciente = mysql_fetch_assoc($dadospacientesql);
	}
	else if ($nomepaciente["classeusuario"] == "6") {
		$categoriausuario = "Técnico Administrativo";
		$dadospacientesql = mysql_query("SELECT * FROM tecnico WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
		$dadospaciente = mysql_fetch_assoc($dadospacientesql);
	}
	else if ($nomepaciente["classeusuario"] == "7") {
		$categoriausuario = "Funcionário Terceirizado";
		$dadospacientesql = mysql_query("SELECT * FROM funcionario WHERE cpf = '$CPFPARAPESQUISA'") or die(mysql_error());
		$dadospaciente = mysql_fetch_assoc($dadospacientesql);
	}

	$idadepaciente = floor((time() - strtotime($nomepaciente["nascimento"])) / 31556926);
	
	echo '
<center><img src="images/header.png"></center>
<center><tbody>
<table frame="box">
<tr>
<td  >1. Nome: <input size="70" readonly="readonly" name="nome" type="text" class="campo" id="nome" value="'.$nomepaciente["nome"].'" /> 2. Idade: <input size="5" readonly="readonly" type="text" value="'.$idadepaciente.'" /></td>
</tr>


<tr>
<td  >3. Sexo: <input size="10" readonly="readonly" type="text" value="'.$genero.'" /> 4. Cidade de origem: <input size="35" readonly="readonly" type="text" value="'.$nomepaciente["cidade"].'" />
5. UF: <input size="10" readonly="readonly" type="text" value="'.$nomepaciente["estado"].'" /></td>
</tr>

<tr>
<td  >6. Telefones para contato: <input size="20" readonly="readonly" type="text" value="'.$nomepaciente["telefonepref"].'" /> <input size="20" readonly="readonly" type="text" value="'.$nomepaciente["telefonealt"].'" /></td>
</tr>

<tr>
<td  >7. E-mail: <input size="85" readonly="readonly" type="text" value="'.$nomepaciente["email"].'" /></td>
</tr>

<tr>
<td  >8. Categoria: <input size="10" readonly="readonly" type="text" value="'.$categoriausuario.'" />';

if ($categoriausuario == "Graduação" || $categoriausuario == "Pós-Graduação")
{
	echo ' Curso: <input size="10" readonly="readonly" type="text" value="'.$dadospaciente["curso"].'" />
		Período: <input size="3" readonly="readonly" type="text" value="'.$dadospaciente["periodo"].'" />
		Turno: <input size="3" readonly="readonly" type="text" value="'.$dadospaciente["turno"].'" />
		Assistência Estudantil: <input size="3" readonly="readonly" type="text" value="'.$dadospaciente["bolsista"].'" /></td>';
}

else if ($categoriausuario == "Docente")
{
	echo ' Departamento: <input size="10" readonly="readonly" type="text" value="'.$dadospaciente["campus"].'" /></td>';
}

if ($categoriausuario == "Técnico Administrativo" || $categoriausuario == "Funcionário Terceirizado")
{
	echo ' Local de Trabalho: <input size="10" readonly="readonly" type="text" value="'.$dadospaciente["campus"].'" /></td>';
}

else echo '</td>';

echo '
</tr>

<tr>
<td >9. Já foi atendido pelo Serviço de Psicologia da PROACE anteriormente? <input readonly="readonly" name="statusatendimento" type="text" class="campo" id="statusatendimento" value="'.$dadosatendimento["statusatendimento"].'" /></td>
</tr>

<tr>
<td >10. Recebeu encaminhamento de algum profissional? <input size="4" readonly="readonly" name="statusencaminhamento" type="text" class="campo" id="statusencaminhamento" value="'.$dadosatendimento["statusencaminhamento"].'" />
 De quem? <input size="25" readonly="readonly" name="encaminhamento" type="text" class="campo" id="encaminhamento" value="'.$dadosatendimento["encaminhamento"].'" /></td>
</tr>

<tr>
<td >Data do Atendimento: <input size="10" readonly="readonly" name="data" type="text" class="campo" id="data" value="'.$dadosatendimento["data"].'" /> Hora do Atendimento: <input size="10" readonly="readonly" name="hora" type="text" class="campo" id="hora" value="'.$dadosatendimento["hora"].'" />
 Local: <input size="30" readonly="readonly" name="local" type="text" class="campo" id="local" value="'.$dadosatendimento["local"].'" /></td>
</tr>
<tr>
<td>
<br><br>
<center>_____________________________________________________________________<br>
(Assinatura do usuário)</center><br><br>
</td>
</tr>
<tr>
</table>
</tbody></center>
<br><br>';
 ?>
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
</body>
</html>