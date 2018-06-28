<?php

function select ($name, $data) {
   echo "<div class='form-group'>";
   echo "<label for='sel'></label>";
   echo ("<select name = '$name' class='form-control' id='sel'><br/>");
   foreach ($data as $elm) {
       echo ("<option value='$elm'>$elm</option>\n");
       
   }
   echo ("</select>");
   echo "</div>";
}

function radio ($name, $data) {
   foreach ($data as $elm)  {
       echo "<div class='radio-inline'>";
     echo ("<label><input type='radio' name = '$name' value='$elm' /> $elm</label>");
       echo "</div>";
   }
}

function checkbox($name, $data) {
    foreach ($data as $elm) {
        echo "<div class='checkbox'>";
        echo("<br/><input type='checkbox' name='$name' value='$elm' id='$elm'/><label for='$elm'>$elm</label><br>");
        echo "</div>";
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