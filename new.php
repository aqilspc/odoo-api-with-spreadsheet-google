<?php
require_once('ripcord.php');
$url = 'https://spmi.uin-malang.ac.id/';
$models = ripcord::client("$url/xmlrpc/2/object");
$common = ripcord::client("$url/xmlrpc/2/common");
$db = 'eSURVEY';
$username = '19650156@student.uin-malang.ac.id';
$password = 'konteng99';
$uid = $common->authenticate($db, $username, $password, array());


$servername = "localhost";
$usernameDb = "root";
$passwordDB = "";
$dbname = "bridge_odoo_new";

$conn = new mysqli($servername, $usernameDb, $passwordDB, $dbname);
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

$surveiItemList = $models->execute_kw($db, $uid, $password
	, 'survey.user_input'
	, 'search_read', 
		array(
			array(
				array('survey_id','=',66),
				array('state','=','done')
			)
		)
	); 

$arrQts = [];
$total = 0;
$dataSheet = [];

		foreach ($surveiItemList as $surveiItemListKey => $surveiItemListValue) 
		{

			$surveiItemDetail = $models->execute_kw($db, $uid, $password
				, 'survey.user_input'
				, 'search_read', 
					array(
						array(
							array('id','=',$surveiItemListValue['id']) // from {1} => object array ['id'] => under looping;
						)
					)
				);

				foreach ($surveiItemDetail[0]['predefined_question_ids'] as $surveiItemDetailValueUiLiKey => $surveiItemDetailValueUiLiValue) 
				{
					$arrQts[$surveiItemListValue['id']][$surveiItemDetailValueUiLiKey] = $surveiItemDetailValueUiLiValue;
				}
		}

		$noK = -1;
		$arrNotScrore = ['Nama','NIM','Jenis Kelamin','Program Studi','Kode Mata Kuliah','Mata Kuliah','Nama Dosen','Berikan'];
		foreach ($arrQts as $arrQtsKey => $arrQtsValue) 
		{
			$noK++;
			$dataSheet[$noK]['items'] = null;
			$surveiItemPerQuetsion = $models->execute_kw($db, $uid, $password
			, 'survey.user_input.line'
			, 'search_read', 
				array(
					array(
						array('survey_id','=',66),
						array('user_input_id','=',$arrQtsKey),
						array('question_id','=',$arrQtsValue) // from {2} => object array ['predefined_question_ids'] => under looping
						)
					)
				);
			//break;
			//echo json_encode($surveiItemPerQuetsion);
			$dataSheet[$noK]['item'] = [];
			$nonya = -1;
			foreach ($surveiItemPerQuetsion as $surveiItemPerQuetsionKey => $surveiItemPerQuetsionValue) 
			{
				$surveyId = 66;
				$answerValue = intval($surveiItemPerQuetsionValue['display_name']);
				$answerType = $surveiItemPerQuetsionValue['answer_type'];
				$participantId = $arrQtsKey;
				$qtsId = $surveiItemPerQuetsionValue['id'];
				$createdAt = $surveiItemPerQuetsionValue['write_date'];
				$cek = "SELECT * FROM survey_answers WHERE 
						survey_id='$surveyId' 
						AND 
						quetsion_id='$qtsId'
						AND 
						participant_id='$participantId'";
				$result = $conn->query($cek);
				if($result->num_rows <= 0)
				{
					$nonya++;
					if(isset($surveiItemPerQuetsionValue['question_id'][1]))
					{
						$typeQuetsion = $surveiItemPerQuetsionValue['question_id'][1];
						//$typeQuetsion = explode(' ', $typeQuetsion);
						if(isset($typeQuetsion))
						{
							if(in_array($typeQuetsion, $arrNotScrore))
							{
								$answerValue = $surveiItemPerQuetsionValue['value_char_box'];
								$answerValue = str_replace("'", ' ', $answerValue);
							}else{
								$answerValue = $surveiItemPerQuetsionValue['answer_score'];
							}
							// $qtss = $surveiItemPerQuetsionValue['question_id'][1];
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
				// if($total >= 10)
				// {
				// 	break;
				// }
		}

echo $total;


//$jml = $conn->query("SELECT COUNT(*) AS jml FROM survey_answers GROUP BY participant_id")->fetch_array();
// if($total > 0) //spreedsheet
// {
// 	updateSheet($dataSheet,$jml['jml']);
// }
// $conn->close();
// echo 'done';

// function updateSheet($data,$jml)
// {
// 	require_once('vendor/autoload.php');
// 	$client = new \Google_Client();
// 	$client->setApplicationName('Google Sheets API');
// 	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
// 	$client->setAccessType('offline');
// 	$path = 'spmi.json'; // credentials.json is the key file we downloaded while setting up our Google Sheets API
// 	$client->setAuthConfig($path);
// 	$service = new \Google_Service_Sheets($client);
// 	$spreadsheetId = '1NpvzLvdkBgJ_hfKa1QDj0NMbisyz3jYuYLbl8kcUlVw';
// 	$range = 'data'; // here we use the name of the Sheet to get all the rows
// 	$response = $service->spreadsheets_values->get($spreadsheetId, $range);
// 	$values = $response->getValues();
// 	$cell = $jml+2;
// 	foreach ($data as $dataKey => $dataValue) 
// 	{
// 		if(!is_null($dataValue['items']))
// 		{
// 			$cell++;
// 			$updateRow = $dataValue['items'];
// 			$rows = [$updateRow];
// 			$valueRange = new \Google_Service_Sheets_ValueRange();
// 			$valueRange->setValues($rows);
// 			$range = 'Data!A'.$cell.''; 
// 			$options = ['valueInputOption' => 'USER_ENTERED'];
// 			$service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, $options);
// 		}	
// 	}
// }
