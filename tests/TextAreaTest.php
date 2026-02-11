<?php

declare(strict_types=1);

class TextAreaTest extends \PHPUnit\Framework\TestCase
{

    public function testTextArea()
    {
        $textArea = form()->textarea('content', 'Hello World!');

        $this->assertEquals('<label for="content">Content</label><textarea name="content" id="content" class="form-control">Hello World!</textarea>', $textArea->render());
    }

}