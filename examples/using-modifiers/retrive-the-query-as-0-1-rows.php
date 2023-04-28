<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')
									->select()
									->eq('name', 'Singapore')
									->maybeSingle()
									->execute();
print_r($response);
