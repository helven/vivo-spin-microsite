<?php
class Excel
{
    private $forceDownload;
    private $filename;
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| MAGIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function __construct()
    {
        $this->forceDownload    = FALSE;
        $this->filename         = 'Movida_Contest_Forms.xls';
    }
    
    function __destruct()
    {
    
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PUBLIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    public function export($a_Data=array())
    {
        ob_start();
        
        self::_xls_BOF();

        if(is_array($a_Data))
        {
            $xlsRow = 0;
            foreach($a_Data as $a_Data_i)
            {
                $xlsCol = 0;
                foreach($a_Data_i as $a_Data_i_i)
                {
                    self::_xls_WriteLabel($xlsRow,$xlsCol,$a_Data_i_i);
                    $xlsCol++;
                }
                $xlsRow++;
            }
        }
        else
        {
            self::_xls_WriteLabel($xlsRow,1,$row['description']);
        }
        
        self::_xls_EOF();
        
        $buffer = ob_get_clean();
        
        if($this->forceDownload)
        {
            echo $buffer;
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=".$this->filename." ");
            header("Content-Transfer-Encoding: binary ");
        }
        else
        {
            file_put_contents($this->filename, $buffer);
            header('location:'.$this->filename);
        }
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PRIVATE FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    private function _xls_BOF()
    {
        echo pack("ssssss",0x809,0x8,0x0, 0x10,0x0,0x0);
        return;
    }
    private function _xls_EOF()
    {
        echo pack("ss",0x0A,0x00);
        return;
    }
    private function _xls_WriteNumber($row, $col, $value)
    {
        echo pack("sssss",0x203,14,$row,$col,0x0);
        echo pack("d", $value);
        return;
    }
    private function _xls_WriteLabel($row,$col,$value)
    {
        $len = strlen($value);
        echo pack("ssssss",0x204,8+$len,$row,$col,0x0,$len);
        echo $value;
        return;
    }
}