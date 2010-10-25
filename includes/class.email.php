<?php
require_once(dirname(__FILE__) . "/phpmailer/class.phpmailer.php");

class email extends pfbc {
	protected $bcc;
	protected $cc;
	protected $css;
	protected $cssFile;
	protected $from;
	protected $password;
	protected $postHTML;
	protected $preHTML;
	protected $replyto;
	protected $subject;
	protected $to;
	protected $username;

	private $error;

	public $additionalInfo;
	public $textOnly;

	private function applyPHPMailerSetting($str, &$mail, $action, $default="") {
		if(!empty($str)) {
			$emails = explode(",", $str);
			$emailSize = sizeof($emails);
			$exists = array();
			for($e = 0; $e < $emailSize; ++$e) {
				$email = trim($emails[$e]);
				$emailname = "";
				if(preg_match("/^(.+)\s*\x3C(.*)\x3E/", $email, $matches)) {
					$emailname = $matches[1];
					$email = $matches[2];
				}	
				if(!in_array($email, $exists)) {
					$mail->$action($email, $emailname);
					$exists[] = $email;
				}
			}
		}
		elseif(!empty($default))
			$mail->$action($default);
	}

	private function convertToPlainText($str) {
		$str = str_replace(array("\n", "\t"), "", $str);
		$str = str_replace(array("&nbsp;", '</label><div class="pfbc-data">', '</div><div class="pfbc-element"><label class="pfbc-label">', '<div class="pfbc-additional">'), array(" ", "\n", "\n\n", "\n\n"), $str);
		if(!empty($this->preHTML))
			$str = $this->preHTML . "\n\n" . $str;
		if(!empty($this->postHTML))
			$str = $str . "\n\n" . $this->postHTML;
		return strip_tags($str);
	}

	public function getError() {
		return $this->error;
	}

	public function send($str) {
		$mail = new PHPMailer(); 
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = "ssl://smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = $this->username;
		$mail->Password = $this->password;
		$mail->WordWrap = 50;

		if(empty($this->to))
			$this->to = $this->username;

		if(!empty($this->from)) {
			if(preg_match("/^(.+)\s*\x3C(.*)\x3E/", $this->from, $matches)) {
				$fromname = $matches[1];
				$this->from = $matches[2];
			}
			else
				$fromname = $this->from;
		}
		else {
			$this->from = $this->username;
			$fromname = $this->username;
		}	
		$mail->From = $this->from;
		$mail->FromName = $fromname;

		$this->applyPHPMailerSetting($this->to, $mail, "AddAddress");
		$this->applyPHPMailerSetting($this->replyto, $mail, "AddReplyTo", $this->from);
		$this->applyPHPMailerSetting($this->cc, $mail, "AddCC");
		$this->applyPHPMailerSetting($this->bcc, $mail, "AddBCC");

		if(!empty($subject))
			$mail->Subject = $subject;
		
		if(!empty($this->textOnly))
			$mail->Body = $str;
		else {
			$defaultCSS = <<<STR
<style type="text/css">
	.pfbc-email {
		margin: 0.75em 0;
		padding: .25em 0.75em;
		width: 400px;
		font-family: "American Typewriter";
		font-size: 14px;
		background-color: #f5f4f4;
		border: 1px solid #ccc;
		-moz-border-radius: 0.5em; 
		-webkit-border-radius: 0.5em;
	}
	.pfbc-element {
		padding: 0.5em 0;
	}
	.pfbc-label {
		display: block;
		padding-bottom: 0.25em;
	}
	.pfbc-data {
		padding: 0.5em;
		width: 384px;
		font-family: "American Typewriter";
		font-size: 14px;
		background-color: #fff;
		border: 1px solid #ccc;
	}

STR;

			if(!empty($this->additionalInfo)) {
				$defaultCSS .= <<<STR
	.pfbc-additional {
		padding-top: 0.75em;
		font-size: 1.25em;
	}

STR;
	}

			$defaultCSS .= "</style>";

			if(!empty($this->cssFile)) {
				$this->css = file_get_contents($this->cssFile);
				if(!$this->css)
					$this->css = $defaultCSS;
			}

			if(empty($this->css))
				$this->css = $defaultCSS;

			if(stripos($this->css, "<style") !== 0)
				$this->css = '<style type="text/css">' . $this->css . '</style>';

			$mail->Body = $this->preHTML . $this->css . $str . $this->postHTML;
			$mail->AltBody = $this->convertToPlainText($str);
		}

		$result = $mail->Send();
		if(!$result)
			$this->error = $mail->ErrorInfo;

		return $result;	
	}
}
?>
