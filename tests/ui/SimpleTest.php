<?php
use PHPUnit\Framework\TestCase;
use Browser\Casper;

class SimpleTest extends TestCase
{

    public function testPageContent()
    {

        $casper = new Casper();

        $screenshotFileName = "startpage-" . date('Y-m-d-H-i-s') . ".png";

        $casper->setViewPort(800, 600)
               ->start('http://internetdagarna.dev')
               ->waitForText('Internetdagarna')
               ->capturePage("tests/ui/.reports/{$screenshotFileName}")
               ->run();

        $result = $casper->getOutput();

        $this->assertContains("found text \"Internetdagarna\"", $result);

    }

}