<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Nelmio\Alice\Loader\Yaml as YamlLoader;
use PHPUnit_Framework_Assert as PHPUnit;
use Scato\Serializer\SerializerFactory;
use Symfony\Component\Yaml\Yaml as YamlParser;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var object
     */
    private $object;

    /**
     * @var string
     */
    private $string;

    /**
     * @var string
     */
    private $format;

    /**
     * @var mixed
     */
    private $data;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have an object
     */
    public function iHaveAnObject()
    {
        $loader = new YamlLoader();
        $loader->load(__DIR__ . '/Fixtures/person.yml');

        $this->object = $loader->getReference('person');
    }

    /**
     * @When I serialize it to :format
     */
    public function iSerializeItTo($format)
    {
        $factory = new SerializerFactory();
        $method = 'create' . ucfirst($format) . 'Serializer';

        $this->format = $format;
        $this->string = $factory->$method()->serialize($this->object);
    }

    /**
     * @Then I should have the corresponding string
     */
    public function iShouldHaveTheCorrespondingString()
    {
        $filename = __DIR__ . '/Fixtures/person.' . strtolower($this->format);

        if (in_array(strtolower($this->format), array('json', 'xml'))) {
            $method = "assert" . ucfirst($this->format) . "StringEquals" . ucfirst($this->format) . "File";

            PHPUnit::$method($filename, $this->string);
        } else {
            PHPUnit::assertEquals(trim(file_get_contents($filename)), $this->string);
        }
    }

    /**
     * @Given I have a :format string
     */
    public function iHaveAString($format)
    {
        $this->format = $format;
        $this->string = trim(file_get_contents(__DIR__ . '/Fixtures/person.' . strtolower($format)));
    }

    /**
     * @When I deserialize it
     */
    public function iDeserializeIt()
    {
        $factory = new SerializerFactory();
        $method = 'create' . ucfirst($this->format) . 'Deserializer';
        $class = 'Fixtures\Person';

        $this->object = $factory->$method()->deserialize($this->string, $class);
    }

    /**
     * @Then I should have the corresponding object
     */
    public function iShouldHaveTheCorrespondingObject()
    {
        $loader = new YamlLoader();
        $loader->load(__DIR__ . '/Fixtures/person.yml');

        $object = $loader->getReference('person');

        PHPUnit::assertEquals($object, $this->object);
    }

    /**
     * @Given I have an array
     */
    public function iHaveAnArray()
    {
        $parser = new YamlParser();
        $data = $parser->parse(file_get_contents(__DIR__ . '/Fixtures/person.yml'));

        $this->data = $data['Fixtures\Person']['person'];
        $this->data['address'] = $data['Fixtures\Address']['address'];
        $this->data['phoneNumbers'] = array(
            $data['Fixtures\PhoneNumber']['home'],
            $data['Fixtures\PhoneNumber']['mobile']
        );
    }

    /**
     * @When I map it to :type
     */
    public function iMapItTo($type)
    {
        $factory = new SerializerFactory();

        $this->object = $factory->createMapper()->map($this->data, $type);
    }
}
