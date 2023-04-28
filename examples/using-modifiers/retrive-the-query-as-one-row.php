<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;


$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')
									->select('name')
									->limit(1)
									->single()
									->execute();
print_r($response);
