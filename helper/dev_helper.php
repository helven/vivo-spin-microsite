<?php
/**
 * Print Array
 *
 * Print array with <pre> tag
 *
 * @access  public
 * @param   $a_array
 * @return  TRUE
 */
function dd($a_array,$buffer=FALSE)
{
    if($buffer)
    {
        ob_start();
        echo '<pre>';
        print_r($a_array);
        echo '</pre>';
        return ob_get_clean();
    }
    
    echo '<pre>';
    print_r($a_array);
    echo '</pre>';
    
    exit;
}

function print_a($a_array,$buffer=FALSE)
{
    if($buffer)
    {
        ob_start();
        echo '<pre>';
        print_r($a_array);
        echo '</pre>';
        return ob_get_clean();
    }
    
    echo '<pre>';
    print_r($a_array);
    echo '</pre>';
    
    return TRUE;
}
/**
 * Print Var dump
 *
 * Print var_dump with <pre> tag
 *
 * @access  public
 * @param   $a_array
 * @return  TRUE
 */
function print_v($a_array,$buffer=FALSE)
{
    if($buffer)
    {
        ob_start();
        echo '<pre>';
        var_dump($a_array);
        echo '</pre>';
        return ob_get_clean();
    }
    
    echo '<pre>';
    var_dump($a_array);
    echo '</pre>';
    
    return TRUE;
}

/**
 * Print code
 *
 * Print any <code> tag
 *
 * @access  public
 * @param   $str
 * @return  TRUE
 */
function print_c($a_array,$buffer=FALSE)
{
    if($buffer)
    {
        ob_start();
        echo '<code>';
        print_r($a_array);
        echo '</code>';
        return ob_get_clean();
    }
    
    echo '<code>';
    print_r($a_array);
    echo '</code>';
    
    return TRUE;
}