<?php
class RoleCallTests extends PHPUnit_Framework_TestCase
{
    protected $webDriver;
    protected $url = 'http://localhost/vrc';
    public function setUp(){
        $capabilities = array(\Facebook\WebDriver\Remote\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = \Facebook\WebDriver\Remote\RemoteWebDriver::create('http://localhost:4444/wd/hub',$capabilities);
    }
    public function testAdminLandingPage(){
        $this->webDriver->get($this->url);
        $usernameBox = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("username"));
        $passwordInput = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("password"));
        $usernameBox->click();
        $this->webDriver->getKeyboard()->sendKeys('Frank');
        $this->webDriver->wait(1);
        $passwordInput->click();
        $this->webDriver->getKeyboard()->sendKeys('frank');
        $submit = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id('submit'));
        $submit->click();
        $this->assertContains("Admin Page",$this->webDriver->getTitle());
    }
    public function testSupervisorLandingPage(){
        $this->webDriver->get($this->url);
        $usernameBox = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("username"));
        $passwordInput = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("password"));
        $usernameBox->click();
        $this->webDriver->getKeyboard()->sendKeys('Jason');
        $this->webDriver->wait(1);
        $passwordInput->click();
        $this->webDriver->getKeyboard()->sendKeys('jason');
        $submit = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id('submit'));
        $submit->click();
        $this->assertContains("Supervisor Page",$this->webDriver->getTitle());
    }
    public function testOfficerLandingPage(){
        $this->webDriver->get($this->url);
        $usernameBox = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("username"));
        $passwordInput = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id("password"));
        $usernameBox->click();
        $this->webDriver->getKeyboard()->sendKeys('Peter');
        $this->webDriver->wait(1);
        $passwordInput->click();
        $this->webDriver->getKeyboard()->sendKeys('peter');
        $submit = $this->webDriver->findElement(\Facebook\WebDriver\WebDriverBy::id('submit'));
        $submit->click();
        $this->assertContains("Officer Home Page",$this->webDriver->getTitle());
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
}
?>