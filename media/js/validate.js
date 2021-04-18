function is_empty(str)
{
    return ((str == null) || (str.length == 0));
}

function is_integer(str)
{
   var i;

    /*if (is_empty(str)) 
       if (is_integer.arguments.length == 1) return defaultEmptyOK;
       else return (is_integer.arguments[1] == true);*/

    for (i = 0; i < str.length; i++)
    {   
        var c = str.charAt(i);
        if (i==0 && !is_digit(c))
        {
            if(c != '-') return false;
        }
        else if (!is_digit(c)) return false;
    }
    return true;
}

function is_positive_int(str)
{
    if(!is_integer(str))
    {
        return false;
    }
    if(str < 0)
    {
        return false;
    }

    return true
}

function is_digit (c)
{
    return ((c >= "0") && (c <= "9"));
}

function is_email (s)
{
    /*if (is_empty(s)) 
        if (isEmail.arguments.length == 1) return defaultEmptyOK;
        else return (isEmail.arguments[1] == true);*/
   
    //if (isWhitespace(s)) return false;
    
    var i = 1;
    var sLength = s.length;

    // look for @
    while ((i < sLength) && (s.charAt(i) != "@"))
    { i++
    }

    if ((i >= sLength) || (s.charAt(i) != "@")) return false;
    else i += 2;

    // look for .
    while ((i < sLength) && (s.charAt(i) != "."))
    { i++
    }

    // there must be at least one character after the .
    if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
    else return true;
}

function min_char(str,len)
{
    return (str.length >= len) ;
}

function max_char(str,len)
{
    return (str.length < len) ;
}

function range_char(str,min,max)
{
    if(min > max)
        return false;
    
    return (str.length >= min && str.length <= max)
}

function valid_year(str,yearS,yearE)
{
    if(yearS > yearE)
        return false;
    
    return (str >= yearS && str <= yearE);
}

/*function is_Year (s)
{   if (is_empty(s)) 
       if (is_Year.arguments.length == 1) return defaultEmptyOK;
       else return (is_Year.arguments[1] == true);
    if (!isNonnegativeInteger(s)) return false;
    return ((s.length == 2) || (s.length == 4));
}*/

function l_Trim(str){if(str==null){return null;}for(var i=0;str.charAt(i)==" ";i++);return str.substring(i,str.length);}
function r_Trim(str){if(str==null){return null;}for(var i=str.length-1;str.charAt(i)==" ";i--);return str.substring(0,i+1);}
function trim(str){return l_Trim(r_Trim(str));}