<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->select('name')
									->range(0, 1)
									->execute();
print_r($response);
