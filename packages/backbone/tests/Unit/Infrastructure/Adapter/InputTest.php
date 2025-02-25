<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter;

use Backbone\Infrastructure\Testing\TestCase;

class InputTest extends TestCase
{
    final public function testShouldAuthorize(): void
    {
        $input = $this->make(InputTestStub::class);

        $this->assertTrue($input->authorize());
    }

    final public function testRules(): void
    {
        $input = $this->make(InputTestStub::class);
        $rules = $input->rules();

        $this->assertArrayHasKey('test', $rules);
        $this->assertEquals('sometimes|string', $rules['test']);
    }

    final public function testShouldGetValueFromData(): void
    {
        $data = ['datum' => 'cool'];

        $input = $this->input(class: InputTestStub::class, data: $data);

        $this->assertEquals('cool', $input->value('datum'));
    }

    final public function testShouldGetValueFromParams(): void
    {
        $params = ['param' => 'cool'];

        $input = $this->input(class: InputTestStub::class, params: $params);

        $this->assertEquals('cool', $input->value('param'));
    }

    final public function testShouldCallValueBehindPost(): void
    {
        $input = $this->make(InputTestStub::class, ['values' => ['test' => 'cool']]);
        $this->assertEquals('cool', $input->post('test'));
    }

    final public function testShouldCallValuesBehindPost(): void
    {
        $input = $this->make(InputTestStub::class, ['values' => ['test' => 'cool']]);
        $this->assertEquals(['test' => 'cool'], $input->post());
    }

    final public function testShouldCallValueBehindInput(): void
    {
        $input = $this->make(InputTestStub::class, ['values' => ['test' => 'cool']]);
        $this->assertEquals('cool', $input->input('test'));
    }
}
