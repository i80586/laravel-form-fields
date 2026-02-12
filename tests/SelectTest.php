<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{

    private const array CITIES_LIST = [
        1 => 'New York',
        2 => 'Copenhagen',
        3 => 'Baku',
        4 => 'Washington',
    ];

    private const array OPTION_GROUPS = [
        'Colors' => [
            1 => 'Red',
            2 => 'Blue',
            3 => 'Green',
        ]
    ];

    public function testSelect(): void
    {
        $select = form()->select('city', 3, self::CITIES_LIST, 'Choose city');

        $expected = <<<HTML
<label for="city">City</label>
<select name="city" id="city" class="form-select">
<option value>Choose city</option>
<option value="1">New York</option>
<option value="2">Copenhagen</option>
<option value="3" selected>Baku</option>
<option value="4">Washington</option>
</select>
HTML;

        $this->assertEquals(str_replace("\n", '', $expected),
            $select->render());
    }

    public function testSelectWithoutOld(): void
    {
        $select = form()->select('with_old_select', 3, self::CITIES_LIST, 'Choose city')
            ->label('City')
            ->withoutOld();

        $expected = <<<HTML
<label for="with_old_select">City</label>
<select name="with_old_select" id="with_old_select" class="form-select">
<option value>Choose city</option>
<option value="1">New York</option>
<option value="2">Copenhagen</option>
<option value="3" selected>Baku</option>
<option value="4">Washington</option>
</select>
HTML;

        $this->assertEquals(str_replace("\n", '', $expected),
            $select->render());
    }

    public function testSelectWithMultipleChoices(): void
    {
        $select = form()->select('city', [3, 2], self::CITIES_LIST, 'Choose city');

        $expected = <<<HTML
<label for="city">City</label>
<select name="city" id="city" class="form-select">
<option value>Choose city</option>
<option value="1">New York</option>
<option value="2" selected>Copenhagen</option>
<option value="3" selected>Baku</option>
<option value="4">Washington</option>
</select>
HTML;

        $this->assertEquals(str_replace("\n", '', $expected),
            $select->render());
    }

    public function testOptionGroups(): void
    {
        $select = form()->select('color', 2, self::OPTION_GROUPS, 'Choose color');

        $expected = <<<HTML
<label for="color">Color</label>
<select name="color" id="color" class="form-select">
<option value>Choose color</option>
<optgroup label="Colors">
<option value="1">Red</option>
<option value="2" selected>Blue</option>
<option value="3">Green</option>
</optgroup>
</select>
HTML;

        $this->assertEquals(str_replace("\n", '', $expected),
            $select->render());
    }

}