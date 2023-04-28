<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('very_big_table')->select()->abortSignal('')
									->execute();
print_r($response);
