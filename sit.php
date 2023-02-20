<?php
// configure the Google Client
require_once('vendor/autoload.php');
$client = new \Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
// credentials.json is the key file we downloaded while setting up our Google Sheets API
$path = 'spmi.json';
$client->setAuthConfig($path);

// configure the Sheets Service
$service = new \Google_Service_Sheets($client);
$spreadsheetId = '1gACKJKmxh80_kZBscotSDmjwlbWVFOkJxXj6jsjjHwo';
$spreadsheet = $service->spreadsheets->get($spreadsheetId);
//var_dump($spreadsheet);
$range = 'Data'; // here we use the name of the Sheet to get all the rows
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

//update data
$updateRow = [
    '4',
    '4',
    '4',
    "4",
    '4',
    '4',
    '4',
    '4',
    '4',
    "4",
    '4',
    '4',
    '4',
    '4',
    '4',
    "4",
    '4',
    '4',
    '4',
    '4',
    '4',
    "4",
    '4',
    '4',
    '4',
    '4',
];
$rows = [$updateRow];
$valueRange = new \Google_Service_Sheets_ValueRange();
$valueRange->setValues($rows);
$range = 'Data!A4'; // where the replacement will start, here, first column and second line
$options = ['valueInputOption' => 'USER_ENTERED'];
$service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $options);
print_r($values);