<?php

   $title = "Create";
   require_once '../App/Database.php';
   require_once '../models/person.model.php';
   require_once '../controllers/person.controller.php';   
   require_once '../Layouts/head.php';

   $PersonController->get_CreatePerson (
      $PersonController->lname, 
      $PersonController->fname, 
      $PersonController->age, 
      $PersonController->bio, 
      $PersonController->website
   );      
?>
   <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
      <table>
         <tr>
            <th>Last Name: </th>
            <td><input type="text" name="lname" value="<?= $PersonController->lname; ?>"></td>
            <td><?= $PersonController->lnameErr; ?></td>
         </tr>
         <tr>
            <th>First Name: </th>
            <td><input type="text" name="fname" value="<?= $PersonController->fname; ?>"></td>
            <td><?= $PersonController->fnameErr; ?></td>
         </tr>
         <tr>
            <th>Age: </th>
            <td><input type="text" name="age" value="<?= $PersonController->age; ?>"></td>
            <td><?= $PersonController->ageErr; ?></td>
         </tr>
         <tr>
            <th>Bio: </th>
            <td><textarea name="bio" cols="30" rows="10"><?= $PersonController->bio; ?></textarea></td>
            <td><?= $PersonController->bioErr; ?></td>
         </tr>
         <tr>
            <th>Website: </th>
            <td><input type="text" name="website" value="<?= $PersonController->website; ?>"></td>
            <td><?= $PersonController->websiteErr; ?></td>
         </tr>
      </table>
      <button type="submit" name="<?= $PersonController::$createBtn; ?>">Create</button>  
   </form>

<?php require_once '../Layouts/footer.php'; ?>