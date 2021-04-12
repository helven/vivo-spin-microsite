<?php
class MSubmission extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_submission_list($a_cond='', $order='', $group_by='', $a_limit='ALL')
    {
        $a_rtn_data = array();
        $a_data = array();
        // ----------------------------------------------------------------------- //
        // BUILD sql query
        // ----------------------------------------------------------------------- //
        $select = " SELECT
                        submissions.*, 
                        attr_status.value AS status_value,
                        players.name AS player_name,
                        players.email AS player_email";
        $from   = " FROM submissions
                        LEFT JOIN attr_status ON submissions.status = attr_status.id
                        LEFT JOIN players ON submissions.player_id = players.id";
        $where  = " WHERE 1 = 1";
        $cond   = set_condition($a_cond);
        // SET default order
        if($order == '')
        {
            $order	= "	ORDER BY
                            z_submission.submission_id ASC";
        }
        $limit      = set_limit($a_limit);
        if(!isset($a_limit) || $a_limit == 'ALL')
        {
            $a_limit[0] = 0;
        }
        $sql    = $select.$from.$where.$cond.$group_by.$limit;

        // EXECUTE sql query
        $Q      = $this->db->query($sql);

        if($Q->num_rows() > 0)
        {
            $a_data                 = $Q->result_array();
            $a_rtn_data['a_data']   = $a_data;
            $a_rtn_data['status']   = TRUE;
        }
        else
        {
            $a_rtn_data['status']   = FALSE;
            $a_rtn_data['msg']      = 'We\'re sorry, the submission you\'re looking for cannot be found.';
        }
        
        $Q->free_result();
        
        return $a_rtn_data;
    }

    function get_submission($a_cond='', $mode='FULL')
    {
        $a_rtn_data = array();
        $a_data = array();
        // ----------------------------------------------------------------------- //
        // BUILD sql query
        // ----------------------------------------------------------------------- //
        $select = " SELECT
                        submissions.*, 
                        attr_status.value AS status_value";
        $from   = " FROM submissions
                        LEFT JOIN attr_status ON submissions.status = attr_status.id";
        $where  = " WHERE 1 = 1";
        $cond   = set_condition($a_cond);
        $sql    = $select.$from.$where.$cond;

        // EXECUTE sql query
        $Q      = $this->db->query($sql);

        if($Q->num_rows() > 0)
        {
            $a_data                 = $Q->result();
            $a_rtn_data['a_data']   = $a_data[0];
            $a_rtn_data['status']   = TRUE;
        }
        else
        {
            $a_rtn_data['status']   = FALSE;
            $a_rtn_data['msg']      = 'We\'re sorry, the Submission you\'re looking for cannot be found.';
        }
        
        $Q->free_result();
        
        return $a_rtn_data;
    }

    function insert_submission($a_insert)
    {
        // ----------------------------------------------------------------------- //
        // INSERT submission to database
        // ----------------------------------------------------------------------- //
        $sql    = " INSERT INTO `submissions` SET
                        player_id   = {$a_insert['player_id']},
                        status      = {$a_insert['status']},
                        ip          = '{$a_insert['ip']}',
                        score       = {$a_insert['score']},
                        is_hacking  = {$a_insert['is_hacking']},
                        created_at  = '{$a_insert['created_at']}',
                        updated_at  = '{$a_insert['updated_at']}'";
        // BEGIN mysql transaction
        $this->db->trans_start();
        // EXECUTE sql query
        $Q  = $this->db->query($sql);
        $submission_id  = $Q->insert_id();
        // END mysql transaction
        $this->db->trans_complete();

        if($this->db->affected_row() > 0)
        {
            $a_rtn  = array(
                'status'        => TRUE,
                'msg'           => 'Submission is successfully inserted.',
                'submission_id' => $submission_id
            );
        }
        else
        {
            $a_rtn  = array(
                'status'        => FALSE,
                'msg'           => 'Submission insert failed.',
            );
        }

        return $a_rtn;
    }
}