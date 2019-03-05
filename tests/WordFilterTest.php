<?php

namespace JoshuaBedford\LaravelWordFilter\Tests;

use JoshuaBedford\LaravelWordFilter\App\WordFilter;
use JoshuaBedford\LaravelWordFilter\Tests\TestCase;

class WordFilterTest extends TestCase
{
    private $string = 'hi you fucking cunt fuck shit!';
    private $usernamePartial = 'SouthernFuckDuckGinger';
    private $usernamePartialWhitelist = 'Cassandra';

    public function testUsernamePartial()
    {
        \Config::set('word.replaceFullWords', false);
        $this->assertEquals(false, app('wordFilter')->noProhibitedWords($this->usernamePartial));
    }

    public function testUsernamePartialWhitelist()
    {
        \Config::set('word.replaceFullWords', false);
        $this->assertEquals(true, app('wordFilter')->noProhibitedWords($this->usernamePartialWhitelist));
    }

    public function testPartialTextWordFilter()
    {
        \Config::set('word.replaceFullWords', false);
        $this->assertEquals('hi you ****ing **** **** ****!', app('wordFilter')->filter($this->string));
    }

    public function testFullTextWordFilter()
    {
        \Config::set('word.replaceFullWords', true);
        $this->assertEquals('hi you fucking **** **** ****!', app('wordFilter')->filter($this->string));
    }

    public function testMultiCharReplaceWith()
    {
        \Config::set('word.replaceFullWords', true);
        \Config::set('word.replaceWith', '**');
        $this->assertEquals('hi you fucking **** **** ****!', app('wordFilter')->filter($this->string));
    }

    public function testReplaceWith()
    {
        $this->assertEquals('hi you fucking #### #### ####!', app('wordFilter')->replaceWith('#')->filter($this->string));
    }

    public function testReplaceFullWords()
    {
        $this->assertEquals('hi you ****ing **** **** ****!', app('wordFilter')->replaceFullWords(false)->filter($this->string));
    }

    public function testMultipleFiltersWithReset()
    {
        $this->assertEquals('hi you fucking #### #### ####!', app('wordFilter')->replaceWith('#')->filter($this->string));
        $this->assertEquals('hi you ****ing **** **** ****!', app('wordFilter')->reset()->replaceFullWords(false)->filter($this->string));
    }

    public function testEmptyFilter()
    {
        $this->assertEquals(' ', app('wordFilter')->filter(' '));
    }

    public function testFilterDetails()
    {
        $this->assertEquals([
          'orig'     => 'hi you fucking cunt fuck shit!',
          'clean'    => 'hi you ****ing **** **** ****!',
          'hasMatch' => true,
          'matched'  => [
            0 => 'fuck',
            1 => 'shit',
            2 => 'cunt',
            3 => 'fuck',
          ],
        ], app('wordFilter')->replaceFullWords(false)->filter($this->string, true));
    }
}
