<?php

class HTMLEmail {

	public $phpmailer;
	
	private $fromName;
	private $fromEmail;

	private $templateDir;
	private $templateTags;

	public function __construct($fromName, $fromEmail, $templateDir = './templates/', $templateTags = ['{{', '}}']) {
		$this->phpmailer = new PHPMailer();
		$this->fromName = $fromName;
		$this->fromEmail = $fromEmail;
		$this->templateDir = $templateDir;
		$this->templateTags = $templateTags;
	}

	public function send($toName, $toEmail, $subject, $data, $template = 'default.html') {

		$template = new DataTemplate($template, $this->templateDir, $this->templateTags);

		$this->phpmailer->SetFrom($this->fromEmail, $this->fromName);
		$this->phpmailer->AddAddress($toEmail, $toName);
		$this->phpmailer->Subject = $subject;
		$this->phpmailer->MsgHTML($template->render($data));
		
		return $this->phpmailer->Send();
	}
}

?>
