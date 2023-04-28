<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->update(['name'=> 'Australia'])->eq('id', 1)->execute();

print_r($response);
