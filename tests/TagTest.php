<?php

declare(strict_types=1);

class TagTest extends \PHPUnit\Framework\TestCase
{

    public function testLink(): void
    {
        $link = form()->link('Go to link', 'http://test.com');

        $this->assertEquals('<a href="http://test.com">Go to link</a>', $link->render());
    }

    public function testNonClosable(): void
    {
        $tag = form()->tag('img')->src('test.png');

        $this->assertEquals('<img src="test.png">', $tag->render());
    }

}