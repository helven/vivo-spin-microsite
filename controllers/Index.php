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
        if($this->config['environment'] == 'live' && date('Y-m-d H:i:s') >= '2021-05-17 00:00:00')
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
            'area_6'    => 'Pahang / Malacca 彭亨 / 马六甲',
            'area_7'    => 'Penang 大槟城',
            'area_8'    => 'Kelantan 吉兰丹',
            'area_9'    => 'Johor 柔佛',
            'area_10'   => 'Sabah 沙巴',
            'area_11'   => 'Sarawak 沙捞越',
        );

        // [1] prize_3      RM100: 8%
        // [2] grand_prize  OSIM Bundle: 4%
        // [3] prize_4      RM10: 10%
        // [4] prize_2      RM200: 6%
        // [5] prize_1      Philips TV: 2%
        // [6] prize_0      No prize: 70%
        $a_prize_id_index_mapping = array(
            'prize_0'       => 'index_6',   // No prize: 70%
            'grand_prize'   => 'index_2',   // OSIM Bundle: 2%
            'prize_1'       => 'index_5',   // Philips TV: 4%
            'prize_2'       => 'index_4',   // RM200: 6%
            'prize_3'       => 'index_1',   // RM100: 8%
            'prize_4'       => 'index_3',   // RM10: 10%
        );
        
        $a_prize_index_percentage_pool  = array(
            1,1,1,1,1,1,1,1,        // 8%
            2,2,                    // 2%
            3,3,3,3,3,3,3,3,3,3,    // 10%
            4,4,4,4,4,4,            // 6%
            5,5,5,5,                // 4%
            6,6,6,6,6,6,6,6,6,6,    // 70%
            6,6,6,6,6,6,6,6,6,6,
            6,6,6,6,6,6,6,6,6,6,
            6,6,6,6,6,6,6,6,6,6,
            6,6,6,6,6,6,6,6,6,6,
            6,6,6,6,6,6,6,6,6,6,
            6,6,6,6,6,6,6,6,6,6,
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
                $this->formErrorMsg	.= 'Please fill in your mobile no.';
            }
            elseif(!((int)$_POST['txt_Phone'] == $_POST['txt_Phone'] && (int)$_POST['txt_Phone'] > 0))
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Please fill in a valid mobile no.';
            }

            preg_match_all('/\+6|\ |\-|\_|\(|\)/i', $_POST['txt_Phone'], $result);
            if($result[0])
            {
                $this->formError	= TRUE;
                $this->formErrorMsg	.= ($this->formErrorMsg != '')?'<br />':'';
                $this->formErrorMsg	.= 'Please fill in a valid phone no.';
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
                // CHECK if phone number is used (same phone but different IMEI)
                // ----------------------------------------------------------------------- //
                $_POST['txt_Phone'] = clean_phone_no($_POST['txt_Phone']);

                $a_cond= array(
                    'relation'  => 'AND',
                    'items'     => array(
                        array(
                            'table'     => 'submissions',
                            'field'     => 'phone',
                            'value'     => $_POST['txt_Phone'],
                            'compare'   => '='
                        ),
                        array(
                            'table'     => 'submissions',
                            'field'     => 'imei',
                            'value'     => $_POST['txt_IMEI'],
                            'compare'   => '<>'
                        )
                    )
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

                if($a_Imei['status'] == '19') // GET submission info if IMEI redeemed to spin (redeemed previously, phone and IME must matched)
                {
                    $a_cond= array(
                        'relation'  => 'AND',
                        'items'     => array(
                            array(
                                'table'     => 'submissions',
                                'field'     => 'phone',
                                'value'     => $_POST['txt_Phone'],
                                'compare'   => '='
                            ),
                            array(
                                'table'     => 'submissions',
                                'field'     => 'imei',
                                'value'     => $_POST['txt_IMEI'],
                                'compare'   => '='
                            )
                        )
                    );
                    $a_submission   = $this->MSubmission->get_submission($a_cond);
                    
                    if(!$a_submission['status'])
                    {
                        $_SESSION['ss_Msgbox']['title']		= 'Opps!';
                        $_SESSION['ss_Msgbox']['message']	= 'Invalid Redemption.';
                        $_SESSION['ss_Msgbox']['type']		= 'error';

                        redirect(base_url());
                        exit;
                    }

                    $a_submission               = $a_submission['a_data'];
                    $_SESSION['ss_Submission']  = $a_submission;
                    
                    redirect(base_url().'spin');
                    exit;
                }
                elseif($a_Imei['status'] == '1') // ADD new submission
                {
                    /*// ----------------------------------------------------------------------- //
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
                        $this->prize_index  = 6;
                    }
                    else // random prize
                    {*/
                        

                    // GET prize inventory
                    $sql    = " SELECT * from prizes WHERE area_id = {$_POST['hdd_Location']} AND date = '".date('Y-m-d')."'";
                    if($this->config['environment'] != 'live')
                    {
                        $sql    = " SELECT * from prizes WHERE area_id = {$_POST['hdd_Location']} AND date = '2021-05-01'";
                    }
                    $Q  = $this->db->query($sql);

                    $a_prize    = $Q->result();
                    if($Q->num_rows() <= 0)
                    {
                        $a_prize['id']      = 0;
                    }
                    $a_prize['grand_prize'] = (int)$a_prize['grand_prize'];
                    $a_prize['prize_1']     = (int)$a_prize['prize_1'];
                    $a_prize['prize_2']     = (int)$a_prize['prize_2'];
                    $a_prize['prize_3']     = (int)$a_prize['prize_3'];
                    $a_prize['prize_4']     = (int)$a_prize['prize_4'];

                    $stop   = FALSE;
                    do
                    {
                        // DRAW prize
                        $this->prize_index  = $a_prize_index_percentage_pool[rand(0, count($a_prize_index_percentage_pool) - 1)];

                        $prize = array_search('index_'.$this->prize_index, $a_prize_id_index_mapping);

                        
                        if($this->prize_index == 6) // STOP if is 6
                        {
                            $stop   = TRUE;
                            break;
                        }
                        
                        if($a_prize[$prize] > 0) // STOP if prize is available
                        {
                            $stop   = TRUE;
                            break;
                        }
                    }
                    while(!$stop);

                    // UPDATE prize inventory (minus from inventory)
                    if($prize != 'prize_0')
                    {
                        $sql    = " UPDATE prizes SET
                                        {$prize} = {$prize} - 1,
                                        {$prize}_redeemed = {$prize}_redeemed + 1 
                                    WHERE id = {$a_prize['id']}";
                        // BEGIN mysql transaction
                        $this->db->trans_start();
                        // EXECUTE sql query
                        $Q	= $this->db->query($sql);
                        // END mysql transaction
                        $this->db->trans_complete();
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
                    
                    // ----------------------------------------------------------------------- //
                    // INSERT submission to database
                    // ----------------------------------------------------------------------- //
                    $a_insert	= array(
                        'ip'            => $_SESSION['ss_Geo']['ip'],
                        'name'          => $_POST['txt_Name'],
                        'phone'         => $_POST['txt_Phone'],
                        'imei'          => $_POST['txt_IMEI'],
                        'area_id'          => $_POST['hdd_Location'],
                        'spin_status'   => 0,
                        'prize_id'      => $a_prize['id'],
                        'spin_prize'    => $prize,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    );
                    
                    $sql    = " INSERT INTO `submissions` SET 
                                    ip          = '{$a_insert['ip']}',
                                    name        = '{$a_insert['name']}',
                                    phone       = '{$a_insert['phone']}',
                                    area_id     = {$a_insert['area_id']},
                                    imei        = '{$a_insert['imei']}',
                                    spin_status = {$a_insert['spin_status']},
                                    prize_id    = {$a_insert['prize_id']},
                                    spin_prize  = '{$a_insert['spin_prize']}',
                                    created_at  = '{$a_insert['created_at']}',
                                    updated_at  = '{$a_insert['updated_at']}'";
                    // BEGIN mysql transaction
                    $this->db->trans_start();
                    // EXECUTE sql query
                    $Q	= $this->db->query($sql);
                    $submissionID   = $Q->insert_id();
                    // END mysql transaction
                    $this->db->trans_complete();
                    $a_insert['id'] = $submissionID;

                    $_SESSION['ss_Submission']	= $a_insert;
                    
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