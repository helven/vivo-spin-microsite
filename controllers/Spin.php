<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(BASEPATH.'/libraries/PHPMailer/src/Exception.php');
require_once(BASEPATH.'/libraries/PHPMailer/src/PHPMailer.php');

Class Spin extends Z_Controller
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
        if($this->config['environment'] == 'live' && date('Y-m-d H:i:s') >= '2020-05-17 00:00:00')
        {
            redirect(base_url().'index/campaign-end/');
        }
        if(!isset($_SESSION['ss_Submission']))
        {
            redirect(base_url());
        }

        // ----------------------------------------------------------------------- //
        // INIT
        // ----------------------------------------------------------------------- //
        // [1] prize_3      RM100: 8%
        // [2] grand_prize  OSIM Bundle: 4%
        // [3] prize_4      RM10: 10%
        // [4] prize_2      RM200: 6%
        // [5] prize_1      Philips TV: 2%
        // [6] prize_0      No prize: 70%

        $a_prize_id_index_mapping = array(
            'prize_0'       => 'index_6',   // No prize: 70%
            'grand_prize'   => 'index_2',   // OSIM Bundle: 4%
            'prize_1'       => 'index_5',   // Philips TV: 2%
            'prize_2'       => 'index_4',   // RM200: 6%
            'prize_3'       => 'index_1',   // RM100: 8%
            'prize_4'       => 'index_3',   // RM10: 10%
        );
        
        $cond	= '';
         // GENERATE sql query
         $sql	= " SELECT *
                    FROM `submissions`
                    WHERE submissions.id = '{$_SESSION['ss_Submission']['id']}'
                        AND status = 1
                    LIMIT 0, 1";
        // EXECUTE sql query
        $Q  = $this->db->query($sql);
        if($Q->num_rows() <= 0)
        {
            redirect(base_url());
        }
        $this->a_submission = $Q->result();

        $_SESSION['ss_Submission']	= $this->a_submission;

        $this->spin_index   = str_replace('index_', '', $a_prize_id_index_mapping[$this->a_submission['spin_prize']]);
        // ----------------------------------------------------------------------- //
        // LOAD views and render
        // ----------------------------------------------------------------------- //
        $this->p_render('spin/index');
    }

    function ajax_update_spin()
    {
        // ----------------------------------------------------------------------- //
        // UPDATE submission spin status
        // ----------------------------------------------------------------------- //
        $sql    = "	UPDATE submissions SET spin_status = 1 WHERE id = {$_SESSION['ss_Submission']['id']}";echo $sql;
        // BEGIN mysql transaction
        $this->db->trans_start();
        // EXECUTE sql query
        $Q	= $this->db->query($sql);
        // END mysql transaction
        $this->db->trans_complete();

        $_SESSION['ss_Submission']['spin_status']   = 1;
    }
}