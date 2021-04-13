<?php
Class Index extends Z_Controller
{
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| MAGIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function __construct()
    {
        parent::__construct();
        // ----------------------------------------------------------------------- //
        // LOAD models
        // ----------------------------------------------------------------------- //
        $this->p_load_model('MSubmission');
        // ----------------------------------------------------------------------- //
        // INIT variable
        // ----------------------------------------------------------------------- //
        $this->MSubmission  = new MSubmission();
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PUBLIC function
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function index()
    {
        if($this->config['environment'] == 'live' && date('Y-m-d H:i:s') >= '2021-07-01 00:00:00')
        {
            redirect(base_url().'index/campaign-end/');
            exit;
        }
        // ----------------------------------------------------------------------- //
        // INIT
        // ----------------------------------------------------------------------- //
        $this->a_area = array(
            'area_1'    => 'vivo E-Store',
            'area_2'    => 'Kuala Lumpur 吉隆坡',
            'area_3'    => 'Northern Selangor 雪北',
            'area_4'    => 'Southern Selangor 雪南',
            'area_5'    => 'Perak 霹雳',
            'area_5'    => 'Pahang / Malacca 彭亨 / 马六甲',
            'area_7'    => 'Penang 大槟城',
            'area_8'    => 'Kelantan 吉兰丹',
            'area_9'    => 'Johor 柔佛',
            'area_10'   => 'Sabah 沙巴',
            'area_11'   => 'Sarawak 沙捞越',
        );

        $cond	= '';
        // CHECK if postback
        if(isset($_POST['hdd_Action']))
        {
            $this->formError	= FALSE;
            $this->formErrorMsg	= '';

            $_POST['txt_Name']	= trim($_POST['txt_Name']);
            if(!isset($_POST['txt_Name']) || $_POST['txt_Name'] == '')
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Please fill in your name.';
            }
            
            $_POST['txt_Phone']	= trim($_POST['txt_Phone']);
            if(!isset($_POST['txt_Phone']) || $_POST['txt_Phone'] == '')
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Please fill in your phone no.';
            }

            preg_match_all('/\+6|\ |\-|\_|\(|\)/i', $_POST['txt_Phone'], $result);
            if($result[0])
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Invalid phone no.';
            }

            $_POST['txt_IMEI']	= trim($_POST['txt_IMEI']);
            if(!isset($_POST['txt_IMEI']) || $_POST['txt_IMEI'] == '')
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Please fill in IMEI.';
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
                // CLEAN $_POST
                sec_clean_all_post($this->db->conn);

                // ----------------------------------------------------------------------- //
                // CHECK if phone number is used
                // ----------------------------------------------------------------------- //
                $phone  = $_POST['txt_Phone'];
                $phone   = str_replace(array('+6', ' ', '-', '_', '(', ')'), '', $phone);
                $_POST['txt_Phone'] = $phone;

                $a_cond= array(
                    'table'     => 'submissions',
                    'field'     => 'phone',
                    'value'     => $_POST['txt_Phone'],
                    'compare'=> '='
                );
                $a_submission   = $this->MSubmission->get_submission($a_cond);

                if($a_submission['status'])
                {
                    $_SESSION['ss_Msgbox']['title']		= 'Opps!';
                    $_SESSION['ss_Msgbox']['message']	= 'Phone number '.$_POST['txt_Phone'].' is used.';
                    $_SESSION['ss_Msgbox']['type']		= 'error';

                    redirect(base_url());
                    exit;
                }
                // ----------------------------------------------------------------------- //
                // CHECK if IMEI still available
                // ----------------------------------------------------------------------- //
                // GENERATE sql query
                $sql	= " SELECT *
                            FROM `imeis`
                            WHERE imeis.imei = '{$_POST['txt_IMEI']}'
                            LIMIT 0,1";
                // EXECUTE sql query
                $Q  = $this->db->query($sql);
                
                if($Q->num_rows() <= 0)
                {
                    $_SESSION['ss_Msgbox']['title']		= 'Opps!';
                    $_SESSION['ss_Msgbox']['message']	= 'Invalid IMEI.';
                    $_SESSION['ss_Msgbox']['type']		= 'error';

                    redirect(base_url());
                    exit;
                }

                $a_Imei = $Q->result();

                if($a_Imei['status'] == '19') // GET submission info if IMEI redeemed to spin (redeemed previously)
                {
                    $a_cond= array(
                        'table'     => 'submissions',
                        'field'     => 'imei',
                        'value'     => $_POST['txt_IMEI'],
                        'compare'=> '='
                    );
                    $a_submission   = $this->MSubmission->get_submission($a_cond);

                    if(!$a_submission['status'])
                    {
                        $_SESSION['ss_Msgbox']['title']		= 'Opps!';
                        $_SESSION['ss_Msgbox']['message']	= 'Invalid Submission.';
                        $_SESSION['ss_Msgbox']['type']		= 'error';

                        redirect(base_url());
                        exit;
                    }

                    $a_Submission = $Q->result();

                    $_SESSION['ss_Submission']	= $a_Submission;
                    
                    redirect(base_url().'spin');
                    exit;
                }
                elseif($a_Imei['status'] == '1') // ADD new submission
                {
                    // ----------------------------------------------------------------------- //
                    // CHECK if today redemtion stil available for that area
                    // ----------------------------------------------------------------------- //
                    $sql    = " SELECT COUNT(*) AS redemption_count
                                FROM submissions
                                WHERE area = '{$_POST['hdd_Location']}'
                                    AND created_at BETWEEN '".date('Y-m-d 00:00:00')."' AND '".date('Y-m-d 23:59:59')."'";
                    // EXECUTE sql query
                    $Q  = $this->db->query($sql);

                    $redemptionCount    = $Q->result();
                    $redemptionCount    = $redemptionCount['redemption_count'];
                    // ----------------------------------------------------------------------- //
                    // DETERMINE prize
                    // ----------------------------------------------------------------------- //
                    if($redemptionCount > $this->config['area_prize'][$_POST['hdd_Location']]) // no prize
                    {
                        $prize  = 0;
                    }
                    else // random prize
                    {
                        // [1] RM100: 8%
                        // [2] OSIM Bundle: 4%
                        // [3] RM10: 10%
                        // [4] RM200: 6%
                        // [5] Philips TV: 2%
                        // [6] No prize: 70%
                        $a_prize_pool   = array(
                            1,1,1,1,1,1,1,1,
                            2,2,2,2,
                            3,3,3,3,3,3,3,3,3,3,
                            4,4,4,4,4,4,
                            5,5,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                            6,6,6,6,6,6,6,6,6,6,
                        );
                        $prize  = $a_prize_pool[rand(0, count($a_prize_pool) - 1)];
                    }
                    
                    // ----------------------------------------------------------------------- //
                    // UPDATE IMEI status
                    // ----------------------------------------------------------------------- //
                    $sql	= "	UPDATE imeis SET status = 19 WHERE id = {$a_Imei['id']}";
                    // BEGIN mysql transaction
                    $this->db->trans_start();
                    // EXECUTE sql query
                    $Q	= $this->db->query($sql);
                    // END mysql transaction
                    $this->db->trans_complete();
                    
                    $a_Insert	= array(
                        'ip'            => $_SESSION['ss_Geo']['ip'],
                        'name'          => $_POST['txt_Name'],
                        'phone'         => $_POST['txt_Phone'],
                        'imei'          => $_POST['txt_IMEI'],
                        'area'          => $_POST['hdd_Location'],
                        'spin_status'   => 0,
                        'spin_prize'    => $prize,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    );
                    
                    // CLEAN data before insert
                    foreach($a_Insert as &$insert)
                    {
                        $insert	= sec_db_clean($this->db->conn, $insert);
                    }
                    
                    // ----------------------------------------------------------------------- //
                    // INSERT submission to database
                    // ----------------------------------------------------------------------- //
                    $sql    = " INSERT INTO `submissions` SET 
                                    ip          = '{$a_Insert['ip']}',
                                    name        = '{$a_Insert['name']}',
                                    phone       = '{$a_Insert['phone']}',
                                    area        = {$a_Insert['area']},
                                    imei        = '{$a_Insert['imei']}',
                                    spin_status = {$a_Insert['spin_status']},
                                    spin_prize  = {$a_Insert['spin_prize']},
                                    created_at  = '{$a_Insert['created_at']}',
                                    updated_at  = '{$a_Insert['updated_at']}'";
                    // BEGIN mysql transaction
                    $this->db->trans_start();
                    // EXECUTE sql query
                    $Q	= $this->db->query($sql);
                    $submissionID   = $Q->insert_id();
                    // END mysql transaction
                    $this->db->trans_complete();
                    $a_Insert['id'] = $submissionID;

                    $_SESSION['ss_Submission']	= $a_Insert;
                    
                    redirect(base_url().'spin');
                    exit;
                }
                else
                {
                    $_SESSION['ss_Msgbox']['title']		= 'Opps!';
                    $_SESSION['ss_Msgbox']['message']	= 'Invalid IMEI.';
                    $_SESSION['ss_Msgbox']['type']		= 'error';

                    redirect(base_url());
                    exit;
                }
            }
        }
        // ----------------------------------------------------------------------- //
        // LOAD views and render
        // ----------------------------------------------------------------------- //
        $this->p_render('index/index');
    }
    
    function campaign_end()
    {
        // ----------------------------------------------------------------------- //
        // INIT
        // ----------------------------------------------------------------------- //
        
        // ----------------------------------------------------------------------- //
        // LOAD views and render
        // ----------------------------------------------------------------------- //
        $this->p_render('index/campaign_end');
    }
    
    function thank_you()
    {
        // ----------------------------------------------------------------------- //
        // LOAD views and render
        // ----------------------------------------------------------------------- //
        $this->p_render('index/thank_you');
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PRIVATE function
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
}