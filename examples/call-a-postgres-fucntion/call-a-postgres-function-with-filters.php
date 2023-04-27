<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->rpc('list_stored_countries')->eq('id', 1)->single()->execute();
$output = $response;
print_r($output);
