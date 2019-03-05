<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Word Filter Configuration
    |--------------------------------------------------------------------------
    |
    |
    */
   


    'table_names' => [

        /*
         * The below table name will be used to create the tables in the database,
         * as well as inform the filter which table to search through.
         *
         * If you wish to use a different table name, change the value below before migrating.
         */

        'blacklist' => 'blacklist_words',

        /*
         * The below table name will be used to create the tables in the database,
         * as well as inform the filter which table to search through.
         *
         * If you wish to use a different table name, change the value below before migrating.
         */

        'whitelist' => 'whitelist_words',

    ],

    /* 
     * If set to true, we need to return a JSON response accepting or rejecting
     * the given string based on our whitelist and blacklist.
     */
    'reject' => true,

    /*
     * Replace the value with true to enable full word replacement.
     *
     * If needing to filter multiple separate words, enable this as true.
     *
     * If needing to filter single words, such as usernames, set this as false.
     */
    'replaceFullWords' => true,

    /* 
     * Replace bad words with this, based on length of word
     */
    'replaceWith' => '*',

    /*
     *  Replace related letters
     */
    'strReplace' => [
            'a' => '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)',
            'b' => '(b|b\.|b\-|8|\|3|ß|Β|β)',
            'c' => '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)',
            'd' => '(d|d\.|d\-|&part;|\|\)|Þ|þ|Ð|ð)',
            'e' => '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑)',
            'f' => '(f|f\.|f\-|ƒ)',
            'g' => '(g|g\.|g\-|6|9)',
            'h' => '(h|h\.|h\-|Η)',
            'i' => '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)',
            'j' => '(j|j\.|j\-)',
            'k' => '(k|k\.|k\-|Κ|κ)',
            'l' => '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)',
            'm' => '(m|m\.|m\-)',
            'n' => '(n|n\.|n\-|η|Ν|Π)',
            'o' => '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø)',
            'p' => '(p|p\.|p\-|ρ|Ρ|¶|þ)',
            'q' => '(q|q\.|q\-)',
            'r' => '(r|r\.|r\-|®)',
            's' => '(s|s\.|s\-|5|\$|§)',
            't' => '(t|t\.|t\-|Τ|τ)',
            'u' => '(u|u\.|u\-|υ|µ)',
            'v' => '(v|v\.|v\-|υ|ν)',
            'w' => '(w|w\.|w\-|ω|ψ|Ψ)',
            'x' => '(x|x\.|x\-|Χ|χ)',
            'y' => '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)',
            'z' => '(z|z\.|z\-|Ζ)',
    ]
];
