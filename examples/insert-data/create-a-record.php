<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('users')->insert(['first_name'=> 'no', 'last_name' => 'bulk'], [])->execute();

print_r($response);
