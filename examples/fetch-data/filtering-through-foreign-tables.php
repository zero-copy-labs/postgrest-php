<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('cities')
						->select('name, countries(*)')
						->eq('countries.name', 'Estonia')->execute();

print_r($response);
