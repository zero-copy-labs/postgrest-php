<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->rpc('add_one_each', ['arr'=> [1, 2, 3]])->execute();
$output = $response;
print_r($output);
