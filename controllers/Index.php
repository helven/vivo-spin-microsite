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
        }
        // ----------------------------------------------------------------------- //
        // INIT
        // ----------------------------------------------------------------------- //
        
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
            
            // CLEAN $_POST
            sec_clean_all_post($this->db->conn);

            if(!$this->formError)
            {
                // ----------------------------------------------------------------------- //
                // CHECK if IMEI still available
                // ----------------------------------------------------------------------- //
                // GENERATE sql query
                $sql	= " SELECT *
                            FROM `imeis`
                            WHERE imeis.imei = '{$_POST['txt_IMEI']}'
                                AND status = 1
                            LIMIT 0,1";
                // EXECUTE sql query
                $Q  = $this->db->query($sql);
                if($Q->num_rows() <= 0) // GET submission info if IMEI redeemed to spin (redeem previously)
                {
                    // GENERATE sql query
                    $sql	= " SELECT *
                                FROM `submissions`
                                WHERE submissions.imei = '{$_POST['txt_IMEI']}'
                                    AND status = 1
                                LIMIT 0,1";
                    // EXECUTE sql query
                    $Q  = $this->db->query($sql);
                    if($Q->num_rows() <= 0)
                    {
                        redirect(base_url());
                    }
                    
                    $a_Submission = $Q->result();

                    $_SESSION['ss_Submission']	= $a_Submission;
                    
                    redirect(base_url().'spin');

                    //$this->formError	= TRUE;
                    //$this->formErrorMsg	= addslashes('IMEI redeemed.');
                }
                else // ADD new submission
                {
                    $a_Imei = $Q->result();
                    // ----------------------------------------------------------------------- //
                    // CHECK if IMEI still available
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
                                    imei        = {$a_Insert['imei']},
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
                    $_SESSION['ss_Submission']	= $a_Insert;
                    $_SESSION['ss_Submission']['submission_id']	= $submissionID;
                    
                    redirect(base_url().'spin');
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
        $a_Geo	= $this->_get_geo();
        $_SESSION['ss_Geo']	= $a_Geo;
        
        $this->geoCountryCode	= (in_array(strtolower($_SESSION['ss_Geo']['country_code']), array('my', 'sg')))?$_SESSION['ss_Geo']['country_code']:'MY';
        $this->a_HomeLink		= array(
            'my'	=> 'https://baskinrobbins.com.my/content/baskinrobbins/en.html',
            'sg'	=> 'http://baskinrobbins.com.sg/content/baskinrobbins/en.html'
        );
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