<?php
class spreadsheet {
	private $error;
	private $password;
	private $spreadsheetid;
	private $spreadsheettitle;
	private $tokens;
	private $username;
	private $worksheetid;
	private $worksheettitle;

	public function __construct() {
	}

	public function authenticate($username, $password, $service="wise") {
		if(empty($this->username) && empty($this->password)) {
			$this->username = $username;
			$this->password = $password;
		}
		
		$url = "https://www.google.com/accounts/ClientLogin";
		$fields = array(
			"accountType" => "HOSTED_OR_GOOGLE",
			"Email" => $username,
			"Passwd" => $password,
			"service" => $service,
			"source" => "php-form-builder-class"
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
				$this->tokens[$service] = $matches[1];
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

	public function create($spreadsheet, $columnids="") {
		if(!empty($this->tokens["writely"]) || (!empty($this->username) && !empty($this->password))) {
			if(empty($this->tokens["writely"]))
				$this->authenticate($this->username, $this->password, "writely");

			$url = "https://docs.google.com/feeds/default/private/full";
			$headers = array(
				"Authorization: GoogleLogin auth=" . $this->tokens["writely"],
				"GData-Version: 3.0",
			);

			if(!empty($columnids) && is_array($columnids)) {
				$columnidSize = sizeof($columnids);
				for($c = 0; $c < $columnidSize; ++$c)
					$columnids[$c] = str_replace('"', '""', $columnids[$c]);

				$fields = "--END_OF_PART\nContent-Type: application/atom+xml\n\n" . '<entry xmlns="http://www.w3.org/2005/Atom"><category scheme="http://schemas.google.com/g/2005#kind" term="http://schemas.google.com/docs/2007#spreadsheet"/><title><![CDATA[' . $spreadsheet . ']]></title></entry>' . "\n\n--END_OF_PART";
				$fields .= "\nContent-Type: text/csv\n\n" . '"' . implode('","', $columnids) . '"' . "\n\n--END_OF_PART--";
				$headers[] = "Content-Type: multipart/related; boundary=END_OF_PART";
				$headers[] = "Content-Length: " . strlen($fields);
			}
			else {
				$fields = '<entry xmlns="http://www.w3.org/2005/Atom"><category scheme="http://schemas.google.com/g/2005#kind" term="http://schemas.google.com/docs/2007#spreadsheet"/><title><![CDATA[' . $spreadsheet . ']]></title></entry>';
				$headers[] = "Content-Type: application/atom+xml";
			}

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

			if($status == 201) {
				$spreadsheetXml = simplexml_load_string($response);
				if($spreadsheetXml->id) {
					$this->spreadsheetid = substr(basename(trim($spreadsheetXml->id)), 14);
					$url = "https://spreadsheets.google.com/feeds/worksheets/" . $this->spreadsheetid . "/private/full";
					$headers = array(
						"Authorization: GoogleLogin auth=" . $this->tokens["wise"],
						"GData-Version: 3.0"
					);
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					$response = curl_exec($curl);
					$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

					if($status == 200) {
						$worksheetXml = simplexml_load_string($response);
						if($worksheetXml->entry)
							$this->worksheetid = basename(trim($worksheetXml->entry[0]->id));
					}
				}	
			}		
		}
	}

	public function select($spreadsheet, $worksheet="") {
		$this->spreadsheettitle = $spreadsheet;
		$this->worksheettitle = $worksheet;

		$url = "https://spreadsheets.google.com/feeds/spreadsheets/private/full?title=" . urlencode($spreadsheet);
		$headers = array(
			"Authorization: GoogleLogin auth=" . $this->tokens["wise"],
			"GData-Version: 3.0"
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if($status == 200) {
			$spreadsheetXml = simplexml_load_string($response);
			if($spreadsheetXml->entry) {
				$this->spreadsheetid = basename(trim($spreadsheetXml->entry[0]->id));
				$url = "https://spreadsheets.google.com/feeds/worksheets/" . $this->spreadsheetid . "/private/full";
				if(!empty($worksheet))
					$url .= "?title=" . urlencode($worksheet);
				curl_setopt($curl, CURLOPT_URL, $url);
				$response = curl_exec($curl);
				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				if($status == 200) {
					$worksheetXml = simplexml_load_string($response);
					if($worksheetXml->entry)
						$this->worksheetid = basename(trim($worksheetXml->entry[0]->id));
				}		
			}
		}
		curl_close($curl);
	}

	public function populate($data) {
		if(!empty($this->tokens["wise"])) {
			if(empty($this->spreadsheetid)) {
				$keys = array_keys($data);
				$this->create($this->spreadsheettitle, $keys);
				$keySize = sizeof($keys);
				$columnids = array();
				for($d = 0; $d < $keySize; ++$d)
					$columnids[] = $this->formatColumnID($keys[$d]);
			}	
			
			if(!empty($this->spreadsheetid) && !empty($this->worksheetid)) {
				$url = "https://spreadsheets.google.com/feeds/list/" . $this->spreadsheetid . "/" . $this->worksheetid . "/private/full";
				$headers = array(
					"Content-Type: application/atom+xml",
					"Authorization: GoogleLogin auth=" . $this->tokens["wise"],
					"GData-Version: 3.0"
				);

				if(empty($columnids))
					$columnids = $this->getColumnIDs();

				if($columnids) {
					$fields = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:gsx="http://schemas.google.com/spreadsheets/2006/extended">';
					foreach($data as $key => $value) {
						$key = $this->formatColumnID($key);
						if(in_array($key, $columnids))
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
	}

	private function getColumnIDs() {
		$url = "https://spreadsheets.google.com/feeds/cells/" . $this->spreadsheetid . "/" . $this->worksheetid . "/private/full?max-row=1";
		$headers = array(
			"Authorization: GoogleLogin auth=" . $this->tokens["wise"],
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
				$columnids = array();
				$columnSize = sizeof($xml->entry);
				for($c = 0; $c < $columnSize; ++$c)
					$columnids[] = $this->formatColumnID($xml->entry[$c]->content);
				return $columnids;		
			}		
			else
				$this->error = $error;
		}
		else
			$this->error = $error;

		return "";
	}

	private function formatColumnID($val) {
		return preg_replace("/[^a-zA-Z0-9.-]/", "", strtolower($val));
	}
}
?>
