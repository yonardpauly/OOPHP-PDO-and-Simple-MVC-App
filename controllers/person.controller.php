<?php

interface CrudInterfaces
{
   function get_ShowPerson ( $person_id );
   function get_CreatePerson ( $lname, $fname, $age, $bio, $website );
   function get_UpdatePerson ( $lname, $fname, $age, $bio, $website, $person_id );
   function get_DeletePerson ( $person_id );
}

$PersonController = new class extends PersonModel implements CrudInterfaces
{
   function get_ShowPerson ( $person_id ) {

      return $this->set_ShowPerson( $person_id )->fetch();
   } // End function
# =======================================================================================
   private function validate ( $data ) {

      $data = trim($data);
      $data = stripslashes($data);
      $data = strip_tags($data);
      return $data;
   } // End function
# =======================================================================================
   // Inputs Error Handler
   public $lnameErr = "";
   public $fnameErr = "";
   public $ageErr = "";
   public $bioErr = "";
   public $websiteErr = "";
   // Inputs Handler
   public $lname = "";
   public $fname = "";
   public $age = "";
   public $bio = "";
   public $website = "";

   public static $createBtn = "createPerson";
   public static $updateBtn = "updatePerson";   
# =======================================================================================

   // CREATE FUNCTION //

# =======================================================================================
   function get_CreatePerson ( $lname, $fname, $age, $bio, $website ) {
      
      if ( isset($_POST[self::$createBtn]) ) {
      
         $lname = $this->validate( ucwords($_POST['lname']) );
         $this->lname = $lname;      

         $fname = $this->validate( ucwords($_POST['fname']) );
         $this->fname = $fname;      

         $age = $this->validate( $_POST['age'] );
         $this->age = $age;      

         $bio = $this->validate( $_POST['bio'] );
         $this->bio = $bio;      

         $website = $_POST['website'];
         $this->website = $website;      
# =======================================================================================
         if ( empty($lname) ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Last name field is required.</div>";

         } elseif ( strlen($lname) > 250 ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Too long.</div>";
               $this->lname = "";

         } elseif ( !preg_match("/^[a-zA-Z ]*$/", $lname) ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
               $this->lname = "";

         } else { $this->lnameErr = ""; }
# =======================================================================================
         if ( empty($fname) ) {

               $this->fnameErr = "<div style='color: red; font-weight: bold'>First name field is required.</div>";

         } elseif ( strlen($fname) > 250 ) {
         
               $this->fnameErr = "<div style='color: red; font-weight: bold'>Too long.</div>";
               $this->fname = "";

         } elseif ( !preg_match("/^[a-zA-Z ]*$/", $fname) ) {
         
               $this->fnameErr = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
               $this->fname = "";

         } else { $this->fnameErr = ""; }
# =======================================================================================
         if ( empty($age) ) {

               $this->ageErr = "<div style='color: red; font-weight: bold'>Age field is required.</div>";

         } elseif ( strlen($age) > 2 ) {
         
               $this->ageErr = "<div style='color: red; font-weight: bold'>Invalid age input.</div>";
               $this->age = "";

         } elseif ( !preg_match("/^[0-9]*$/", $age) ) {
         
               $this->ageErr = "<div style='color: red; font-weight: bold'>Must a number input.!</div>";
               $this->age = "";

         } else { $this->ageErr = ""; }
# =======================================================================================
         if ( !empty($bio) ) {

               if ( !preg_match("/^[a-zA-Z0-9,.?;:!@#%&()-_ ]*$/", $bio) ) {

                     $this->bioErr = "<div style='color: red; font-weight: bold'>Only a-z/A-Z/0-9/,.?;:!@#%&()-_ and a space is allowed.</div>";

               } elseif ( strlen($bio) > 1000 ) {

                     $this->bioErr = "<div style='color: red; font-weight: bold'>Your bio is too long, please reduce it first.</div>";
               }
         } else { $this->bioErr = ""; }
# =======================================================================================
         if ( !empty($website) ) {
         
               if ( !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website) ) {

                     $this->websiteErr = "<div style='color: red; font-weight: bold'>Invalid website URL.</div>";
                     $this->website = "";

               } elseif ( !filter_var($website, FILTER_VALIDATE_URL) ) {

                     $this->websiteErr = "<div style='color: red; font-weight: bold'>Invalid website URL.</div>";
                     $this->website = "";

               } elseif ( strlen($website) > 250 ) {

                     $this->websiteErr = "<div style='color: red; font-weight: bold'>Your website URL is too long.</div>";
                     $this->website = "";
         }  
         } else { $this->websiteErr = ""; }
# =======================================================================================
         if ( empty($this->lnameErr) && empty($this->fnameErr) && empty($this->ageErr) && empty($this->bioErr) && empty($this->websiteErr) ) {

               $this->set_CreatePerson (  $lname, $fname, $age, $bio, $website );
               $_SESSION['alert']['create'] = "<h3 style='color:green'>Create Successful!</h3>";
               header( 'location: ../index.php?create=success' );
               unset( $_POST );
               exit;
         }
   }     
} // End function
# =======================================================================================

   // UPDATE FUNCTION //

