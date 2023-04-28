<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->upsert(['id'=> 3, 'name'=> 'Algeria'])
									->select()
									->execute();
print_r($response);
