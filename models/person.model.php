<?php

class PersonModel extends Database
{
   protected function set_ShowPerson ( $person_id ) {

      return self::query( "SELECT * FROM people WHERE person_id = ?", [$person_id] );
   }   
# ====================================================================================
   protected function set_CreatePerson ( $lname, $fname, $age, $bio, $website ) {

      return self::query( "INSERT INTO people ( lname, fname, age, bio, website ) VALUES ( ?, ?, ?, ?, ? )", [

         $lname, $fname, $age, $bio, $website
      ]);
   }
# ====================================================================================
   protected function set_UpdatePerson ( $lname, $fname, $age, $bio, $website, $person_id ) {
      
      return self::query( "UPDATE people SET lname = ?, fname = ?, age = ?, bio = ?, website = ? WHERE person_id = ?", [

         $lname, $fname, $age, $bio, $website, $person_id
      ]);
   }
# ====================================================================================
   protected function set_DeletePerson ( $person_id ) {

      return self::query( "DELETE FROM people WHERE person_id = ?", [$person_id] );
   }
}