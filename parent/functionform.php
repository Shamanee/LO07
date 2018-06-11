<?php

function select ($name, $data) {
   echo ("<select name = '$name'><br/>");
   foreach ($data as $elm) {
       echo ("<option value='$elm'>$elm</option>\n");
       
   }
   echo ("</select>");
}

function radio ($name, $data) {
   foreach ($data as $elm)  {
     echo ("<input type='radio' name = '$name' value='$elm' /> $elm      ");      
   }
}

function checkbox($name, $data) {
    foreach ($data as $elm) {

        echo("<br/><input type='checkbox' name='$name' value='$elm' id='$elm'/><label for='$elm'>$elm</label><br>");
    }
}


function psw ($name){
    echo "<input type='password' name='$name' required />";
}

function txt ($name){
   echo "<input type='text' name='$name'  required/>";
}

function submit(){
    echo ' <input type="submit" value="envoyer"/>';
    echo ' <input type="reset" value="annuler"/>';
}