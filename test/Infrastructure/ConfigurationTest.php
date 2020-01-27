<?php

namespace Fradoos\Infrastructure;

class ConfigurationTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialiserAndGet()
    {
        Configuration::init(["hello" => "yo"]);

        $this->assertEquals(["hello" => "yo"], Configuration::get());
    }

    public function testInitialiserAndGetParCle()
    {
        Configuration::init(["hello" => "yo", "yo" => "test"]);

        $this->assertEquals("test", Configuration::get("yo"));
    }
}