<?php

interface CrudInterfaces
{
   function get_ShowPerson ( $person_id );
   function get_CreatePerson ( $lname, $fname, $age, $bio, $website );
   function get_UpdatePerson ( $lname, $fname, $age, $bio, $website, $person_id );
   function get_DeletePerson ();
}

$PersonController = new class extends PersonModel implements CrudInterfaces
{
   function get_ShowPerson ( $person_id ) {

      return $this->set_ShowPerson( $person_id )->fetch();
   } // End ShowPerson method
# =======================================================================================
   private function validate ( $data ) {

      $data = trim($data);
      $data = stripslashes($data);
      $data = strip_tags($data);
      return $data;
   } // End validate method
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
   // Submit Buttons Handlers
   public static $createBtn = "createPerson";
   public static $updateBtn = "updatePerson";   
   public static $deleteBtn = "deletePerson";   
# =======================================================================================
   // Regex Error Handler
   private static $lnameEmpty = "<div style='color: red; font-weight: bold'>Last name field is required.</div>";
   private static $fnameEmpty = "<div style='color: red; font-weight: bold'>First name field is required.</div>";
   private static $ageEmpty = "<div style='color: red; font-weight: bold'>Age field is required.</div>";

   private static $nameStrlen = "<div style='color: red; font-weight: bold'>Your input is too long.</div>";
   private static $ageStrlen = "<div style='color: red; font-weight: bold'>Invalid age input. You are too old</div>";
   private static $urlStrLen = "<div style='color: red; font-weight: bold'>Your website URL is too long.</div>";

   private static $namePattern = "/^[a-zA-Z ]*$/";
   private static $intPattern = "/^[0-9]*$/";
   private static $strPattern = "/^[a-zA-Z0-9,.?;:!@#%&()-_ ]*$/";
   private static $urlPattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

   private static $namePregMatch = "<div style='color: red; font-weight: bold'>Only letters and a space is allowed.!</div>";
   private static $intPregMatch = "<div style='color: red; font-weight: bold'>Must a number input.!</div>";
   private static $strPregMatch = "<div style='color: red; font-weight: bold'>Only a-z/A-Z/0-9/,.?;:!@#%&()-_ and a space is allowed.</div>";
   private static $urlPregMatch = "<div style='color: red; font-weight: bold'>Invalid website URL.</div>";

   private static $bioLength = "<div style='color: red; font-weight: bold'>Your bio is too long, please reduce it first.</div>";
# =======================================================================================

   // CREATE METHOD //

# =======================================================================================
   function get_CreatePerson ( $lname, $fname, $age, $bio, $website ) {
      
      if ( isset($_POST[self::$createBtn]) ) {
      
         $this->lname = $this->validate( ucwords($_POST['lname']) );
         $lname = $this->lname;

         $this->fname = $this->validate( ucwords($_POST['fname']) );
         $fname = $this->fname;

         $this->age = $this->validate( $_POST['age'] );
         $age = $this->age;

         $this->bio = $this->validate( $_POST['bio'] );
         $bio = $this->bio;

         $this->website = $_POST['website'];
         $website = $this->website;
# =======================================================================================
         if ( empty($lname) ) {

            $this->lnameErr = self::$lnameEmpty;

         } elseif ( strlen($lname) > 250 ) {

            $this->lnameErr = self::$nameStrlen;
            $this->lname = "";

         } elseif ( !preg_match(self::$namePattern, $lname) ) {

            $this->lnameErr = self::$namePregMatch;
            $this->lname = "";

         } else { $this->lnameErr = ""; }
# =======================================================================================
         if ( empty($fname) ) {

            $this->fnameErr = self::$fnameEmpty;

         } elseif ( strlen($fname) > 250 ) {
         
            $this->fnameErr = self::$nameStrlen;
            $this->fname = "";

         } elseif ( !preg_match(self::$namePattern, $fname) ) {
         
            $this->fnameErr = self::$namePregMatch;
            $this->fname = "";

         } else { $this->fnameErr = ""; }
# =======================================================================================
         if ( empty($age) ) {

            $this->ageErr = self::$ageEmpty;

         } elseif ( strlen($age) > 2 ) {
         
            $this->ageErr = self::$ageStrlen;
            $this->age = "";

         } elseif ( !preg_match(self::$intPattern, $age) ) {
         
            $this->ageErr = self::$intPregMatch;
            $this->age = "";

         } else { $this->ageErr = ""; }
# =======================================================================================
         if ( !empty($bio) ) {

            if ( !preg_match(self::$strPattern, $bio) ) {

                  $this->bioErr = self::$strPregMatch;

            } elseif ( strlen($bio) > 1000 ) {

                  $this->bioErr = self::$bioLength;
            }
         } else { $this->bioErr = ""; }
# =======================================================================================
         if ( !empty($website) ) {
         
            if ( !preg_match(self::$urlPattern, $website) ) {

               $this->websiteErr = self::$urlPregMatch;
               $this->website = "";

            } elseif ( !filter_var($website, FILTER_VALIDATE_URL) ) {

               $this->websiteErr = self::$urlPregMatch;
               $this->website = "";

            } elseif ( strlen($website) > 250 ) {

               $this->websiteErr = self::$urlPregMatch;
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
      } // End isset create
   } // End create method
# =======================================================================================

   // UPDATE METHOD //

# =======================================================================================
   function get_UpdatePerson ( $lname, $fname, $age, $bio, $website, $person_id ) {

      if ( isset($_POST[self::$updateBtn]) ) {
            
         $this->lname = $this->validate( ucwords($_POST['lname']) );
         $lname = $this->lname;

         $this->fname = $this->validate( ucwords($_POST['fname']) );
         $fname = $this->fname;

         $this->age = $this->validate( $_POST['age']);
         $age = $this->age;

         $this->bio = $this->validate( $_POST['bio'] );
         $bio = $this->bio;

         $this->website = $_POST['website'];
         $website = $this->website;
# =======================================================================================
         if ( empty($lname) ) {

            $this->lnameErr = self::$lnameEmpty;

         } elseif ( strlen($lname) > 250 ) {

            $this->lnameErr = self::$nameStrlen;
            $this->lname = "";

         } elseif ( !preg_match(self::$namePattern, $lname) ) {

            $this->lnameErr = self::$namePregMatch;
            $this->lname = "";

         } else { $this->lnameErr = ""; }
# =======================================================================================
         if ( empty($fname) ) {

            $this->fnameErr = self::$fnameEmpty;

         } elseif ( strlen($fname) > 250 ) {
         
            $this->fnameErr = self::$nameStrlen;
            $this->fname = "";

         } elseif ( !preg_match(self::$namePattern, $fname) ) {
         
            $this->fnameErr = self::$namePregMatch;
            $this->fname = "";

         } else { $this->fnameErr = ""; }
# =======================================================================================
         if ( empty($age) ) {

            $this->ageErr = self::$ageEmpty;

         } elseif ( strlen($age) > 2 ) {
               
            $this->ageErr = self::$ageStrlen;
            $this->age = "";

         } elseif ( !preg_match(self::$intPattern, $age) ) {
         
            $this->ageErr = self::$intPregMatch;
            $this->age = "";

         } else { $this->ageErr = ""; }
# =======================================================================================
         if ( !empty($bio) ) {

            if ( !preg_match(self::$strPattern, $bio) ) {

               $this->bioErr = self::$strPregMatch;

            } elseif ( strlen($bio) > 1000 ) {

               $this->bioErr = self::$bioLength;
            }

         } else { $this->bioErr = ""; }
# =======================================================================================
         if ( !empty($website) ) {
         
            if ( !preg_match(self::$urlPattern, $website) ) {

               $this->websiteErr = $urlPregMatch;
               $this->website = "";

            } elseif ( !filter_var($website, FILTER_VALIDATE_URL) ) {

               $this->websiteErr = self::$urlPregMatch;
               $this->website = "";

            } elseif ( strlen($website) > 250 ) {

               $this->websiteErr = self::$urlStrLen;
               $this->website = "";
            }

         } else { $this->websiteErr = ""; }
# =======================================================================================
         if ( empty($this->lnameErr) && empty($this->fnameErr) && empty($this->ageErr) && empty($this->bioErr) && empty($this->websiteErr) ) {

            $this->set_UpdatePerson (  $lname, $fname, $age, $bio, $website, $person_id );
            unset( $_POST );
            $_SESSION['alert']['update'] = "<h3 style='color:green'>Update Successful!</h3>";
            header( 'location: ../index.php?update=success' );
            exit;
         }
      } // End isset Update
   } // End method
# =======================================================================================

   // DELETE METHOD //

# =======================================================================================
   function get_DeletePerson () {

      if ( isset($_POST[self::$deleteBtn]) ) {

         $person_id = $_GET['person_id'];
         $this->set_DeletePerson( $person_id );
         header( 'location: index.php?delete=success' );
      } // End isset Delete
   } // End method
# =======================================================================================      
}; // End Anonymous class