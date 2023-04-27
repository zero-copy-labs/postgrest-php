<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->select('*', ['count'=> 'exact', 'head'=> true])->execute();
$output = $response;
print_r($output);
//understand why there is no result printed 