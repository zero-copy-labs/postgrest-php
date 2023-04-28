<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->rpc('echo', ['say'=> '👋'])->execute();

print_r($response);
