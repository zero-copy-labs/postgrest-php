<?php

require '../header.php';
use Supabase\Postgrest\PostgrestClient;

$client = new PostgrestClient($reference_id, $api_key);
$response = $client->from('users')->select('
                                        name,
                                        teams (
                                            name
                                        )')->execute();

print_r($response);
