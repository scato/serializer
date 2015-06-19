<?php


namespace Fixtures;

use Nelmio\Alice\Loader\Yaml as YamlLoader;
use Symfony\Component\Yaml\Yaml as YamlParser;

class DataSource
{
    /**
     * @return object
     */
    public function getObject()
    {
        $loader = new YamlLoader();
        $loader->load(__DIR__ . '/person.yml');

        return $loader->getReference('person');
    }

    /**
     * @param $format
     * @return string
     */
    public function getFilename($format)
    {
        return __DIR__ . '/person.' . strtolower($format);
    }

    /**
     * @param $format
     * @return string
     */
    public function getString($format)
    {
        return trim(file_get_contents($this->getFilename($format)));
    }

    /**
     * @return mixed
     */
    public function getArray()
    {
        $parser = new YamlParser();
        $data = $parser->parse(file_get_contents(__DIR__ . '/person.yml'));

        $array = $data['Fixtures\Person']['person'];
        $array['address'] = $data['Fixtures\Address']['address'];
        $array['phoneNumbers'] = array(
            $data['Fixtures\PhoneNumber']['home'],
            $data['Fixtures\PhoneNumber']['mobile']
        );

        return $array;
    }
}
