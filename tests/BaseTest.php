<?php

class BaseTest extends \PHPUnit\Framework\TestCase
{

    public function testTagGeneration()
    {
        $this->assertEquals('<br>', html()->tag('br'));
        $this->assertEquals('<p></p>', html()->tag('p', ''));
        $this->assertEquals('<p class="test"></p>', html()->tag('p', '', ['class' => 'test']));
        $this->assertEquals(
            '<script src="test.js" async></script>',
            html()->tag('script', '', ['src' => 'test.js', 'async' => true])
        );
    }

}