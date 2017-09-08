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
$naoredirecionar = 0;

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

	$cpf = $_POST['cpf'];

    $atendido = $_POST['atendido']; 

    $encaminhado = $_POST['encaminhado'];

    $textoencaminhado = $_POST['textoencaminhamento'];

	$textomotivo = $_POST['textomotivo'];

    $dia = $_POST['dia'];	 

	$hora = $_POST['agendamento'];

	$local = $_POST['local'];
	
	$idagendamento = $_POST['idagendamento'];

    if(empty($hora) || empty($textomotivo) || empty($encaminhado) || empty($atendido)){

        $erro = "Você deve preencher todos os campos!";

    }else{

        

       $sql = mysql_query("INSERT INTO `atendimentopsicologico`(`cpfusuario`, `statusatendimento`, `statusencaminhamento`, `encaminhamento`, `motivo`, `data`, `hora`, `local`, `idagendamento`) 
	   VALUES ('$cpf', '$atendido', '$encaminhado', '$textoencaminhado', '$textomotivo', '$dia', '$hora', '$local', '$idagendamento')") or die(mysql_error());
		$idinsercao = mysql_insert_id();
	   $linha = mysql_affected_rows();
	   
	   $sql2 = mysql_query("UPDATE agenda SET ativo = 0 WHERE id = '$idagendamento'") or die(mysql_error());

            if($linha == 1){
				$naoredirecionar = 1;
                $erro = "Agendamento realizado com sucesso!";
				$consulta = mysql_query("SELECT * FROM atendimentopsicologico WHERE id = '$idinsercao'") or die(mysql_error());
				$dados = mysql_fetch_array($consulta);
				$consultausuario = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpf'") or die(mysql_error());
				$dadosusuario = mysql_fetch_array($consultausuario);
				
				//send_mail(	'naoresponda@proace.ufvjm.edu.br',
				//		$dadosusuario['email'],
				//		'Informações sobre o seu agendamento - DASA/PROACE',
				//		'Dados do seu Agendamento:<br>Data: '.$dados['data'].'
				//		<br>Horário: '.$dados['hora'].' 
				//		<br>Local: '.$dados['local'].'
				//		<br>Informações importantes!<br>Caso não seja possível comparecer ao atendimento psicológico, é obrigatório cancelar o agendamento. Basta acessar o Sistema da DASA/Proace com o seu login e senha e solicitar o cancelamento até uma hora antes do horário agendado.
				//		Caso o usuário não cancele o agendamento e não compareça ao atendimento, será impedido pelo Sistema de realizar novo agendamento nas próximas duas semanas.');

              } else{

                  $erro = "Não foi possivel realizar o agendamento.";

              }

    }

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agendar Atendimento Psicológico</title>
    
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

<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>DASA/PROACE</h1>
				<h2>Diretoria de Atenção à<br>Saúde e Acessibilidade</h2>			
				<p class="grey" style="color: #B7DD76" >Campus JK – Diamantina/MG.<br>  
				PABX: (38) 3532-1200 Ramal 8126<br>
				E-mail: dasa.proace@ufvjm.edu.br<br>
</p>
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
	
	<style type="text/css">


.tabela{

background:#fff;

width:200px;

padding:0px;

border:1px solid #f0f0f0;

float:left;

margin-right:20px;

}

.tabela2{

margin-left:220px;

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
	echo '<form name="form1" action="agendar.php" method="POST" style="padding-top:10px;">';
	
	if(isset($erro)){

    print '<div style="width:100%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center; margin: 0 auto;">'.$erro.'</div>';
	}
	
$usuario = $_SESSION['user'];
$consultacpf = mysql_query("SELECT cpf FROM login WHERE user = '$usuario'") or die(mysql_error());
$querycpf = mysql_fetch_assoc($consultacpf);
$cpfusuario = $querycpf["cpf"];
$consulta = mysql_query("SELECT * FROM usuarios WHERE cpf = '$cpfusuario'") or die(mysql_error());
$dadosusuario = mysql_fetch_array($consulta);
$campususuario = $dadosusuario["campus"];
$nivel = $dadosusuario["classeusuario"];
	
if (!($nivel == 1 || $nivel == 2 || $nivel == 3 || $nivel == 4 || $nivel == 5 || $nivel == 6 || $nivel == 7))
	{
		echo'<script type="text/javascript">
           window.location = "index.php"
      </script>';
	exit;
	}

$valido = mysql_query("SELECT * FROM atendimentopsicologico WHERE cpfusuario = '$cpfusuario'") or die(mysql_error());
$possuiconsulta = mysql_num_rows($valido);
if ($possuiconsulta > 0 && $naoredirecionar == 0)
{
	echo'<script type="text/javascript">
           window.location = "erroatendimento.php"
      </script>';
	exit;
}

print '<h1>Agendar Atendimento Psicológico</h1><br>';
print '<b><font size="3">Selecione a data do atendimento<font color="red">*</font>:</font></b><br><br>';
include "sql.php";//conexão com o banco de dados

@mysql_select_db($db);//selecione o banco de dados

if(empty($_GET['data'])){//navegaçao entre os meses

    $dia = date('d');

    $month =ltrim(date('m'),"0");

    $ano = date('Y');

}else{

    $data = explode('/',$_GET['data']);//nova data

    $dia = $data[0];

    $month = $data[1];

    $ano = $data[2];

}

if($month==1){//mês anterior se janeiro mudar valor

    $mes_ant = 12;

    $ano_ant = $ano - 1;

}else{

    $mes_ant = $month - 1;

    $ano_ant = $ano;

}
if($month==12){//proximo mês se dezembro tem que mudar

    $mes_prox = 1;

    $ano_prox = $ano + 1;

}else{

    $mes_prox = $month + 1;

    $ano_prox = $ano;

}



$hoje = date('j');//função importante pego o dia corrente

switch($month.$n){/*notem duas variaveis para o switch para identificar dia e limitar numero de dias*/

    case 1: $mes = "JANEIRO";

            $n = 31;

    break;

    case 2: $mes = "FEVEREIRO";// todo ano bixesto fev tem 29 dias

            $bi = $ano % 4;//anos multiplos de 4 são bixestos

            if($bi == 0){

                $n = 29;

            }else{

                $n = 28;

            }

    break;

    case 3: $mes = "MARÇO";

            $n = 31;

    break;

    case 4: $mes = "ABRIL";

            $n = 30;

    break;

    case 5: $mes = "MAIO";

            $n = 31;

    break;

    case 6: $mes = "JUNHO";

            $n = 30;

    break;

    case 7: $mes = "JULHO";

            $n = 31;

    break;

    case 8: $mes = "AGOSTO";

            $n = 31;

    break;

    case 9: $mes = "SETEMBRO";

            $n = 30;

    break;

    case 10: $mes = "OUTUBRO";

            $n = 31;

    break;

    case 11: $mes = "NOVEMBRO";

            $n = 30;

    break;

    case 12: $mes = "DEZEMBRO";

            $n = 31;

    break;

}



$pdianu = mktime(0,0,0,$month,1,$ano);//primeiros dias do mes

$dialet = date('D', $pdianu);//escolhe pelo dia da semana

switch($dialet){//verifica que dia cai

    case "Sun": $branco = 0; break;

    case "Mon": $branco = 1; break;

    case "Tue": $branco = 2; break;

    case "Wed": $branco = 3; break;

    case "Thu": $branco = 4; break;

    case "Fri": $branco = 5; break;

    case "Sat": $branco = 6; break;

}            



    print '<table class="tabela" >';//construção do calendario

    print '<tr>';

    print '<td class="mes"><a href="?data='.$dia.'/'.$mes_ant.'/'.$ano_ant.'" title="Mês anterior">  &laquo; </a></td>';/*mês anterior*/

    print '<td class="mes" colspan="5">'.$mes.'/'.$ano.'</td>';/*mes atual e ano*/

    print '<td class="mes"><a href="?data='.$dia.'/'.$mes_prox.'/'.$ano_prox.'" title="Próximo mês">  &raquo; </a></td>';/*Proximo mês*/

    print '</tr><tr>';

    print '<td class="sem">D</td>';//printar os dias da semana

    print '<td class="sem">S</td>';

    print '<td class="sem">T</td>';

    print '<td class="sem">Q</td>';

    print '<td class="sem">Q</td>';

    print '<td class="sem">S</td>';

    print '<td class="sem">S</td>';

    print '</tr><tr>';

    $dt = 1;

    if($branco > 0){

        for($x = 0; $x < $branco; $x++){

             print '<td>&nbsp;</td>';/*preenche os espaços em branco*/

            $dt++;

        }

    }

    

    for($i = 1; $i <= $n; $i++ ){/*agora vamos no banco de dados verificar os evendos*/

            $dtevento = $i."-".$month."-".$ano;

        $sqlag = mysql_query("SELECT * FROM agenda WHERE dtevento = '$dtevento' AND local ='$campususuario' AND ativo = 1") or die(mysql_error());

                $num = mysql_num_rows($sqlag);/*quantos eventos tem para o mes*/

                $idev = @mysql_result($sqlag, 0, "dtevento");

                $eve = @mysql_result($sqlag, 0, "evento");              

                if(($num > 0 && $i >= date('d') && $month >= date('m')) || ($num > 0 && $ano > date('Y'))){/*so mostra eventos atuais e futuros. Os antigos nao podem ser visualizados*/

           print '<td class="evt">';

           print '<a href="?d='.$idev.'&data='.$dia.'/'.$month.'/'.$ano.'" title="'.$eve.'">'.$i.'</a>';

           print '</td>';

           $dt++;/*incrementa os dias da semana*/

                   $qt++;/*quantos eventos tem no mes*/

        }elseif($i == $hoje){/*imprime os dia corrente*/

            print '<td class="hj">';

            print $i;

            print '</td>';

            $dt++;

        

        }elseif($dt == 1){/*imprime os domingos*/

            print '<td class="dom">';

            print $i;

            print '</td>';

            $dt++;

        }else{/*imprime os dias normais*/

                    print '<td class="td">';

            print $i;

            print '</td>';

            $dt++;

                }

        if($dt > 7){/*faz a quebra no sabado*/

        print '</tr><tr>';

        $dt = 1;

        }

    }

    print '</tr>';

    print '</table>';

        if($qt > 0){/*se tiver evento no mês imprime quantos tem */

          print "Selecione a data de atendimento<font color=red>*</font>: em verde estão os dias disponíveis para agendamento.";/*mudar para caixa baixa as letras do mes*/

        }
		else
		{
			print "Não temos nenhum atendimento em ".strtolower($mes)." no momento.<br>";
		}

if(isset($_GET['d'])){/*link dos dias de eventos*/

    $idev = $_GET['d'];
	
    $sqlev = mysql_query("SELECT * FROM agenda WHERE dtevento = '$idev' AND ativo = 1 ORDER BY hora ASC") or die(mysql_error());

    $numev = mysql_num_rows($sqlev);
	
	
	print	 "<br>Escolha um dos horários disponíveis e clique em <b>Selecionar esta data e horário</b>.<br><br>";

    for($j = 0; $j < $numev; $j++){/*caso no mesmo dia tenha mais eventos continua imprimindo */

    $eve = @mysql_result($sqlev, $j, "evento");/*pegando os valores do banco referente ao evento*/

    $dev = @mysql_result($sqlev, $j, "dtevento");

    $dsev = @mysql_result($sqlev, $j, "conteudo");

    $auev = @mysql_result($sqlev, $j, "autor");

    $lev = @mysql_result($sqlev, $j, "local");

    $psev = @mysql_result($sqlev, $j, "data");
	
	$idev = @mysql_result($sqlev, $j, "id");

    $nowev = date('d/m/Y - H:i', strtotime($psev));/*transforma a data para data padrão brazil*/

    $hev = @mysql_result($sqlev, $j, "hora");


print '<table class="tabela2" width="300" cellspacing="0" cellpadding="0">';/*monta a tabela de eventos*/

print '<tr><td class="show">'.$dev.' - Atendimento Psicológico</td></tr>';

print '<tr><td class="linha"><b>Hora: </b>'.$hev.'hs</td></tr>';

print '<tr><td class="linha"><b>Local: </b>'.$lev.'</td></tr>';

print '<tr><td class="linha"><b>Psicólogo: </b>'.$auev.'</td></tr>';

//print '<tr><td class="linha"><b>Descrição: </b>'.nl2br($dsev).'</td></tr>';/*mantem o quebra da linha para dascriçao do evento*/

//print '<tr><td class="linha"><b>Postado: </b><small>'.$nowev.'hs por '.$auev.'</small></td></tr>';

print '<tr><td><input type="hidden" name="idagendamento"  class="campo" id="idagendamento" value="'.$idev.'" /></td></td>';

print '<tr><td class="linha"><input type="radio" name="agendamento" value="'.$hev.'" id="agendamento"/>Selecionar esta data e horário</td></tr>';

print '</table><br>';

    }


}
else { 
print '<br><br><br><br><br><br><br><br><br><br><br>';
}

?>
<br><br><b><font size="3">Preencha as informações abaixo:</font></b><br><br>
Já foi atendido pelo Serviço de Psicologia da Proace anteriormente? <font color="red">*</font><br>
<input type="radio" name="atendido" value="Sim" id="atendido"/>Sim
 <input type="radio" name="atendido" value="Não" id="atendido2"/>Não<br><br>
Você buscou atendimento em razão de algum encaminhamento? <font color="red">*</font><br>
<input type="radio" name="encaminhado" value="Sim" id="encaminhado"/>Sim
<input type="radio" name="encaminhado" value="Não" id="encaminhado2"/>Não<br><br>
Foi encaminhado por quem?<br>
<textarea name="textoencaminhamento" rows="5" cols="80" id="textoencaminhamento"></textarea><br><br>
Descreva o motivo para o qual está solicitando o atendimento psicológico<font color="red">*</font><br>
<textarea name="textomotivo" rows="5" cols="80" id="textomotivo"></textarea><br>
<font color="red" size="2">* Indica um item de preenchimento obrigatório.</font><br><br>
<?php print '<input type="hidden" name="dia" value="'.$dev.'" id="dia"/>'; ?>
<?php print '<input type="hidden" name="local" value="'.$lev.'" id="local"/>'; ?>
<input name="cpf" type="hidden" class="campo" id="cpf" value="<?php echo $querycpf["cpf"]; ?>" />
<center><input type="submit" value="Confirmar Agendamento" /><input type="hidden" name="done" value="" /></center>
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
