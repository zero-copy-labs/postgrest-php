<?php

require __DIR__.'/../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('testTable')->select()->execute();
print_r($response);
