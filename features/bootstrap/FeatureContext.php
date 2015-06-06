<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Nelmio\Alice\Loader\Yaml;
use PHPUnit_Framework_Assert as PHPUnit;
use Scato\Serializer\SerializerFactory;

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
        $loader = new Yaml();
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
        $method = "assert" . ucfirst($this->format) . "StringEquals" . ucfirst($this->format) . "File";
        $filename = __DIR__ . '/Fixtures/person.' . strtolower($this->format);

        PHPUnit::$method($filename, $this->string);
    }

    /**
     * @Given I have a :format string
     */
    public function iHaveAString($format)
    {
        $this->format = $format;
        $this->string = file_get_contents(__DIR__ . '/Fixtures/person.' . strtolower($format));
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
        $loader = new Yaml();
        $loader->load(__DIR__ . '/Fixtures/person.yml');

        $object = $loader->getReference('person');

        PHPUnit::assertEquals($object, $this->object);
    }
}
