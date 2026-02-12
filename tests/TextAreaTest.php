<?php

declare(strict_types=1);

class TextAreaTest extends \PHPUnit\Framework\TestCase
{

    public function testTextArea()
    {
        $textArea = form()->textarea('content', 'Hello World!');

        $this->assertEquals('<label for="content">Content</label><textarea name="content" id="content" class="form-control">Hello World!</textarea>', $textArea->render());
    }

    public function testTextAreaWithOld()
    {
        $textArea = form()->textarea('with_old', 'Hello World!')->label('Content');

        $this->assertEquals('<label for="with_old">Content</label><textarea name="with_old" id="with_old" class="form-control">test_value</textarea>', $textArea->render());
    }

    public function testTextAreaWithoutOld()
    {
        $textArea = form()->textarea('with_old', 'Hello World!')
            ->withoutOld()
            ->label('Content');

        $this->assertEquals('<label for="with_old">Content</label><textarea name="with_old" id="with_old" class="form-control">Hello World!</textarea>', $textArea->render());
    }

}