<?php
class Input
{
    var $use_xss_clean      = FALSE;
    var $xss_hash           = '';
    var $ip_address         = FALSE;
    var $user_agent         = FALSE;
    var $allow_get_array    = FALSE;
    
    /* never allowed, string replacement */
    var $never_allowed_str = array(
                                    'document.cookie'	=> '[removed]',
                                    'document.write'	=> '[removed]',
                                    '.parentNode'		=> '[removed]',
                                    '.innerHTML'		=> '[removed]',
                                    'window.location'	=> '[removed]',
                                    '-moz-binding'		=> '[removed]',
                                    '<!--'				=> '&lt;!--',
                                    '-->'				=> '--&gt;',
                                    '<![CDATA['			=> '&lt;![CDATA['
                                    );
    /* never allowed, regex replacement */
    var $never_allowed_regex = array(
                                        "javascript\s*:"			=> '[removed]',
                                        "expression\s*(\(|&\#40;)"	=> '[removed]', // CSS and IE
                                        "vbscript\s*:"				=> '[removed]', // IE, surprise!
                                        "Redirect\s+302"			=> '[removed]'
                                    );
    
    /**
    * Constructor
    *
    * Sets whether to globally enable the XSS processing
    * and whether to allow the $_GET array
    *
    * @access	public
    */
    function __constructor()
    {
        //log_message('debug', "Input Class Initialized");

        //$CFG =& load_class('Config');
        //$this->use_xss_clean	= ($CFG->item('global_xss_filtering') === TRUE) ? TRUE : FALSE;
        //$this->allow_get_array	= ($CFG->item('enable_query_strings') === TRUE) ? TRUE : FALSE;
        $this->_sanitize_globals();
    }

    // --------------------------------------------------------------------

