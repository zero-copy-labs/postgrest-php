<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->upsert([['id'=>1, 'name'=> 'Albania'], ['id'=>2, 'name'=> 'Armenia']], $opts)->select()->execute();
$output = $response;
print_r($output);
