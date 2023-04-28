<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('countries')->select(' name,
                                    cities!inner (
                                    name
                                    )')
									->eq('cities.name', 'Bali')
									->execute();
print_r($response);
