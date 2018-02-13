<?php

   $title = "Edit";
   require_once '../App/Database.php';
   require_once '../models/person.model.php';
   require_once '../controllers/person.controller.php';
   include_once '../Layouts/head.php';

   $person_id = $_GET['person_id'];
   $data = $PersonController->get_ShowPerson( $person_id );

   $PersonController->get_UpdatePerson (
      
      $PersonController->lname, 
      $PersonController->fname, 
      $PersonController->age, 
      $PersonController->bio, 
      $PersonController->website, 
      $person_id 
   );

?>
   <form action="" method="POST">
      <table>
         <tr>
            <th>Last Name: </th>
            <td><input type="text" name="lname" value="<?= $data->lname; ?>"></td>
            <td><?= $PersonController->lnameErr; ?></td>
         </tr>
         <tr>
            <th>First Name: </th>
            <td><input type="text" name="fname" value="<?= $data->fname; ?>"></td>
            <td><?= $PersonController->fnameErr; ?></td>
         </tr>
         <tr>
            <th>Age: </th>
            <td><input type="text" name="age" value="<?= $data->age; ?>"></td>
            <td><?= $PersonController->ageErr; ?></td>
         </tr>
         <tr>
            <th>Bio: </th>
            <td><textarea name="bio" cols="30" rows="10"><?= $data->bio; ?></textarea></td>
            <td><?= $PersonController->bioErr; ?></td>
         </tr>
         <tr>
            <th>Website: </th>
            <td><input type="text" name="website" value="<?= $data->website; ?>"></td>
            <td><?= $PersonController->websiteErr; ?></td>
         </tr>
      </table>
      <button type="submit" name="<?= $PersonController::$updateBtn; ?>">Update</button>      
   </form>

<?php include_once '../Layouts/footer.php';