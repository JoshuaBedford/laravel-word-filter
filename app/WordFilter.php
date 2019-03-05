<?php

namespace JoshuaBedford\LaravelWordFilter;

class WordFilter
{
    protected $replaceWith = '';

    protected $blacklist = [];

    protected $whitelist = [];

    protected $filterChecks = [];

    protected $replaceFullWords = true;

    protected $multiCharReplace = false;

    protected $strReplace = [];

    protected $replaceWithLength;

    protected $config = [];

    protected $filteredStrings = [];

    protected $wasFiltered = false;


    /*
     * Setup
     *
     * First, we need to configure the class.
     *
     * Now that the class is configured, let's setup our blacklist and whitelist.
     *
     * We can now use these lists to start filtering.
     */

    public function __construct($config)
    {
        $this->config = $config;

        $this->strReplace = $this->config['strReplace'];

        $this->reset();

        // Let's grab the blacklist.
        $this->setBlacklist();

        // Let's grab the whitelist.
        $this->setWhitelist();

        // Let's filter based on the lists we created.
        $this->generateFilterChecks();
    }

    /*
     * This function sets the blacklist to an array returned from the database.
     */
    public function setBlacklist()
    {
        $table = $this->config['table_names']['blacklist'];

        $value = \DB::table($table)->select('word')->get()->toArray();

        $this->blacklist = array_map(function ($value) {
            return (array)$value;
        }, $this->blacklist);
        
        // $this->blacklist = [

        //     'anal',
        //     'anus',
        //     'arse',
        //     'ass',
        //     'ballsack',
        //     'balls',
        //     'bastard',
        //     'bitch',
        //     'biatch',
        //     'bloody',
        //     'blowjob',
        //     'bollock',
        //     'bollok',
        //     'boner',
        //     'boob',
        //     'bugger',
        //     'bum',
        //     'butt',
        //     'buttplug',
        //     'clitoris',
        //     'cock',
        //     'coon',
        //     'crap',
        //     'cunt',
        //     'damn',
        //     'dick',
        //     'dildo',
        //     'dyke',
        //     'fag',
        //     'feck',
        //     'fellate',
        //     'fellatio',
        //     'felching',
        //     'fuck',
        //     'fudgepacker',
        //     'flange',
        //     'goddamn',
        //     'hell',
        //     'homo',
        //     'jizz',
        //     'knobend',
        //     'labia',
        //     'muff',
        //     'nigger',
        //     'nigga',
        //     'penis',
        //     'piss',
        //     'poop',
        //     'prick',
        //     'pube',
        //     'pussy',
        //     'queer',
        //     'scrotum',
        //     'sex',
        //     'shit',
        //     'sh1t',
        //     'slut',
        //     'smegma',
        //     'spunk',
        //     'suck',
        //     'tit',
        //     'tosser',
        //     'turd',
        //     'twat',
        //     'vagina',
        //     'wank',
        //     'whore',
        //     'wtf',
        // ];

        return $this;
    }

    /*
     * This function sets the whitelist to an array returned from the database.
     */
    public function setWhitelist()
    {
        $table = $this->config['table_names']['whitelist'];

        $value = \DB::table($table)->select('word')->get()->toArray();

        $this->whitelist = array_map(function ($value) {
            return (array)$value;
        }, $this->whitelist);

        array_map(function ($value) {
    return (array)$value;
}, $result);
        
        // $this->whitelist = [

        //     'Cassandra'

        // ];

        return $this;
    }

    /*
     * Resets the configuration.
     */
    public function reset()
    {
        $this->replaceFullWords($this->config['replaceFullWords']);

        $this->replaceWith($this->config['replaceWith']);

        return $this;
    }

    /*
     * Pulls in a value from the config file and sets this setting.
     */
    public function replaceWith($string)
    {
        $this->replaceWith = $string;

        $this->replaceWithLength = mb_strlen($this->replaceWith);

        $this->multiCharReplace = $this->replaceWithLength === 1;

        return $this;
    }

    /*
     * Pulls in a value from the config file and sets this setting.
     */
    public function replaceFullWords($boolean)
    {
        $this->replaceFullWords = $boolean;

        $this->generateFilterChecks();

        return $this;
    }

    /*
     * Resets the stored values of what has been filtered.
     */
    private function resetFiltered()
    {
        $this->filteredStrings = [];

        $this->wasFiltered = false;
    }

    /*
     * Let's filter the given string.
     */
    public function filter($string, $details = null)
    {
        // Just in case, let's make sure the stored values are reset.
        $this->resetFiltered();

        if (!is_string($string) || !trim($string)) {
            return $string;
        }

        // Let's filter the string and store it temporarily.
        $filtered = $this->filterString($string);

        if ($details) {
            return [
                'orig'     => $string,
                'clean'    => $filtered,
                'hasMatch' => $this->wasFiltered,
                'matched'  => $this->filteredStrings,
            ];
        }

        return $filtered;
    }


    /*
     * If this function is called, false will be returned if anything from
     * the blacklist that is not on the whitelist is found.
     */
    public function noProhibitedWords($string)
    {
        $this->resetFiltered();

        if (!is_string($string) || !trim($string)) {
            return;
        }

        // Let's loop through the blacklist and search for each word.
        foreach ($this->blacklist as $badword) {

            // Let's check to make sure there are no substrings of the word.
            if (stripos($string, $badword) !== false) {

                // We found an occurrance of the bad word, let's make
                // sure its not on the whitelist.
                foreach($this->whitelist as $goodword){
                    if (stripos($string, $goodword) !== false) {
                        return true; // the badword found was whitelisted.
                    }
                }

                return false;
            }
        }

        return true;
    }

    // Here we will perform a regular expression search and replace using a callback.
    // link: http://php.net/manual/en/function.preg-replace-callback.php
    private function filterString($string)
    {
        return preg_replace_callback($this->filterChecks, function ($matches) {
            return $this->replaceWithFilter($matches[0]);
        }, $string);
    }

    private function setFiltered($string)
    {
        array_push($this->filteredStrings, $string);

        if (!$this->wasFiltered) {
            $this->wasFiltered = true;
        }
    }

    private function replaceWithFilter($string)
    {
        $this->setFiltered($string);

        $strlen = mb_strlen($string);

        if ($this->multiCharReplace) {
            return str_repeat($this->replaceWith, $strlen);
        }

        return $this->randomFilterChar($strlen);
    }

    // This sets the filter checks to be used by RegEx.
    private function generateFilterChecks()
    {
        foreach ($this->blacklist as $string) {
            $this->filterChecks[] = $this->getFilterRegexp($string);
        }
    }

    // This determins the RegEx to use when filtering.
    private function getFilterRegexp($string)
    {
        $replaceFilter = $this->replaceFilter($string);

        if ($this->replaceFullWords) {
            return '/\b'.$replaceFilter.'\b/iu';
        }

        return '/'.$replaceFilter.'/iu';
    }

    /*
     * This function returns a string or an array of the letters to replace.
     * It allows us to check using normal characters, which have replaced any of the
     * characters that are set as a match in config['strReplace'];
     * 
     * It takes the given string and replaces all instances of the keys
     * from config['strReplace'] with the values of config['strReplace']
     */
    private function replaceFilter($string)
    {
        return str_ireplace(array_keys($this->strReplace), array_values($this->strReplace), $string);
    }

    private function randomFilterChar($len)
    {
        return str_shuffle(str_repeat($this->replaceWith, intval($len / $this->replaceWithLength)).substr($this->replaceWith, 0, ($len % $this->replaceWithLength)));
    }
}
