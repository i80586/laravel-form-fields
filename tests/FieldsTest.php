<?php

declare(strict_types=1);

class FieldsTest extends \PHPUnit\Framework\TestCase
{

    public function testInputField()
    {
        $this->assertEquals(
            '<label for="first_name">First_name</label><input type="text" name="first_name" id="first_name" value="" class="form-control">',
            html()->input('first_name')
        );

        $this->assertEquals(
            '<label for="first_name">First_name</label><input type="text" name="first_name" id="first_name" value="John Doe" class="form-control">',
            html()->input('first_name', 'John Doe')
        );

        $this->assertEquals(
            '<label for="first_name">First_name</label><input type="text" name="first_name" id="first_name" value="John Doe" class="form-control">',
            html()->input('first_name', 'John Doe')
        );

        $this->assertEquals(
            '<label for="first_name">First_name</label><input type="text" name="first_name" id="first_name" value="John Doe" class="form-control">',
            html()->input('first_name', 'John Doe')
        );
    }

    public function testInputFieldWithoutLabel()
    {
        $this->assertEquals(
            '<input type="text" name="first_name" id="first_name" value="" class="form-control">',
            html()->input('first_name', null, ['label' => false])
        );
    }

}