<?php
require_once('ripcord.php');
$url = 'https://spmiuinmaliki.my.id';
$models = ripcord::client("$url/xmlrpc/2/object");
$common = ripcord::client("$url/xmlrpc/2/common");
$db = 'nabil';
$username = 'bilrahmat99@gmail.com';
$password = 'nabil';
$uid = $common->authenticate($db, $username, $password, array());

// connect db
$servername = "localhost";
$usernameDb = "root";
$passwordDB = "nabil";
$dbname = "bridge_odoo";

// Create connection
$conn = new mysqli($servername, $usernameDb, $passwordDB, $dbname);
// Check connection
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

// list jawban done {1}
$surveiItemList = $models->execute_kw($db, $uid, $password
	, 'survey.user_input'
	, 'search_read', 
		array(
			array(
				array('survey_id','=',5),
				array('state','=','done')
			)
		)
	); 
//echo print_r($surveiItemList);
$arrQts = [];
$total = 2;
$dataSheet = [];
//echo print_r($surveiItemList[0]['id']);
		foreach ($surveiItemList as $surveiItemListKey => $surveiItemListValue) 
		{
			// list jawban detail {2}
			$surveiItemDetail = $models->execute_kw($db, $uid, $password
				, 'survey.user_input'
				, 'search_read', 
					array(
						array(
							array('id','=',$surveiItemListValue['id']) // from {1} => object array ['id'] => under looping;
						)
					)
				);
				//echo print_r($surveiItemDetail[0]);
				foreach ($surveiItemDetail[0]['predefined_question_ids'] as $surveiItemDetailValueUiLiKey => $surveiItemDetailValueUiLiValue) 
				{
					$arrQts[$surveiItemListValue['id']][$surveiItemDetailValueUiLiKey] = $surveiItemDetailValueUiLiValue;
				}
		}
		//echo print_r($arrQts);
		$noK = -1;
		$jml = $conn->query("SELECT COUNT(*) AS jml FROM survey_answers")->fetch_array();
		foreach ($arrQts as $arrQtsKey => $arrQtsValue) 
		{
			$noK++;
			$dataSheet[$noK]['items'] = null;
			// jawaban detail per item {3}
			$surveiItemPerQuetsion = $models->execute_kw($db, $uid, $password
			, 'survey.user_input.line'
			, 'search_read', 
				array(
					array(
						array('survey_id','=',5),
						array('user_input_id','=',$arrQtsKey),
						array('question_id','=',$arrQtsValue) // from {2} => object array ['predefined_question_ids'] => under looping
						)
					)
				);
			//$dataSheet[$noK]['item'] = [];
			$nonya = -1;
			foreach ($surveiItemPerQuetsion as $surveiItemPerQuetsionKey => $surveiItemPerQuetsionValue) 
			{
				$surveyId = 5;
				$answerValue = intval($surveiItemPerQuetsionValue['display_name']);
				$answerType = $surveiItemPerQuetsionValue['answer_type'];
				$participantId = $arrQtsKey;
				$qtsId = $surveiItemPerQuetsionValue['id'];
				$createdAt = $surveiItemPerQuetsionValue['write_date'];
				//check dulu

				$cek = "SELECT * FROM survey_answers WHERE 
						survey_id='$surveyId' 
						AND 
						quetsion_id='$qtsId'
						AND 
						participant_id='$participantId'";
				$result = $conn->query($cek);
				if($result->num_rows <= 0)
				{
					if($answerType == 'suggestion')
					{
						$nonya++;
						$dataSheet[$noK]['items'][$nonya] = $answerValue;
						$sql = "INSERT INTO survey_answers (survey_id, quetsion_id, type, value, participant_id, created_at)
								VALUES ('$surveyId'
										,'$qtsId'
										,'$answerType'
										,'$answerValue'
										,'$participantId'
										,'$createdAt')";
						if ($conn->query($sql) === TRUE) 
						{
							$total++;
						}
					} 
				}
			}
		}


if($total > 0)
{
	updateSheet($dataSheet,$jml['jml']);
}
$conn->close();
echo print_r($dataSheet);

function updateSheet($data,$jml)
{
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
	//$spreadsheet = $service->spreadsheets->get($spreadsheetId);
	//var_dump($spreadsheet);
	$range = 'data'; // here we use the name of the Sheet to get all the rows
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
	$values = $response->getValues();
	//update data
	$cell = $jml+1;
	foreach ($data as $dataKey => $dataValue) 
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