<?php

class BaseTest extends \PHPUnit\Framework\TestCase
{

    public function testTagGeneration()
    {
        $input = form()->input('first_name', 'John Doe')
            ->placeholder('Enter price')
            ->required(true);

        $this->assertEquals('<input name="first_name" value="John Doe" placeholder="Enter price" required>',
            $input->render());
    }

}