<?php

	$title = "Home";
	require_once 'App/Database.php';

	require_once 'models/index.model.php';
	require_once 'controllers/index.controller.php';	
	require_once 'Layouts/head.php';

	require_once 'models/person.model.php';		
	require_once 'controllers/person.controller.php';

	$data = $IndexController->getAllPerson();

	if ( isset($_POST['deletePerson']) ) {

		$person_id = $_GET['person_id'];
		$PersonController->get_DeletePerson( $person_id );
	}
?>
	<a href="person/create.php">Create</a>
	<table>
	<tr>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Age</th>
		<th>Bio</th>
		<th>Website</th>
		<th>Created Date</th>
		<th>Updated Date</th>
		<th>Actions</th>
	</tr>
	<?php if ( $data->rowCount() < 1 ): ?>
		<td colspan="8" align="center"><strong>No data found</strong></td>
	<?php else: ?>
	<?php foreach ( $data as $row ): ?>
	<tr align="center">
		<td><?= $row->lname; ?></td>
		<td><?= $row->fname; ?></td>
		<td><?= $row->age; ?></td>
		<td><?= $row->bio; ?></td>
		<td><?= $row->website; ?></td>
		<td><?= $row->created_at; ?></td>
		<td><?= $row->updated_at; ?></td>
		<td>
			<a href="person/edit.php?person_id=<?= $row->person_id; ?>">Edit</a>
			<br />
			<form action="index.php?person_id=<?= $row->person_id; ?>" method="POST">
				<button type="submit" name="deletePerson">Delete</button>	
			</form>		
		</td>	
	</tr>
	<?php endforeach;	?>
	<?php endif; ?>
</table>

<?php require_once 'Layouts/footer.php';