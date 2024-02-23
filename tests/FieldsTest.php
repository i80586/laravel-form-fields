<?php

declare(strict_types=1);

class FieldsTest extends \PHPUnit\Framework\TestCase
{

    public function testInputField()
    {
        $this->assertEquals(
            '<label for="first_name">First_name</label><input type="text" name="first_name" id="first_name" class="form-control">',
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
            html()->input('first_name', '', ['label' => false])
        );
    }

    public function testInputWithError()
    {
        $this->assertEquals(
            '<label for="withError">WithError</label><input type="text" name="withError" id="withError" value="Test" class="form-control is-invalid">',
            html()->input('withError', 'Test')
        );
    }

    public function testInputWithErrorLabel()
    {
        $this->assertEquals(
            '<label for="withError">WithError</label>' .
            '<input type="text" name="withError" id="withError" value="Test" class="form-control is-invalid">' .
            '<span class="text-danger">Invalid value</span>',
            html()->input('withError', 'Test', ['errorLabel' => 'Invalid value'])
        );
    }

    public function testNestedNameWithError()
    {
        $this->assertEquals(
            <<<HTML
<label for="post[text]">Post text</label><textarea name="post[text]" id="post[text]" class="form-control is-invalid">Test textarea</textarea>
HTML,
            html()->textarea('post[text]', 'Test textarea', ['label' => 'Post text'])
        );
    }

    public function testDropdownField()
    {
        $this->assertEquals(
            <<<HTML
<select name="list" id="list"><option value="">-</option><option value="active">Active</option><option value="inactive" selected>InActive</option></select>
HTML,
            html()->dropDown('list', 'inactive',
                array_combine(['active', 'inactive'], ['Active', 'InActive']),
                ['label' => false, 'class' => false, 'prompt' => '-'],
            )
        );
    }

    public function testFileInput()
    {
        $this->assertEquals(
            '<label for="image">Image</label>' .
            '<input type="file" name="image" id="image" class="form-control" accept=".jpg,.png">',
            html()->input('image', null, ['accept' => '.jpg,.png'], 'file')
        );
    }

}