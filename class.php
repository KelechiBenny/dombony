<?php

class DatabaseHandler {

    function connectToDB() {
        return mysqli_connect('localhost', 'root', '', 'dombony');
    }

    function getUserDetails($table, $username) {
        $query = "SELECT * FROM " . $table . " WHERE username = '" . $username . "'";
        $link = $this->connectToDB();
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);
        } else {
            return null;
        }
    }


    function createUserTable($table) {
        //user type 1 for admin and 0 for normal user
        $link = $this->connectToDB();
        $query = "CREATE TABLE IF NOT EXISTS " . $table . " (id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id), fullname VARCHAR(50) NOT NULL,
        username VARCHAR(20) NOT NULL, password VARCHAR(50) NOT NULL, email VARCHAR(40) NOT NULL, phonenumber VARCHAR(12) NOT NULL, bankname VARCHAR(40) NOT NULL, 
        accountholder VARCHAR(50),bankaccount VARCHAR(12) NOT NULL, usertype INT, date DATE NOT NULL, time TIME NOT NULL, UNIQUE KEY username (username))";
        $create = mysqli_query($link, $query);
        return $create;
    }
    
    function createTransactionTable($table) {
        $link = $this->connectToDB();
        $query = "CREATE TABLE IF NOT EXISTS " . $table . " (id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),
        username VARCHAR(20) NOT NULL, amount VARCHAR(20),topay VARCHAR(50),pop VARCHAR(100), paid VARCHAR(5), ref1 VARCHAR(30),idref1 INT, confirmref1 VARCHAR(5), ref2 VARCHAR(30),idref2 INT, confirmref2 VARCHAR(5), filled VARCHAR(5)
        ,date DATE NOT NULL, time TIME NOT NULL)";
        $create = mysqli_query($link, $query);
        return $create;
    }



    /**
     * Checks the given table to see if the email has already been used
     * @param type $email (string)
     * @param type $table (string)
     * @return returns true if the email doesnt exist and false if it exists
     */
    function checkemail($email, $table) {
        $link = $this->connectToDB();
        $str = "SELECT * FROM " . $table . " WHERE email = '" . $email . "'";
        mysqli_query($link, $str);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            //  echo 'email exists';
            return false;
        } else {
            // echo 'email doesnt exist';
            return true;
        }
    }

    /**
     * Checks a given table to see if the username has already been used
     * @param type $username (string)
     * @param type $table   (string)
     * @return boolean 
     */
    function checkusername($username, $table) {
        $link = $this->connectToDB();
        $str = "SELECT * FROM " . $table . " WHERE username = '" . $username . "'";
        mysqli_query($link, $str);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }

    /*     * inserts data into a table, returns true if operation was successful
     * and false if not successful
     * @param type $details(associative array)
     * @param type $table(string)
     * @return boolean 
     */

    function insertIntoUsers($details, $table) {
        $link = $this->connectToDB();
        $part1 = "(";
        $part2 = "(";

        foreach ($details as $detail => $value) {
            if (strcmp($value, "") == 0 || strcmp($detail, 'confirmpassword') == 0) {
                continue;
            }
            if (strcmp($detail, "password") == 0) {
                $value = md5($value);
            }
            $part1.=$detail . ",";
            $part2.="'" . $value . "'" . ",";
        }

        $part1.="date,time,";
        $length1 = strlen($part1);
        $part1[$length1 - 1] = ")";


        $part2.="CURRENT_DATE(),CURRENT_TIME(),";
        $length2 = strlen($part2);
        $part2[$length2 - 1] = ")";

        $query = "INSERT INTO " . $table . $part1 . " VALUES " . $part2;

        $inserter = mysqli_query($link, $query) or mysqli_error($link);
        if ($inserter) {

            return true;
        } else {

            return false;
        }
    }

    
       function insertIntoTransaction($table,$username,$package) {
        $link = $this->connectToDB();
        $query = "INSERT INTO ".$table."(username,amount,date,time) VALUES ('".$username."','".$package."',CURRENT_DATE(),CURRENT_TIME())";
        $state = mysqli_query($link, $query);
        if ($state){
            return true;
        }else{
            return false;
        }
        }

    function number_of_users($table) {
        $link = $this->connectToDB();
        $query = "SELECT * FROM " . $table;
        $count = mysqli_query($link, $query);
        return mysqli_num_rows($count);
    }


    

    function autoChangePassword($table, $username) {
        $link = $this->connectToDB();
        $random = rand(12, 99999999999);
        $hash = hash("sha256", $random);
        $password = substr($hash, 0, 6);
        $query = "UPDATE " . $table . " SET password='" . (md5($password)) . "' WHERE username='" . $username . "'";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return $password;
        } else {
            return false;
        }
    }

    function selectAllFromWhereUsername($table,$username){
        $link = $this->connectToDB();
        //include code to check for matched and confirmed
        $query ="SELECT * FROM ".$table." WHERE username ='".$username."'";
        $details = mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return $details;
        } else {
            return null;
        }
     
    }
   
        function changePassword($table, $username, $password) {
        $link = $this->connectToDB();
        $query = "UPDATE " . $table . " SET password = '" . $password . "' WHERE username ='" . $username . "'";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return "success";
        } else {
            return null;
        }
    }
    
        function updateProfile($username, $values, $table) {
        $link = $this->connectToDB();
        foreach ($values as $name => $value) {
            if ($value == "") {
                $values[$name] = null;
            }
        }
        extract($values);
        $query = "UPDATE " . $table . " SET fullname = '" . $fullname . "', email = '" . $email . "', phonenumber = '" . $phonenumber . "' WHERE username = '" . $username . "'";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function getAllunmatched($amount, $table){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE amount = '".$amount."' AND topay IS NULL";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
        function getAllPaidAndRefUnfilled($amount, $table){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE amount = '".$amount."' AND topay IS NOT NULL AND paid IS NOT NULL AND filled IS NULL ORDER BY id";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
        function getfilledbyid($id,$table){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE id = ".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
    function assignref1($table,$ref,$idref,$id){
        $link = $this->connectToDB();
        $query = "UPDATE ".$table." SET ref1 = '".$ref."', idref1 =".$idref." WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function assignref2($table,$ref,$idref,$id){
        $link = $this->connectToDB();
        $query = "UPDATE ".$table." SET ref2 = '".$ref."', idref2 = ".$idref." WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
        function lock($table,$id){
        $link = $this->connectToDB();
        $query = "UPDATE ".$table." SET filled ='yes' WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
     function updateMatch($table,$ref,$id){
        $link = $this->connectToDB();
        $query = "UPDATE ".$table." SET topay = '".$ref."', time = CURRENT_TIME(), date = CURRENT_DATE() WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function getWhoToPay($table,$username){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE paid IS NULL AND topay IS NOT NULL AND username ='".$username."'";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
    function getpayer($table,$username){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE ((ref1 IS NOT NULL AND confirmref1 IS NULL)  OR (ref2 IS NOT NULL AND confirmref2 IS NULL)) AND username ='".$username."'";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }  
    }
    
    function confirmref1($table, $id){
        $link = $this->connectToDB();
        $query = "UPDATE  ".$table." SET confirmref1 = 'yes', ref1 = 'confirm#$' WHERE idref1 =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
        $query = "UPDATE  ".$table." SET paid = 'yes' WHERE id =".$id;
        mysqli_query($link, $query);
            return true;
        } else {
            return false;
        } 
    }
    
    function confirmref2($table, $id){
        $link = $this->connectToDB();
        $query = "UPDATE  ".$table." SET confirmref2 = 'yes', ref2 = 'confirm#$' WHERE idref2 =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            $query = "UPDATE  ".$table." SET paid = 'yes' WHERE id =".$id;
            mysqli_query($link, $query);
            return true;
        } else {
            return false;
        } 
    }
    
    function deleteph($table,$id){
        $link = $this->connectToDB();
        $query = "DELETE FROM  ".$table."  WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function selectpaid($table, $id){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table." WHERE id = ".$id." AND paid IS NOT NULL";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
    function getRef($table,$id){
        $link = $this->connectToDB();
        $query = "SELECT * FROM  ".$table."  WHERE (idref1 = ".$id." OR idref2 =".$id.")";
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
        function resetRef($table,$id,$ref,$refuser){
        $link = $this->connectToDB();
        $query = "UPDATE ".$table."  SET  ".$ref." = NULL, ".$refuser." = NULL, filled = NULL WHERE id =".$id;
        mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
    }
    
    function insertIntoTransactionAdmin($table,$username,$package) {
        $link = $this->connectToDB();
        $query = "INSERT INTO ".$table."(username,amount,date,time,topay,paid,pop) VALUES ('".$username."','".$package."',CURRENT_DATE(),CURRENT_TIME(),'confirm#$','yes','yes')";
        $state = mysqli_query($link, $query);
        if ($state){
            return true;
        }else{
            return false;
        }
        }
        
        function adminUpdateTransaction($id,$names,$table){
            $link = $this->connectToDB();
            foreach($names as $name => $value){
                if(empty(trim($value))){
                    $value = 'NULL';
                }else{
                    $value = "'$value'";
                }
                $query = "UPDATE ".$table." SET ".$name." = ".$value." WHERE id =".$id;
                
                $state = mysqli_query($link, $query);
            }
        }
        
        function blacklist($table, $id){
        $link = $this->connectToDB();
        $query = "INSERT blacklist SELECT * FROM ".$table." WHERE id= ".$id;
     
        $move = mysqli_query($link, $query);
        if ($move) {
            return true;
        }else{
            return false;
        }
        
        }
        
        function recyclebin($table, $id){
        $link = $this->connectToDB();
        $query = "INSERT recyclebin SELECT * FROM ".$table." WHERE id= ".$id;
     
        $move = mysqli_query($link, $query);
        if ($move) {
            return true;
        }else{
            return false;
        }
        
        }
        
        function selectAll($table){
        $link = $this->connectToDB();
        $query = "SELECT * FROM ".$table;
         mysqli_query($link, $query);
        $count = mysqli_affected_rows($link);
        if ($count > 0) {
            return mysqli_query($link, $query);;
        } else {
            return null;
        }
        
        }
    
}

class FormHandler extends DatabaseHandler {

    /**
     * Verifies that the data collected from the form are error free
     * @param type $names
     * @return array 
     */
    function formValidation($names, $table) {

        $errors = array();

        foreach ($names as $name => $value) {
            if (substr($value, 0, 3) == "ref") {
                continue;
            }

            if (empty($value)) {
                $errors[$name] = $name . " is required";
            }


            if (!empty($value) && "username" == $name) {
                if (!$this->checkusername($value, $table)) {
                    $errors['username Exists'] = "Username already exists";
                }
            }
        }
        if (isset($names['password']) && strcmp($names['password'], $names['confirmpassword']) != 0) {
            $errors['passwordmismatch'] = "passwords dont match";
        }





        return $errors;
    }

}

?>
