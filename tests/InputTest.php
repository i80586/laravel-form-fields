<?php

class InputTest extends \PHPUnit\Framework\TestCase
{

    public function testInput()
    {
        $input = form()->input('first_name', 'John Doe')->label(false);

        $this->assertEquals('<input type="text" name="first_name" id="first_name" class="form-control" value="John Doe">',
            $input->render());
    }

    public function testWithoutClass()
    {
        $input = form()->input('first_name', 'John Doe')->class(false)->label(false);

        $this->assertEquals('<input type="text" name="first_name" id="first_name" value="John Doe">',
            $input->render());
    }

    public function testAttributes()
    {
        $input = form()->input('first_name', 'John Doe')
                    ->placeholder('Enter your name');

        $this->assertEquals('<label for="first_name">First name</label><input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter your name" value="John Doe">',
            $input->render());

        $input = form()->input('first_name', 'John Doe')
            ->required();

        $this->assertEquals('<label for="first_name">First name</label><input type="text" name="first_name" id="first_name" class="form-control" value="John Doe" required>',
            $input->render());

        $input = form()->input('year', 2026)
            ->class(false)
            ->type('number');

        $this->assertEquals('<label for="year">Year</label><input type="number" name="year" id="year" value="2026">',
            $input->render());

        $inputWithClasses1 = form()->input('first_name', 'John Doe')
            ->class('form-control test-input');
        $inputWithClasses2 = form()->input('first_name', 'John Doe')
            ->class('form-control', 'test-input');
        $inputWithClasses3 = form()->input('first_name', 'John Doe')
            ->class(['form-control', 'test-input' => true]);

        $expected = '<label for="first_name">First name</label><input type="text" name="first_name" id="first_name" class="form-control test-input" value="John Doe">';

        $this->assertEquals($expected, $inputWithClasses1->render());
        $this->assertEquals($expected, $inputWithClasses2->render());
        $this->assertEquals($expected, $inputWithClasses3->render());
    }

    public function testError(): void
    {
        $input = form()->input('withError', 'John Doe')
            ->required();

        $this->assertEquals('<label for="withError">WithError</label><input type="text" name="withError" id="withError" class="form-control is-invalid" value="John Doe" required>',
            $input->render());
    }

    public function testWithoutValue(): void
    {
        $input = form()->input('no_value')->label(false);

        $this->assertEquals('<input type="text" name="no_value" id="no_value" class="form-control">',
            $input->render());
    }

    public function testWithOldValue(): void
    {
        $input = form()->input('with_old')->label(false);

        $this->assertEquals('<input type="text" name="with_old" id="with_old" class="form-control" value="test_value">',
            $input->render());
    }

    public function testWithoutOldValue(): void
    {
        $input = form()->input('with_old')->withoutOld()->label(false);

        $this->assertEquals('<input type="text" name="with_old" id="with_old" class="form-control">',
            $input->render());
    }

    public function testHint(): void
    {
        $input = form()->input('post[text]')
            ->class(false)
            ->label(false)
            ->withHint()
            ->required();

        $this->assertEquals('<input type="text" name="post[text]" id="post_text" class="is-invalid" required><span class="text-danger">Post text must be specified</span>',
            $input->render());
    }

}