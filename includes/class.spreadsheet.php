<?php
class spreadsheet {
	private $token;
	private $spreadsheet;
	private $worksheet;
	private $spreadsheetid;
	private $worksheetid;
	private $error;

	public function __construct() {
	}

	public function authenticate($username, $password) {
		$url = "https://www.google.com/accounts/ClientLogin";
		$fields = array(
			"accountType" => "HOSTED_OR_GOOGLE",
			"Email" => $username,
			"Passwd" => $password,
			"service" => "wise",
			"source" => "pfbc"
		);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		$response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);


		$error = "Google ClientLogin authentication failed.  Verify that the supplied Google account login credentials are correct.";
		if($status == 200) {
			if(stripos($response, "auth=") !== false) {
				preg_match("/auth=([a-z0-9_\-]+)/i", $response, $matches);
				$this->token = $matches[1];
			}
			else
				$this->error = $error;
		}
		else
			$this->error = $error;
	}

	public function getError() {
		return "Error: " . $this->error;
	}

	public function setSpreadsheet($title) {
		$this->spreadsheet = $title;
	}

	public function setWorksheet($title) {
		$this->worksheet = $title;
	}

	public function add($data) {
		if(!empty($this->token)) {
			$url = $this->getPostUrl();
			if(!empty($url)) {
				$headers = array(
					"Content-Type: application/atom+xml",
					"Authorization: GoogleLogin auth=" . $this->token,
					"GData-Version: 3.0"
				);

				$columnIDs = $this->getColumnIDs();
				if($columnIDs) {
					$fields = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:gsx="http://schemas.google.com/spreadsheets/2006/extended">';
					foreach($data as $key => $value) {
						$key = $this->formatColumnID($key);
						if(in_array($key, $columnIDs))
							$fields .= "<gsx:$key><![CDATA[$value]]></gsx:$key>";
					}
					$fields .= '</entry>';

					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
					$response = curl_exec($curl);
					$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					curl_close($curl);
					if($status == 201)
						return true;
					else
						$this->error = "Error sending xml data to Google Docs spreadsheet/worksheet. Google Spreadsheets API response: " . $response;
				}
			}
		}
		return false;
	}

	private function getColumnIDs() {
		$url = "https://spreadsheets.google.com/feeds/cells/" . $this->spreadsheetid . "/" . $this->worksheetid . "/private/full?max-row=1";
		$headers = array(
			"Authorization: GoogleLogin auth=" . $this->token,
			"GData-Version: 3.0"
		);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		$error = "No column headers available.  The cells in the initial row of the specified Google Docs spreadsheet/worksheet must contain column headers.";
		if($status == 200) {
			$xml = simplexml_load_string($response);
			if($xml->entry) {
				$columnIDs = array();
				$columnSize = sizeof($xml->entry);
				for($c = 0; $c < $columnSize; ++$c)
					$columnIDs[] = $this->formatColumnID($xml->entry[$c]->content);
				return $columnIDs;		
			}		
			else
				$this->error = $error;
		}
		else
			$this->error = $error;

		return "";
	}

	private function getPostUrl() {
		$url = "https://spreadsheets.google.com/feeds/spreadsheets/private/full?title=" . urlencode($this->spreadsheet);
		$headers = array(
			"Authorization: GoogleLogin auth=" . $this->token,
			"GData-Version: 3.0"
		);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		$spreadsheet_error = "Invalid spreadsheet title. The spreadsheet title specified could not be located in your Google Docs account.";
		if(!empty($this->worksheet))
			$worksheet_error = "Invalid worksheet title. The worksheet title specified could not be located in the specified Google Docs spreadsheet.";
		else
			$worksheet_error = "No worksheets available. The Google Docs spreadsheet specified does not contain any worksheets.";

		if($status == 200) {
			$spreadsheetXml = simplexml_load_string($response);
			if($spreadsheetXml->entry) {
				$this->spreadsheetid = basename(trim($spreadsheetXml->entry[0]->id));
				$url = "https://spreadsheets.google.com/feeds/worksheets/" . $this->spreadsheetid . "/private/full";
				if(!empty($this->worksheet))
					$url .= "?title=" . $this->worksheet;

				curl_setopt($curl, CURLOPT_URL, $url);
				$response = curl_exec($curl);
				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				if($status == 200) {
					$worksheetXml = simplexml_load_string($response);
					if($worksheetXml->entry)
						$this->worksheetid = basename(trim($worksheetXml->entry[0]->id));
					else
						$this->error = $worksheet_error;
				}
				else
					$this->error = $worksheet_error;
			}
			else
				$this->error = $spreadsheet_error;
		}
		else
			$this->error = $spreadsheet_error;

		curl_close($curl);
		if(!empty($this->spreadsheetid) && !empty($this->worksheetid))
			return "https://spreadsheets.google.com/feeds/list/" . $this->spreadsheetid . "/" . $this->worksheetid . "/private/full";

		return "";
	}

	private function formatColumnID($val) {
		return preg_replace("/[^a-zA-Z0-9.-]/", "", strtolower($val));
	}
}
?>