    /**
    * Sanitize Globals
    *
    * This function does the following:
    *
    * Unsets $_GET data (if query strings are not enabled)
    *
    * Unsets all globals if register_globals is enabled
    *
    * Standardizes newline characters to \n
    *
    * @access	private
    * @return	void
    */
    function _sanitize_globals()
    {
        // Would kind of be "wrong" to unset any of these GLOBALS
        $protected = array('_SERVER', '_GET', '_POST', '_FILES', '_REQUEST', '_SESSION', '_ENV', 'GLOBALS', 'HTTP_RAW_POST_DATA',
                            'system_folder', 'application_folder', 'BM', 'EXT', 'CFG', 'URI', 'RTR', 'OUT', 'IN');

        // Unset globals for security. 
        // This is effectively the same as register_globals = off
        foreach (array($_GET, $_POST, $_COOKIE, $_SERVER, $_FILES, $_ENV, (isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : array()) as $global)
        {
            if ( ! is_array($global))
            {
                if ( ! in_array($global, $protected))
                {
                    unset($GLOBALS[$global]);
                }
            }
            else
            {
                foreach ($global as $key => $val)
                {
                    if ( ! in_array($key, $protected))
                    {
                        unset($GLOBALS[$key]);
                    }

                    if (is_array($val))
                    {
                        foreach($val as $k => $v)
                        {
                            if ( ! in_array($k, $protected))
                            {
                                unset($GLOBALS[$k]);
                            }
                        }
                    }
                }
            }
        }

        // Is $_GET data allowed? If not we'll set the $_GET to an empty array
        if ($this->allow_get_array == FALSE)
        {
            $_GET = array();
        }
        else
        {
            $_GET = $this->_clean_input_data($_GET);
        }

        // Clean $_POST Data
        $_POST = $this->_clean_input_data($_POST);

        // Clean $_COOKIE Data
        // Also get rid of specially treated cookies that might be set by a server
        // or silly application, that are of no use to a CI application anyway
        // but that when present will trip our 'Disallowed Key Characters' alarm
        // http://www.ietf.org/rfc/rfc2109.txt
        // note that the key names below are single quoted strings, and are not PHP variables
        unset($_COOKIE['$Version']);
        unset($_COOKIE['$Path']);
        unset($_COOKIE['$Domain']);
        $_COOKIE = $this->_clean_input_data($_COOKIE);

    }

    // --------------------------------------------------------------------

    /**
    * Clean Input Data
    *
    * This is a helper function. It escapes data and
    * standardizes newline characters to \n
    *
    * @access	private
    * @param	string
    * @return	string
    */
    function _clean_input_data($str)
    {
        if (is_array($str))
        {
            $new_array = array();
            foreach ($str as $key => $val)
            {
                $new_array[$this->_clean_input_keys($key)] = $this->_clean_input_data($val);
            }
            return $new_array;
        }

        // We strip slashes if magic quotes is on to keep things consistent
        if (get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }

        // Should we filter the input data?
        if ($this->use_xss_clean === TRUE)
        {
            $str = $this->xss_clean($str);
        }

        // Standardize newlines
        if (strpos($str, "\r") !== FALSE)
        {
            $str = str_replace(array("\r\n", "\r"), "\n", $str);
        }

        return $str;
    }
    
    /**
    * XSS Clean
    *
    * Sanitizes data so that Cross Site Scripting Hacks can be
    * prevented.  This function does a fair amount of work but
    * it is extremely thorough, designed to prevent even the
    * most obscure XSS attempts.  Nothing is ever 100% foolproof,
    * of course, but I haven't been able to get anything passed
    * the filter.
    *
    * Note: This function should only be used to deal with data
    * upon submission.  It's not something that should
    * be used for general runtime processing.
    *
    * This function was based in part on some code and ideas I
    * got from Bitflux: http://blog.bitflux.ch/wiki/XSS_Prevention
    *
    * To help develop this script I used this great list of
    * vulnerabilities along with a few other hacks I've
    * harvested from examining vulnerabilities in other programs:
    * http://ha.ckers.org/xss.html
    *
    * @access	public
    * @param	string
    * @return	string
    */
    function xss_clean($str, $is_image = FALSE)
    {
        /*
        * Is the string an array?
        *
        */
        if (is_array($str))
        {
            while (list($key) = each($str))
            {
                $str[$key] = $this->xss_clean($str[$key]);
            }

            return $str;
        }

        /*
        * Remove Invisible Characters
        */
        $str = $this->_remove_invisible_characters($str);

        /*
        * Protect GET variables in URLs
        */

        // 901119URL5918AMP18930PROTECT8198

        $str = preg_replace('|\&([a-z\_0-9]+)\=([a-z\_0-9]+)|i', $this->xss_hash()."\\1=\\2", $str);

        /*
        * Validate standard character entities
        *
        * Add a semicolon if missing.  We do this to enable
        * the conversion of entities to ASCII later.
        *
        */
        $str = preg_replace('#(&\#?[0-9a-z]{2,})([\x00-\x20])*;?#i', "\\1;\\2", $str);

        /*
        * Validate UTF16 two byte encoding (x00) 
        *
        * Just as above, adds a semicolon if missing.
        *
        */
        $str = preg_replace('#(&\#x?)([0-9A-F]+);?#i',"\\1\\2;",$str);

        /*
        * Un-Protect GET variables in URLs
        */
        $str = str_replace($this->xss_hash(), '&', $str);

        /*
        * URL Decode
        *
        * Just in case stuff like this is submitted:
        *
        * <a href="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">Google</a>
        *
        * Note: Use rawurldecode() so it does not remove plus signs
        *
        */
        $str = rawurldecode($str);

        /*
        * Convert character entities to ASCII 
        *
        * This permits our tests below to work reliably.
        * We only convert entities that are within tags since
        * these are the ones that will pose security problems.
        *
        */

        $str = preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", array($this, '_convert_attribute'), $str);

        $str = preg_replace_callback("/<\w+.*?(?=>|<|$)/si", array($this, '_html_entity_decode_callback'), $str);

        /*
        * Remove Invisible Characters Again!
        */
        $str = $this->_remove_invisible_characters($str);

        /*
        * Convert all tabs to spaces
        *
        * This prevents strings like this: ja	vascript
        * NOTE: we deal with spaces between characters later.
        * NOTE: preg_replace was found to be amazingly slow here on large blocks of data,
        * so we use str_replace.
        *
        */

        if (strpos($str, "\t") !== FALSE)
        {
            $str = str_replace("\t", ' ', $str);
        }

        /*
        * Capture converted string for later comparison
        */
        $converted_string = $str;

        /*
        * Not Allowed Under Any Conditions
        */

        foreach ($this->never_allowed_str as $key => $val)
        {
            $str = str_replace($key, $val, $str);   
        }

        foreach ($this->never_allowed_regex as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);   
        }

        /*
        * Makes PHP tags safe
        *
        *  Note: XML tags are inadvertently replaced too:
        *
        *	<?xml
        *
        * But it doesn't seem to pose a problem.
        *
        */
        if ($is_image === TRUE)
        {
            // Images have a tendency to have the PHP short opening and closing tags every so often
            // so we skip those and only do the long opening tags.
            $str = preg_replace('/<\?(php)/i', "&lt;?\\1", $str);
        }
        else
        {
            $str = str_replace(array('<?', '?'.'>'),  array('&lt;?', '?&gt;'), $str);
        }

        /*
        * Compact any exploded words
        *
        * This corrects words like:  j a v a s c r i p t
        * These words are compacted back to their correct state.
        *
        */
        $words = array('javascript', 'expression', 'vbscript', 'script', 'applet', 'alert', 'document', 'write', 'cookie', 'window');
        foreach ($words as $word)
        {
            $temp = '';

            for ($i = 0, $wordlen = strlen($word); $i < $wordlen; $i++)
            {
                $temp .= substr($word, $i, 1)."\s*";
            }

            // We only want to do this when it is followed by a non-word character
            // That way valid stuff like "dealer to" does not become "dealerto"
            $str = preg_replace_callback('#('.substr($temp, 0, -3).')(\W)#is', array($this, '_compact_exploded_words'), $str);
        }

        /*
        * Remove disallowed Javascript in links or img tags
        * We used to do some version comparisons and use of stripos for PHP5, but it is dog slow compared
        * to these simplified non-capturing preg_match(), especially if the pattern exists in the string
        */
        do
        {
            $original = $str;

            if (preg_match("/<a/i", $str))
            {
                $str = preg_replace_callback("#<a\s+([^>]*?)(>|$)#si", array($this, '_js_link_removal'), $str);
            }

            if (preg_match("/<img/i", $str))
            {
                $str = preg_replace_callback("#<img\s+([^>]*?)(\s?/?>|$)#si", array($this, '_js_img_removal'), $str);
            }

            if (preg_match("/script/i", $str) OR preg_match("/xss/i", $str))
            {
                $str = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '[removed]', $str);
            }
        }
        while($original != $str);

