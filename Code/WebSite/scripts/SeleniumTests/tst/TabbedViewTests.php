<?php
class AccountCreationTests extends PHPUnit_Framework_TestCase
{
    protected $webDriver;
    protected $url  = 'http://localhost/vrc';
    public function setUp(){
         $capabilities= array(\Facebook\WebDriver\Remote\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
         $this->webDriver = \Facebook\WebDriver\Remote\RemoteWebDriver::create('http://localhost:4444/wd/hub',$capabilities);
    }

    public function tearDown(){
        $this->webDriver->quit();
    }
    public function login($uname,$pass){
        $this->webDriver->get($this->url);
        $usernameBox = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("username"));
        $passwordInput = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("password"));
        $usernameBox->click();
        $this->webDriver->getKeyboard()->sendKeys($uname);
        $this->webDriver->wait(1);
        $passwordInput->click();
        $this->webDriver->getKeyboard()->sendKeys($pass);
        $submit = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id('submit'));
        $submit->click();
    }
}