<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(BASEPATH.'/libraries/PHPMailer/src/Exception.php');
require_once(BASEPATH.'/libraries/PHPMailer/src/PHPMailer.php');

Class Test extends Z_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function show_dup()
	{
		// GENERATE sql query
		$sql	= " SELECT 
						FROM_UNIXTIME(s.submission_ctime, \"%Y-%m-%d %H:%i:%s\"), s.submission_id, v.voucher_id, s.submission_is_duplicates, s.submission_ip, s.submission_name, s.submission_status_id, s.submission_session_id, s.submission_location,
						v.voucher_session_id
					FROM z_submission s
						LEFT JOIN z_voucher_1 v ON s.submission_voucher_id = v.voucher_id
					WHERE s.submission_voucher_id IN(
						SELECT s.submission_voucher_id
						FROM z_submission s
						WHERE s.submission_status_id = 1
						GROUP BY s.submission_voucher_id
						HAVING COUNT(*) > 1
					)
						AND s.submission_status_id = 1
					ORDER BY s.submission_voucher_id ASC";
		// EXECUTE sql query
		$Q		= $this->db->query($sql);
		$a_DupList	= $Q->result_array();
		
		$vid	= '';
		$ctrValid	= 0;
		$ctrDup		= 0;
		foreach($a_DupList as $a_Dup)
		{
			if($vid != $a_Dup['voucher_id'])
			{
				$vid	= $a_Dup['voucher_id'];
				//echo $a_Dup['submission_id'].' - '.$a_Dup['voucher_id'];
				//echo '<br />';
				$ctrValid++;
			}
			else
			{
				echo $a_Dup['submission_id'];
				echo ',';
				$ctrDup++;
			}
		}
		echo '<br />';
		echo 'Valid: '.$ctrValid;
		echo '<br />';
		echo 'Dup: '.$ctrDup;
	}
	
	function show_log()
	{
		$log		= file_get_contents(BASEPATH.'/log/voucher_failed.log');
		$logDetail	= file_get_contents(BASEPATH.'/log/voucher_failed_detail.log');
		
		echo '<b>Total:</b> '.$log;
		echo '<br /><br />';
		
		echo nl2br($logDetail);
	}
	
	function test()
	{
		$log	= file_get_contents(BASEPATH.'/log/voucher_failed.log');
		
		$log	= (int)$log;
		$log++;
		
		file_put_contents(BASEPATH.'/log/voucher_failed.log', $log);
	}
	function send_email()
	{
		$this->msg	= '';
		// CHECK if postback
		if(isset($_POST['txt_Email']))
		{
			/*$to			= $_POST['txt_Email'];
			$subject	= 'HAPPY BR DAY to you!!';
			$headers	= "From: Baskin Robbins " . strip_tags($this->config['mail_admin_email']) . "\r\n";
			$headers	.= "Reply-To: Baskin Robbins ". strip_tags($this->config['mail_admin_email']) . "\r\n";
			//$headers	.= "CC: susan@example.com\r\n";
			$headers	.= "MIME-Version: 1.0\r\n";
			$headers	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$this->voucherCode				= 'TEST_VOUCHER';
			$this->voucherValidationCode	= 'TEST_VALIDATION';
			
			$message = $this->p_load_view('email_template/submission');
			
			$this->emailStatus	= mail($to, $subject, $message, $headers);
			$this->msg	= ($this->emailStatus)?'Email Sent.':'Email Not Sent!';*/
			
			$to			= $_POST['txt_Email'];
			$subject	= 'HAPPY BR DAY to you!!';
			
			$this->voucherCode				= 'TEST_VOUCHER';
			$this->voucherValidationCode	= 'TEST_VALIDATION';
			
			$mail = new PHPMailer;
			
			$mail->setFrom(strip_tags($this->config['mail_admin_email']), 'Baskin Robbins');
			$mail->AddReplyTo(strip_tags($this->config['mail_admin_email']), 'Baskin Robbins');
			$mail->addAddress($_POST['txt_Email']);
			$mail->Subject = 'HAPPY BR DAY to you!!';
			$mail->IsHTML(TRUE);
			$message = $this->p_load_view('email_template/submission');
			$mail->msgHTML($message);
			
			$this->emailStatus	= $mail->send();
			
			$this->msg	= ($this->emailStatus)?'Email Sent.':'Email Not Sent!';
		}
		
		$this->p_load_view('test/send_email', TRUE);
	}
	
	function test_redeem()
	{
		if(isset($_POST['hdd_VoucherSessionID']))
		{
			$voucherAvailable	= TRUE;
		}
		else
		{
			$_POST['hdd_Age']	= 20;
			$_POST['hdd_Location']	= 'Kedah';
			$sessionID	= 'helven_test_'.uniqid().$_POST['hdd_Age'].strtolower($_POST['hdd_Location']).uniqid();
			// ----------------------------------------------------------------------- //
			// UPDATE voucher status
			// ----------------------------------------------------------------------- //
			$voucherCountry	= ($_POST['hdd_Location'] == 'Singapore')?'sg':'my';
			$sql	= "	UPDATE z_voucher_1 SET
							voucher_status_id = 19,
							voucher_session_id = '{$sessionID}'
						WHERE voucher_id = (
							SELECT voucher_id
							FROM `z_voucher`
							WHERE voucher_country = '".sec_db_clean($this->db->conn, $voucherCountry)."'
								AND voucher_status_id = 1
							LIMIT 0,1
						)";
			// BEGIN mysql transaction
			$this->db->trans_start();
			// EXECUTE sql query
			$Q	= $this->db->query($sql);
			// END mysql transaction
			$this->db->trans_complete();
			
			if($Q->affected_row() <= 0)
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	= addslashes('Our server is busy at the moment, please try again.<br />Sorry for inconvenience.');
				echo $this->formErrorMsg;
				$voucherAvailable	= FALSE;
			}
			else
			{
				$voucherAvailable	= TRUE;
			}
		}
		if($voucherAvailable)
		{
			echo 'Voucher available for redemption.<br /><br />';
			// ----------------------------------------------------------------------- //
			// GET voucher ID
			// ----------------------------------------------------------------------- //
			// GENERATE sql query
			$sql	= " SELECT *
						FROM `z_voucher`
						WHERE voucher_session_id = '{$sessionID}'";
			// EXECUTE sql query
			$Q		= $this->db->query($sql);
			$a_Voucher = $Q->result();
			
			print_a($a_Voucher);exit;
			
		}
		exit;
	}
	
	function index()
	{
		// ----------------------------------------------------------------------- //
		// INIT
		// ----------------------------------------------------------------------- //
		$a_Geo	= $this->_get_geo();
		$_SESSION['ss_Geo']	= $a_Geo;
		
		$this->geoCountryCode	= (in_array(strtolower($_SESSION['ss_Geo']['country_code']), array('my', 'sg')))?$_SESSION['ss_Geo']['country_code']:'MY';
		unset($_SESSION['ss_Submission']);
		
		$cond	= '';
		// CHECK if postback
		if(isset($_POST['hdd_Action']))
		{
			$this->formError	= FALSE;
			$this->formErrorMsg	= '';

			if(!isset($_POST['hdd_Question']) || $_POST['hdd_Question'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Invalid sumbmission.';
			}
			else
			{
				$cond	= "	WHERE z_question.question_id = ".sec_db_clean($this->db->conn, $_POST['hdd_Question']);
			}
			if(!isset($_POST['hdd_Answer']) || $_POST['hdd_Answer'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please select an answer.';
			}
			
			$_POST['txt_Name']	= trim($_POST['txt_Name']);
			if(!isset($_POST['txt_Name']) || $_POST['txt_Name'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please fill in your name.';
			}
			
			$_POST['txt_Email']	= trim($_POST['txt_Email']);
			if(!isset($_POST['txt_Email']) || $_POST['txt_Email'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please fill in your email.';
			}
			elseif (!filter_var($_POST['txt_Email'], FILTER_VALIDATE_EMAIL)) {
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please enter a valid email.';
			}
			if(!isset($_POST['hdd_Gender']) || $_POST['hdd_Gender'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please select your gender.';
			}
			if(!isset($_POST['hdd_Age']) || $_POST['hdd_Age'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please select your age range.';
			}
			if(!isset($_POST['hdd_Location']) || $_POST['hdd_Location'] == '')
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please select your location.';
			}
			if(!isset($_POST['hdd_AgreeTnC']) || $_POST['hdd_AgreeTnC'] == '' || $_POST['hdd_AgreeTnC'] == 0)
			{
				$this->formError	= TRUE;
				$this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
				$this->formErrorMsg	.= 'Please agree to Terms and Conditions &amp; Privacy Policy.';
			}
			
			if(!$this->formError)
			{
				$sessionID	= uniqid().$_POST['hdd_Age'].strtolower($_POST['hdd_Location']).uniqid();
				// ----------------------------------------------------------------------- //
				// UPDATE voucher status
				// ----------------------------------------------------------------------- //
				$voucherCountry	= ($_POST['hdd_Location'] == 'Singapore')?'sg':'my';
				$sql	= "	UPDATE z_voucher_1 SET
								voucher_status_id = 19,
								voucher_session_id = '{$sessionID}'
							WHERE voucher_id = (
								SELECT voucher_id
								FROM `z_voucher`
								WHERE voucher_country = '".sec_db_clean($this->db->conn, $voucherCountry)."'
									AND voucher_status_id = 1
								LIMIT 0,1
							)";
				// BEGIN mysql transaction
				$this->db->trans_start();
				// EXECUTE sql query
				$Q	= $this->db->query($sql);
				// END mysql transaction
				$this->db->trans_complete();
				if($Q->affected_row() <= 0)
				{
					$this->formError	= TRUE;
					$this->formErrorMsg	= addslashes('Sorry we\'re running out of vouchers.');
				}
				else
				{
					// ----------------------------------------------------------------------- //
					// GET voucher ID
					// ----------------------------------------------------------------------- //
					// GENERATE sql query
					$sql	= " SELECT *
								FROM `z_voucher`
								WHERE voucher_session_id = '{$sessionID}'";
					// EXECUTE sql query
					$Q		= $this->db->query($sql);
					$a_Voucher = $Q->result();
					$ctime  = $mtime = time();
					$a_Insert	= array(
						'submission_ip'				=> $_SESSION['ss_Geo']['ip'],
						'submission_country_code'	=> strtoupper($_SESSION['ss_Geo']['country_code']),
						'submission_question_id'	=> $_POST['hdd_Question'],
						'submission_answer_id'		=> $_POST['hdd_Answer'],
						'submission_name'			=> $_POST['txt_Name'],
						'submission_email'			=> $_POST['txt_Email'],
						'submission_gender'			=> $_POST['hdd_Gender'],
						'submission_age'			=> $_POST['hdd_Age'],
						'submission_location'		=> $_POST['hdd_Location'],
						'submission_subscribe'		=> $_POST['hdd_SubscribeNewsletter'],
						'submission_voucher_id'		=> $a_Voucher['voucher_id'],
						'submission_voucher_tbl'	=> $a_Voucher['voucher_tbl'],
						'submission_utm_source'		=> $_POST['hdd_UTMSource'],
						'submission_utm_medium'		=> $_POST['hdd_UTMMedium'],
						'submission_utm_campaign'	=> $_POST['hdd_UTMCampaign'],
						'submission_utm_content'	=> $_POST['hdd_UTMContent'],
						'submission_ctime'			=> $ctime,
						'submission_mtime'			=> $mtime
					);
					
					// CLEAN data before insert
					foreach($a_Insert as &$insert)
					{
						$insert	= sec_db_clean($this->db->conn, $insert);
					}
					
					// ----------------------------------------------------------------------- //
					// INSERT submission to database
					// ----------------------------------------------------------------------- //
					$sql	= "	INSERT INTO `z_submission` SET 
									submission_ip			= '{$a_Insert['submission_ip']}',
									submission_country_code	= '{$a_Insert['submission_country_code']}',
									submission_question_id	= {$a_Insert['submission_question_id']},
									submission_answer_id	= {$a_Insert['submission_answer_id']},
									submission_name			= '{$a_Insert['submission_name']}',
									submission_email		= '{$a_Insert['submission_email']}',
									submission_gender		= '{$a_Insert['submission_gender']}',
									submission_age			= '{$a_Insert['submission_age']}',
									submission_location		= '{$a_Insert['submission_location']}',
									submission_subscribe	= {$a_Insert['submission_subscribe']},
									submission_voucher_id	= {$a_Insert['submission_voucher_id']},
									submission_voucher_tbl	= '{$a_Insert['submission_voucher_tbl']}',
									submission_utm_source	= '{$a_Insert['submission_utm_source']}',
									submission_utm_medium	= '{$a_Insert['submission_utm_medium']}',
									submission_utm_campaign	= '{$a_Insert['submission_utm_campaign']}',
									submission_utm_content	= '{$a_Insert['submission_utm_content']}',
									submission_ctime		= {$a_Insert['submission_ctime']},
									submission_mtime		= {$a_Insert['submission_ctime']}";
					// BEGIN mysql transaction
					$this->db->trans_start();
					// EXECUTE sql query
					$Q	= $this->db->query($sql);
					$submissionID	= $Q->insert_id();
					// END mysql transaction
					$this->db->trans_complete();
					$_SESSION['ss_Submission']	= $a_Insert;
					$_SESSION['ss_Submission']['submission_id']	= $submissionID;
					$_SESSION['ss_Submission']['voucher_code']	= $a_Voucher['voucher_code'];
					$_SESSION['ss_Submission']['voucher_validation_code']	= $a_Voucher['voucher_validation_code'];
					
					// ----------------------------------------------------------------------- //
					// SEND email
					// ----------------------------------------------------------------------- //
					$to			= $a_Insert['submission_email'];
					$subject	= 'HAPPY BR DAY to you!!';
					$headers	= "From: Baskin Robbins " . strip_tags($this->config['mail_admin_email']) . "\r\n";
					$headers	.= "Reply-To: Baskin Robbins ". strip_tags($this->config['mail_admin_email']) . "\r\n";
					//$headers	.= "CC: susan@example.com\r\n";
					$headers	.= "MIME-Version: 1.0\r\n";
					$headers	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					
					$this->voucherCode				= $a_Voucher['voucher_code'];
					$this->voucherValidationCode	= $a_Voucher['voucher_validation_code'];
					
					$message = $this->p_load_view('email_template/submission');
					
					$emailStatus	= mail($to, $subject, $message, $headers);
					
					$_SESSION['ss_Submission']['email_status']	= $emailStatus;
					// ----------------------------------------------------------------------- //
					// UPDATE submission status
					// ----------------------------------------------------------------------- //
					$emailStatusId	= ($emailStatus)?14:3;
					$sql	= "	UPDATE z_submission SET submission_email_send_status_id = {$emailStatusId} WHERE submission_id = {$submissionID}";
					// BEGIN mysql transaction
					$this->db->trans_start();
					// EXECUTE sql query
					$Q	= $this->db->query($sql);
					// END mysql transaction
					$this->db->trans_complete();
					
					redirect(base_url().'thank-you');
				}
			}
		}
		
		// GENERATE sql query
		$sql	= " SELECT * FROM `z_question` {$cond}";
		
		// EXECUTE sql query
		$Q		= $this->db->query($sql);
		
		if($Q->num_rows() > 0)
		{
			$this->a_QuestionList = $Q->result_array();
			$this->a_Question	= $this->a_QuestionList[rand(0, count($this->a_QuestionList) - 1)];
			
			$this->a_Question['question_option']	= json_decode($this->a_Question['question_option'], TRUE);
		}
		
		// ----------------------------------------------------------------------- //
		// LOAD views and render
		// ----------------------------------------------------------------------- //
		$this->p_render('index/index');
	}
}