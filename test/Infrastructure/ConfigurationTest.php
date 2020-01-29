<?php

namespace Fradoos\Infrastructure;

class ConfigurationTest extends \PHPUnit\Framework\TestCase
{
    public function testInitAndGetConfiguration()
    {
        Configuration::init(["hello" => "yo"]);

        $this->assertEquals(["hello" => "yo"], Configuration::get());
    }

    public function testInitAndGetConfigurationByKey()
    {
        Configuration::init(["hello" => "yo", "yo" => "test"]);

        $this->assertEquals("test", Configuration::get("yo"));
    }
}