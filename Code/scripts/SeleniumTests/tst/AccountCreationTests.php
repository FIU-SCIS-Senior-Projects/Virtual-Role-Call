<?php
class AccountCreationTests extends PHPUnit_Framework_TestCase
{
    protected $webDriver;
    protected $url = 'http://localhost/vrc';
    public function setUp(){
        $capabilities = array(\Facebook\WebDriver\Remote\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = \Facebook\WebDriver\Remote\RemoteWebDriver::create('http://localhost:4444/wd/hub',$capabilities);
    }
    public function testUserAlreadyExists(){
        $this->webDriver->get($this->url);
        $this->login('Frank','frank');
        $username = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::name('username'));
        $username->click();
        $this->webDriver->getKeyboard()->sendKeys('Frank');


    }
    public function TestUser(){

    }
    public function testSupervisorLandingPage(){

    }
    public function testOfficerLandingPage(){

    }
    public function testInvalidLogin(){
        $this->webDriver->get($this->url);
        $usernameBox = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("username"));
        $passwordInput = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("password"));
        $usernameBox->click();
        $this->webDriver->getKeyboard()->sendKeys('Peter');
        $this->webDriver->wait(1);
        $passwordInput->click();
        $this->webDriver->getKeyboard()->sendKeys('password');
        $submit = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id('submit'));
        $submit->click();
        $this->assertContains("Virtual Role Call",$this->webDriver->getTitle());
        $this->assertContains("Invalid credentials", $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("invalid"))->getAttribute('innerHTML'));
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