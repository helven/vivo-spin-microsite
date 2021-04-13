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
        if($this->config['environment'] == 'live' && date('Y-m-d H:i:s') >= '2020-03-31 12:00:00')
        {
            redirect(base_url().'index/campaign-end/');
        }
        if(!isset($_SESSION['ss_Submission']))
        {
            redirect(base_url());
        }
        
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