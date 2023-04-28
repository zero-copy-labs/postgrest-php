<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('users')->insert([['first_name'=> 'with', 'last_name' => 'bulk'], ['first_name'=> 'with', 'last_name' => 'bulk 2']])->select()->execute();

print_r($response);
