<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->select('*', ['count'=> 'exact', 'head'=> true])->execute();

print_r($response);
//understand why there is no result printed
