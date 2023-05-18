<?php
$servername = "localhost";
$usernameDb = "root";
$passwordDB = "nabil";
$dbname = "bridge_odoo_new";

$conn = new mysqli($servername, $usernameDb, $passwordDB, $dbname);
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

$total = 0;
$totalQts = 24;
$limit = 60;
$jml = $conn->query("SELECT COUNT(*) AS jml FROM survey_answers WHERE spreadsheet = 1")->fetch_array();

//echo $jml['jml']*2;

$qry = "SELECT *  FROM survey_answers WHERE spreadsheet = 0 GROUP BY participant_id ORDER BY id LIMIT $limit";
$query 	= mysqli_query($conn, $qry);
$arr = [];
while ($row = mysqli_fetch_array($query)) 
{
	$arr[$total] = $row['participant_id'];
	$total++;
}
$dataSheet = [];
$jalan = 0;


foreach ($arr as $key => $value) 
{
	$qry = "SELECT *  FROM survey_answers WHERE participant_id = $value ORDER BY id";
	$query 	= mysqli_query($conn, $qry);
	$titit = 0;
	while ($row = mysqli_fetch_array($query)) 
	{
		$dataSheet[$key]['items'][$titit] = $row['value'];
		$titit++;

		$id = $row['id'];
		$sql = "UPDATE survey_answers SET spreadsheet= 1 WHERE id=$id";

		if ($conn->query($sql) === TRUE) {
			$jalan++;
		}
	}
}

$conn->close();

$jml = $jml['jml'] / 24;
if($total > 0) //spreedsheet
{
	if($jml < 3)
	{
		 $jml = 3;
	}
	updateSheet($dataSheet,$jml);
}
echo $jalan;
function updateSheet($data,$jml)
{
	require_once('vendor/autoload.php');
	$client = new \Google_Client();
	$client->setApplicationName('Google Sheets API');
	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
	$client->setAccessType('offline');
	$path = 'survei-kepuasan-mahasiswa-2023-dcc41a29a18f.json'; // credentials.json is the key file we downloaded while setting up our Google Sheets API
	$client->setAuthConfig($path);
	$service = new \Google_Service_Sheets($client);
	$spreadsheetId = '1jVLJNDEkgmVS8ibYJ73zdrCV3nB1weJJT7CvMJwe5sU';
	$range = 'data'; // here we use the name of the Sheet to get all the rows
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
	$values = $response->getValues();
	$cell = $jml+2;
	foreach ($data as $dataKey => $dataValue) 
	{
		if(!is_null($dataValue['items']))
		{
			$cell++;
			$updateRow = $dataValue['items'];
			$rows = [$updateRow];
			$valueRange = new \Google_Service_Sheets_ValueRange();
			$valueRange->setValues($rows);
			$range = 'Data!A'.$cell.''; 
			$options = ['valueInputOption' => 'USER_ENTERED'];
			$service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $options);
		}	
	}
}
