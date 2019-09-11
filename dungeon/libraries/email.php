<?php if (!defined('DUNGEON_CMS')) exit;
/**************************************************************************
Copyright © 2019 Evil

This file is part of Dungeon.

Dungeon is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Dungeon is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Dungeon. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class Email extends Library
{
	private $_from;
	private $_to = [];
	private $_subject;
	private $_view;
	private $_data;

	public function from($from)
	{
		$this->_from = $from;

		return $this;
	}
	
	public function to($to)
	{
		$this->_to[] = strtolower($to);

		return $this;
	}
	
	public function subject($subject)
	{
		$this->_subject = $subject;
		
		return $this;
	}
	
	public function message($view, $data = [])
	{
		$this->_view = $view;
		$this->_data = $data;
		
		return $this;
	}
	
	public function send()
	{
		if (!$this->_to || !$this->_subject || !$this->_view)
		{
			return FALSE;
		}
		
		require 'lib/phpmailer/class.phpmailer.php';
		
		$mail = new PHPMailer;
		
		if ($this->config->dungeon_email_smtp)
		{
			require 'lib/phpmailer/class.smtp.php';
			
			$mail->isSMTP();
			$mail->Host = $this->config->dungeon_email_smtp;
			
			if ($mail->SMTPAuth = $this->config->dungeon_email_username && $this->config->dungeon_email_password)
			{
				$mail->Username = $this->config->dungeon_email_username;
				$mail->Password = $this->config->dungeon_email_password;
			}
			
			if ($this->config->dungeon_email_secure)
			{
				$mail->SMTPSecure = $this->config->dungeon_email_secure;
			}
			
			if ($this->config->dungeon_email_port)
			{
				$mail->Port = $this->config->dungeon_email_port;
			}
		}
		
		if ($this->_from)
		{
			$mail->setFrom($this->_from);
		}
		else 
		{
			$mail->setFrom($this->config->dungeon_contact, $this->config->dungeon_name);
		}
		
		$mail->CharSet = 'UTF-8';
		$mail->Subject = $this->_subject;
		$mail->isHTML(TRUE);
		
		foreach (array_unique($this->_to) as $to)
		{
			$mail->addAddress($to);
		}

		$this->url->external(TRUE);

		$this->output->parse_data($this->_data);
		
		$mail->Body    = $this->view('emails/'.$this->_view, $this->_data);
		$mail->AltBody = $this->view('emails/'.$this->_view.'.txt', $this->_data);

		$result = $mail->send();

		$this->url->external(FALSE);

		$this->reset();

		return $result;
	}
}

/*
Dungeon Alpha 0.1.7.7
./dungeon/libraries/email.php
*/