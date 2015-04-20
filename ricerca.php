<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("Ricerca","Team Cannondale",$login);

print_menu("ricerca",$login);

$self = $_SERVER['PHP_SELF'];

$query = "SELECT p.Id,p.Nome,p.Cognome
		  FROM PersoneFisiche p NATURAL JOIN Ciclisti c";
$result = mysql_query($query,$conn) or fail_query();

echo<<<END
<form method="post" action="$self" name="button">
<fieldset class="modifica">
<legend>Form di ricerca info ciclisti</legend>
<label for="nome">Ricerca Ciclisti</label> 
<select id="nome" name="nome">
<option selected="selected"> </option>
END;
	while($row = mysql_fetch_row($result))
		echo "<option name=\"id\" value=\"$row[0]\">$row[1] $row[2]</option>";
	echo "<option name=\"id\" value=\"TUTTI\">TUTTI</option>
		  </select>";
echo<<<END
<label for="info">Per</label>
<select id="info" name="info">
<option selected="selected"> </option>
<option name="obj" value="piazzamenti">Piazzamenti</option>
<option name="obj" value="finali">Vittorie Finali</option>
<option name="obj" value="parziali">Vittorie Parziali</option>
<option name="obj" value="totali">Vittorie Totali</option>
</select>
<input type="submit" id="submit" value="Ricerca" name="button" />
</fieldset>
</form>
END;

if(isset($_REQUEST['button']))
{
	echo "<div id=\"ricerca\">";
	if(!$_POST['nome'] || !$_POST['info'])
		echo "<p class=\"err_mex\">Scegliere una delle opzioni disponibili su entrambi i men&ugrave a tendina .</p>";
	else
	{
		if($_POST['info'] == "totali")
		{
			$query = "SELECT Nome,Cognome,VittorieParziali,VittorieTotali FROM Vittorie ";
			if($_POST['nome'] == "TUTTI")
				print_sub("Vittorie Complessive Ciclisti");
			else
			{
				print_sub("Vittorie Complessive Ciclista");
				$query .= "WHERE Id=\"$_POST[nome]\" ";
			}
			$titolo = array("Nome","Cognome","Vittorie Parziali","Vittorie Totali");
		}
		else
		{
			$select = "SELECT p.Nome,p.Cognome,co.NomeCorsa";
			$from = " FROM PersoneFisiche p,CiclistiCorse cc,Corse co";
			$where = " WHERE p.Id = cc.Id AND cc.IdCorsa = co.IdCorsa ";
			if($_POST['info'] == "piazzamenti")
			{
				if($_POST['nome'] == "TUTTI")
					print_sub("Piazzamenti Ciclisti");
				else
				{
					print_sub("Piazzamenti Ciclista");
					$where .= "AND p.Id=\"$_POST[nome]\" ";
				}	
				$select .= ",cc.Piazzamento";
				$where .= "AND cc.Piazzamento <> \"NULL\" ";
				$titolo = array("Nome","Cognome","Corsa","Piazzamento");
			}
			if($_POST['info'] == "finali")
			{
				if($_POST['nome'] == "TUTTI")
					print_sub("Vittorie Finali Ciclisti");
				else
				{
					print_sub("Vittorie Finali Ciclista");
					$where .= "AND p.Id=\"$_POST[nome]\" ";
				}	
				$select .= ",cc.Piazzamento";
				$where .= "AND cc.Piazzamento=\"1\" ";
				$titolo = array("Nome","Cognome","Corsa","Piazzamento");	
			}	
			if($_POST['info'] == "parziali")
			{
				if($_POST['nome'] == "TUTTI")
					print_sub("Vittorie Parziali Ciclisti");
				else
				{
					print_sub("Vittorie Parziali Ciclista");
					$where .= "AND p.Id=\"$_POST[nome]\" ";
				}
				$select .= ",t.Numero";
				$from .= ",Tappe t";
				$where .= "AND co.IdCorsa = t.IdCorsa AND t.VintaDa = p.Id ";
				$titolo = array("Nome","Cognome","Corsa","Tappa");
			}
			$query = $select . $from . $where;
		}
		$risultato = mysql_query($query,$conn) or fail_query();
		
		table_start($titolo);
		while($row = mysql_fetch_row($risultato))
		{
			echo "<tr>";
			foreach ($row as $field) 
				if($field)
					echo "<td>$field</td>\n";
				else
					echo "<td>---</td>\n";
		}
		table_end();
		echo "</div>";		
	}
}


print_footer();
?>
