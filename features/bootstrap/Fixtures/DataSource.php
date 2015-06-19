<?php


namespace Fixtures;

use Nelmio\Alice\Loader\Yaml as YamlLoader;
use Symfony\Component\Yaml\Yaml as YamlParser;

class DataSource
{
    /**
     * @return object
     */
    public function getDto()
    {
        $loader = new YamlLoader();
        $loader->load($this->getFilename('YML'));

        return $loader->getReference('person');
    }

    /**
     * @param string $format
     * @param string $type
     * @return string
     */
    public function getFilename($format, $type = 'Dto')
    {
        return __DIR__ . '/' . ucfirst(strtolower($type)) . '/person.' . strtolower($format);
    }

    /**
     * @param string $format
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
        $data = $parser->parse(file_get_contents($this->getFilename('YML')));

        $array = $data['Fixtures\Dto\Person']['person'];
        $array['address'] = $data['Fixtures\Dto\Address']['address'];
        $array['phoneNumbers'] = array(
            $data['Fixtures\Dto\PhoneNumber']['home'],
            $data['Fixtures\Dto\PhoneNumber']['mobile']
        );

        return $array;
    }

    public function getEntity()
    {
        $loader = new YamlLoader();
        $loader->load($this->getFilename('YML', 'entity'));

        return $loader->getReference('person');
    }
}
