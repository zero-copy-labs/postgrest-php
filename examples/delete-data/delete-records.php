<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

//Creating a new instance of client 
$client = new PostgrestClient($reference_id, $api_key);

//inserting a test row 
$client->from('users')->insert(['first_name'=> 'test', 'last_name' => 'LastNameTest'], [])->execute();

//Delte method and print result 
$response = $client->from('users')->delete()->eq('first_name', 'test')->execute();
print_r($response);
