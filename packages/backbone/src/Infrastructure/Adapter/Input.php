<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter;

use Backbone\Domain\Support\Values;
use Hyperf\Context\Context;
use Hyperf\Validation\Request\FormRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

use function Hyperf\Collection\data_get;

/**
 * @see https://hyperf.wiki/3.1/#/en/validation?id=form-request-validation
 */
abstract class Input extends FormRequest
{
    private readonly Values $values;

    public function __construct(
        ContainerInterface $container,
        array $values = [],
    ) {
        parent::__construct($container);

        $this->values = Values::createFrom($values);
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @deprecated Use `value(string $key, mixed $default = null): mixed` instead
     */
    final public function input(string $key, mixed $default = null): mixed
    {
        return $this->value($key, $default);
    }

    /**
     * @deprecated Use `value(string $key, mixed $default = null): mixed` instead
     */
    public function post(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->values()->toArray();
        }
        return $this->value($key, $default);
    }

    /**
     * @template T of mixed
     * @param T $default
     *
     * @return T
     */
    final public function value(string $key, mixed $default = null): mixed
    {
        return data_get($this->values()->toArray(), $key, $default);
    }

    /**
     * @SuppressWarnings(StaticAccess)
     * @return Values
     */
    final public function values(): Values
    {
        if (Context::has(ServerRequestInterface::class)) {
            return $this->values->along($this->validated());
        }
        return $this->values;
    }

    protected function validationData(): array
    {
        $data = parent::validationData();
        $params = $this->extractParams($data);
        return array_merge($data, $params);
    }

    private function extractParams(array $data): array
    {
        $keys = array_keys($this->rules());
        $params = [];
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                continue;
            }
            $param = $this->route($key);
            if ($param) {
                $params[$key] = $param;
            }
        }
        return $params;
    }
}
