
<table border='5'>
	<thead>
		<tr>
			<th>Usename</th>
			<th>Password</th>
		</tr>
	</thead>
	<tbody>
		
		<?php
		foreach($users as $user){
			echo "<tr>";
			echo "<td> $user->username</td>";
			echo "<td> $user->password</td>";
			echo "</tr>";
		}
		?>
	</tbody>
</table>

<?php
/*
foreach($users as $user){
	echo $user->username." ".$user->password."</br>";
}
*/
?>
