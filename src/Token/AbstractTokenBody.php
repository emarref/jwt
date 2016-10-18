<?php

namespace Emarref\Jwt\Token;

abstract class AbstractTokenBody implements \JsonSerializable
{
    const OPT_JSON_OPTIONS = 'json_options';

    /**
     * @var PropertyList
     */
    protected $propertyList;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options = $this->parseOptions($options);

        $this->propertyList = new PropertyList($options[self::OPT_JSON_OPTIONS]);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function parseOptions(array $options)
    {
        $defaultOptions = $this->getDefaultOptions();

        return array_merge($defaultOptions, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
            self::OPT_JSON_OPTIONS => null,
        ];
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->propertyList->jsonSerialize();
    }
}