        unset($original);

        /*
        * Remove JavaScript Event Handlers
        *
        * Note: This code is a little blunt.  It removes
        * the event handler and anything up to the closing >,
        * but it's unlikely to be a problem.
        *
        */
        $event_handlers = array('[^a-z_\-]on\w*','xmlns');

        if ($is_image === TRUE)
        {
            /*
            * Adobe Photoshop puts XML metadata into JFIF images, including namespacing, 
            * so we have to allow this for images. -Paul
            */
            unset($event_handlers[array_search('xmlns', $event_handlers)]);
        }

        $str = preg_replace("#<([^><]+?)(".implode('|', $event_handlers).")(\s*=\s*[^><]*)([><]*)#i", "<\\1\\4", $str);

        /*
        * Sanitize naughty HTML elements
        *
        * If a tag containing any of the words in the list
        * below is found, the tag gets converted to entities.
        *
        * So this: <blink>
        * Becomes: &lt;blink&gt;
        *
        */
        $naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
        $str = preg_replace_callback('#<(/*\s*)('.$naughty.')([^><]*)([><]*)#is', array($this, '_sanitize_naughty_html'), $str);

        /*
        * Sanitize naughty scripting elements
        *
        * Similar to above, only instead of looking for
        * tags it looks for PHP and JavaScript commands
        * that are disallowed.  Rather than removing the
        * code, it simply converts the parenthesis to entities
        * rendering the code un-executable.
        *
        * For example:	eval('some code')
        * Becomes:		eval&#40;'some code'&#41;
        *
        */
        $str = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $str);

        /*
        * Final clean up
        *
        * This adds a bit of extra precaution in case
        * something got through the above filters
        *
        */
        foreach ($this->never_allowed_str as $key => $val)
        {
            $str = str_replace($key, $val, $str);   
        }

        foreach ($this->never_allowed_regex as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        /*
        *  Images are Handled in a Special Way
        *  - Essentially, we want to know that after all of the character conversion is done whether
        *  any unwanted, likely XSS, code was found.  If not, we return TRUE, as the image is clean.
        *  However, if the string post-conversion does not matched the string post-removal of XSS,
        *  then it fails, as there was unwanted XSS code found and removed/changed during processing.
        */

        if ($is_image === TRUE)
        {
            if ($str == $converted_string)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        //log_message('debug', "XSS Filtering completed");
        return $str;
    }

    /**
    * Remove Invisible Characters
    *
    * This prevents sandwiching null characters
    * between ascii characters, like Java\0script.
    *
    * @access	public
    * @param	string
    * @return	string
    */
    function _remove_invisible_characters($str)
    {
        static $non_displayables;

        if ( ! isset($non_displayables))
        {
            // every control character except newline (dec 10), carriage return (dec 13), and horizontal tab (dec 09),
            $non_displayables = array(
                                        '/%0[0-8bcef]/',			// url encoded 00-08, 11, 12, 14, 15
                                        '/%1[0-9a-f]/',				// url encoded 16-31
                                        '/[\x00-\x08]/',			// 00-08
                                        '/\x0b/', '/\x0c/',			// 11, 12
                                        '/[\x0e-\x1f]/'				// 14-31
                                    );
        }

        do
        {
            $cleaned = $str;
            $str = preg_replace($non_displayables, '', $str);
        }
        while ($cleaned != $str);

        return $str;
    }
    
    /**
    * Random Hash for protecting URLs
    *
    * @access	public
    * @return	string
    */
    function xss_hash()
    {
        if ($this->xss_hash == '')
        {
            if (phpversion() >= 4.2)
                mt_srand();
            else
                mt_srand(hexdec(substr(md5(microtime()), -8)) & 0x7fffffff);

            $this->xss_hash = md5(time() + mt_rand(0, 1999999999));
        }

        return $this->xss_hash;
    }
}