# =======================================================================================
   function get_UpdatePerson ( $lname, $fname, $age, $bio, $website, $person_id ) {

      if ( isset($_POST[self::$updateBtn]) ) {
            
         $lname = $this->validate( ucwords($_POST['lname']) );
         $this->lname = $lname;      

         $fname = $this->validate( ucwords($_POST['fname']) );
         $this->fname = $fname;      

         $age = $this->validate( $_POST['age']);
         $this->age = $age;      

         $bio = $this->validate( $_POST['bio'] );
         $this->bio = $bio;      

         $website = $_POST['website'];
         $this->website = $website;      
# =======================================================================================
         if ( empty($lname) ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Last name field is required.</div>";

         } elseif ( strlen($lname) > 250 ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Too long.</div>";
               $this->lname = "";

         } elseif ( !preg_match("/^[a-zA-Z ]*$/", $lname) ) {

               $this->lnameErr = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
               $this->lname = "";

         } else { $this->lnameErr = ""; }
# =======================================================================================
         if ( empty($fname) ) {

               $this->fnameErr = "<div style='color: red; font-weight: bold'>First name field is required.</div>";

         } elseif ( strlen($fname) > 250 ) {
         
               $this->fnameErr = "<div style='color: red; font-weight: bold'>Too long.</div>";
               $this->fname = "";

         } elseif ( !preg_match("/^[a-zA-Z ]*$/", $fname) ) {
         
               $this->fnameErr = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
               $this->fname = "";

         } else { $this->fnameErr = ""; }
# =======================================================================================
         if ( empty($age) ) {

               $this->ageErr = "<div style='color: red; font-weight: bold'>Age field is required.</div>";

         } elseif ( strlen($age) > 2 ) {
               
               $this->ageErr = "<div style='color: red; font-weight: bold'>Invalid age input.</div>";
               $this->age = "";

         } elseif ( !preg_match("/^[0-9]*$/", $age) ) {
         
               $this->ageErr = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
               $this->age = "";

         } else { $this->ageErr = ""; }
# =======================================================================================
         if ( !empty($bio) ) {

         if ( !preg_match("/^[a-zA-Z0-9,.?;:!@#%&()-_ ]*$/", $bio) ) {

               $this->bioErr = "<div style='color: red; font-weight: bold'>Only a-z/A-Z/0-9/,.?;:!@#%&()-_ and a space is allowed.</div>";

         } elseif ( strlen($bio) > 1000 ) {

               $this->bioErr = "<div style='color: red; font-weight: bold'>Your bio is too long, please reduce it first.</div>";
         }
         } else { $this->bioErr = ""; }
# =======================================================================================
         if ( !empty($website) ) {
         
         if ( !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website) ) {

               $this->websiteErr = "<div style='color: red; font-weight: bold'>Invalid website URL.</div>";
               $this->website = "";

         } elseif ( !filter_var($website, FILTER_VALIDATE_URL) ) {

               $this->websiteErr = "<div style='color: red; font-weight: bold'>Invalid website URL.</div>";
               $this->website = "";

         } elseif ( strlen($website) > 250 ) {

               $this->websiteErr = "<div style='color: red; font-weight: bold'>Your website URL is too long.</div>";
               $this->website = "";
         }
         } else { $this->websiteErr = ""; }
# =======================================================================================
         if ( empty($this->lnameErr) && empty($this->fnameErr) && empty($this->ageErr) && empty($this->bioErr) && empty($this->websiteErr) ) {

               $this->set_UpdatePerson (  $lname, $fname, $age, $bio, $website, $person_id );
               $_SESSION['alert']['update'] = "<h3 style='color:green'>Update Successful!</h3>";
               header( 'location: ../index.php?update=success' );
               unset( $_POST );
               exit;
         }
   }
} // End function
# =======================================================================================

   // DELETE FUNCTION //

# =======================================================================================
   function get_DeletePerson ( $person_id ) {

      $delete = $this->set_DeletePerson( $person_id );
      header( 'location: index.php?delete=success' );
      return $delete;    
   } // End function
# =======================================================================================      
}; // End class