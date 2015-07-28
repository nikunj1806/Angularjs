<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);
print_r($request);
//@$email = $request->email;
//@$pass = $request->password;
//@$do = $request->do;
//echo $email;
//echo $pass;
//echo $do;

