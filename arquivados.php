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

    

    $cpfusuario = $_POST['cpfpaciente'];
    $cpfpsicologo = $_POST['cpf'];
	$hora = $_POST['hora'];
    $data = $_POST['data'];
	$encaminhamento = $_POST['encaminhamento'];
	$motivo = $_POST['motivo'];
	$statusatendimento = $_POST['statusatendimento'];
	$statusencaminhamento = $_POST['statusencaminhamento'];
	$local = $_POST['local'];

    $sql = mysql_query("INSERT INTO arquivoatendimentopsicologico (cpfusuario, statusatendimento, statusencaminhamento, encaminhamento, motivo, data, hora, local, arquivadopor) 
	VALUES ('$cpfusuario', '$statusatendimento', '$statusencaminhamento', '$encaminhamento', '$motivo', '$data', '$hora', '$local', '$cpfpsicologo')") or die(mysql_error());
	
            if($sql){
				if(mysql_query("DELETE FROM atendimentopsicologico WHERE cpfusuario = '$cpfusuario'")) {
					if(mysql_affected_rows() == 1){
						$erro = "Atendimento marcado como realizado! Dados foram arquivados.";
					}	
				}
                
              } else{

                  $erro = "Não foi possivel realizar a operação.";

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

<style>
td,th {width:auto}
</style>
			
			<?php
	if($_SESSION['id']):
	
echo '<form name="form1" action="visualizaratendimentos.php" method="POST" style="padding-top:10px;">';

if(isset($erro)){

    print '<div style="width:100%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center; margin: 0 auto;">'.$erro.'</div>';

}

$usuario = $_SESSION['user'];
$consultacpf = mysql_query("SELECT cpf FROM login WHERE user = '$usuario'") or die(mysql_error());
$querycpf = mysql_fetch_assoc($consultacpf);
$cpfusuario = $querycpf["cpf"];
$consulta = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpfusuario'") or die(mysql_error());
$dadosusuario = mysql_fetch_array($consulta);
$nivel = $dadosusuario["classeusuario"];

if ($_GET['ordenar'] == "Data")
{
	$atendimento = mysql_query("SELECT * FROM arquivoatendimentopsicologico ORDER BY data ASC") or die(mysql_error());
	$noatendimentos = mysql_num_rows($atendimento);
}
else if ($_GET['ordenar'] == "Campus")
{
	$atendimento = mysql_query("SELECT * FROM arquivoatendimentopsicologico ORDER BY local ASC") or die(mysql_error());
	$noatendimentos = mysql_num_rows($atendimento);
}
else
{
	$atendimento = mysql_query("SELECT * FROM arquivoatendimentopsicologico") or die(mysql_error());
	$noatendimentos = mysql_num_rows($atendimento);
}
	
if (!($nivel == 1 || $nivel == 8))
	{
		echo'<script type="text/javascript">
           window.location = "index.php"
      </script>';
	exit;
	}

?>


<center>
<table>
<tr>
<td><a href="index.php"><img src="images/back.png"></a></td>
<center><td align="center"><h1>Atendimentos Arquivados</h1><br>
<font size="3">Existem <?php echo $noatendimentos; ?> atendimentos arquivados.</font><br><br></center>
</td>
</tr>
<tr>
<td><a href="arquivados.php?ordenar=Data"><font color="black">Ordenar por data</font></a></td>
<td><a href="arquivados.php?ordenar=Campus"><font color="black">Ordenar por Campus</font></a></td>
</tr>
</table>
</center>
<center>
<tbody>
<table border="1" >

<tr>
<td><center><b>No.</b></center></td>
<td><center><b>Data Atendimento</b></center></td>
<td><center><b>Hora Atendimento</b></center></td>
<td><center><b>Nome</b></center></td>
<td><center><b>Gênero</b></center></td>
<td><center><b>Idade</b></center></td>
<td><center><b>Local</b></center></td>
<td><center><b>Já foi atendido antes?</b></center></td>
<td><center><b>Foi encaminhado?</b></center></td>
<td><center><b>Atendido por</b></center></td>
<td><center><b>Status Atendimento</b></center></td>
<td><center><b>CPF</b></center></td>
<td><center><b>Data de Nascimento</b></center></td>
<td><center><b>Cidade</b></center></td>
<td><center><b>Estado</b></center></td>
<td><center><b>Telefone Preferencial</b></center></td>
<td><center><b>Telefone Alternativo</b></center></td>
<td><center><b>E-mail</b></center></td>
<td><center><b>Curso Graduação</b></center></td>
<td><center><b>Período Graduação</b></center></td>
<td><center><b>Turno Graduação</b></center></td>
<td><center><b>Bolsista?</b></center></td>
<td><center><b>SIAPE Docente</b></center></td>
<td><center><b>Matrícula EAD</b></center></td>
<td><center><b>Curso EAD</b></center></td>
<td><center><b>Pólo EAD</b></center></td>
<td><center><b>Período EAD</b></center></td>
<td><center><b>Empresa Funcionário</b></center></td>
<td><center><b>Função Funcionário</b></center></td>
<td><center><b>Matrícula Pós</b></center></td>
<td><center><b>Curso Pós</b></center></td>
<td><center><b>SIAPE TA</b></center></td>
<td><center><b>Setor TA</b></center></td>
<td><center><b>Departamento TA</b></center></td>
</tr>
<?php while($dadosatendimento = mysql_fetch_array($atendimento))
{
	$cpfpaciente = $dadosatendimento["cpfusuario"];
	$paciente = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpfpaciente'") or die(mysql_error());
	$nomepaciente = mysql_fetch_assoc($paciente);
	
	$idadepaciente = floor((time() - strtotime($nomepaciente["nascimento"])) / 31556926);
	
	$cpfatendente = $dadosatendimento["arquivadopor"];
	$consultanome = mysql_query("SELECT nome FROM usuarios WHERE cpf = '$cpfatendente'") or die(mysql_error());	
	$nomeatendente = mysql_fetch_array($consultanome);
	
	$consultagrad = mysql_query("SELECT * FROM graduacao WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadosgrad = mysql_fetch_array($consultagrad);
	
	$consultadocente = mysql_query("SELECT * FROM docente WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadosdocente = mysql_fetch_array($consultadocente);
	
	$consultaead = mysql_query("SELECT * FROM ead WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadosead = mysql_fetch_array($consultaead);
	
	$consultafunc = mysql_query("SELECT * FROM funcionario WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadosfunc = mysql_fetch_array($consultafunc);
	
	$consultapos = mysql_query("SELECT * FROM posgraduacao WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadospos = mysql_fetch_array($consultapos);
	
	$consultatecnico = mysql_query("SELECT * FROM tecnico WHERE cpf = '$cpfpaciente'") or die(mysql_error());	
	$dadostecnico = mysql_fetch_array($consultatecnico);

	echo '
<tr>
<td>'.$dadosatendimento["idagendamento"].'</td>
<td>'.$dadosatendimento["data"].'</td>
<td>'.$dadosatendimento["hora"].'</td>
<td>'.$nomepaciente["nome"].'</td>
<td>'.$nomepaciente["sexo"].'</td>
<td>'.$idadepaciente.'</td>
<td>'.$dadosatendimento["local"].'</td>
<td>'.$dadosatendimento["statusatendimento"].'</td>
<td>'.$dadosatendimento["statusencaminhamento"].'</td>
<td>'.$nomeatendente["nome"].'</td>
<td>'.$dadosatendimento["cancelado"].'</td>
<td>'.$nomepaciente["cpf"].'</td>
<td>'.$nomepaciente["nascimento"].'</td>
<td>'.$nomepaciente["cidade"].'</td>
<td>'.$nomepaciente["estado"].'</td>
<td>'.$nomepaciente["telefonepref"].'</td>
<td>'.$nomepaciente["telefonealt"].'</td>
<td>'.$nomepaciente["email"].'</td>
<td>'.$dadosgrad["curso"].'</td>
<td>'.$dadosgrad["periodo"].'</td>
<td>'.$dadosgrad["turno"].'</td>
<td>'.$dadosgrad["bolsista"].'</td>

<td>'.$dadosdocente["siape"].'</td>

<td>'.$dadosead["matricula"].'</td>
<td>'.$dadosead["curso"].'</td>
<td>'.$dadosead["polo"].'</td>
<td>'.$dadosead["periodo"].'</td>

<td>'.$dadosfunc["empresa"].'</td>
<td>'.$dadosfunc["funcao"].'</td>

<td>'.$dadospos["matricula"].'</td>
<td>'.$dadospos["curso"].'</td>

<td>'.$dadostecnico["siape"].'</td>
<td>'.$dadostecnico["setor"].'</td>
<td>'.$dadostecnico["departamento"].'</td>
</tr>';
} ?>
</table>
</tbody>
</center>
<br><br>
<br>


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
    
</body>
</html>
