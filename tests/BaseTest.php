<?php

class BaseTest extends \PHPUnit\Framework\TestCase
{

    public function testInput()
    {
        $input = form()->input('first_name', 'John Doe');

        $this->assertEquals('<input type="text" name="first_name" id="first_name" value="John Doe">',
            $input->render());
    }

    public function testAttributes()
    {
        $input = form()->input('first_name', 'John Doe')
                    ->placeholder('Enter your name');

        $this->assertEquals('<input type="text" name="first_name" id="first_name" value="John Doe" placeholder="Enter your name">',
            $input->render());

        $input = form()->input('first_name', 'John Doe')
            ->required();

        $this->assertEquals('<input type="text" name="first_name" id="first_name" value="John Doe" required>',
            $input->render());

        $input = form()->input('year', 2026)
            ->type('number');

        $this->assertEquals('<input type="number" name="year" id="year" value="2026">',
            $input->render());

        $inputWithClasses1 = form()->input('first_name', 'John Doe')
            ->class('form-control test-input');
        $inputWithClasses2 = form()->input('first_name', 'John Doe')
            ->class('form-control', 'test-input');
        $inputWithClasses3 = form()->input('first_name', 'John Doe')
            ->class(['form-control', 'test-input' => true]);

        $expected = '<input type="text" name="first_name" id="first_name" value="John Doe" class="form-control test-input">';

        $this->assertEquals($expected, $inputWithClasses1->render());
        $this->assertEquals($expected, $inputWithClasses2->render());
        $this->assertEquals($expected, $inputWithClasses3->render());
    }

}