<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Fixtures\DataSource;
use PHPUnit_Framework_Assert as PHPUnit;
use Scato\Serializer\SerializerFactory;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var mixed
     */
    private $input;

    /**
     * @var mixed
     */
    private $output;

    /**
     * @var string
     */
    private $format;

    /**
     * @var DataSource
     */
    private $dataSource;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->dataSource = new DataSource();
    }

    /**
     * @Given I have a DTO
     */
    public function iHaveADto()
    {
        $this->input = $this->dataSource->getDto();
    }

    /**
     * @Given I have a :format string
     */
    public function iHaveAString($format)
    {
        $this->format = $format;
        $this->input = $this->dataSource->getString($format);
    }

    /**
     * @Given I have an array
     */
    public function iHaveAnArray()
    {
        $this->input = $this->dataSource->getArray();
    }

    /**
     * @Given I have an entity
     */
    public function iHaveAnEntity()
    {
        $this->input = $this->dataSource->getEntity();
    }

    /**
     * @When I serialize it to :format
     */
    public function iSerializeItTo($format)
    {
        $factory = new SerializerFactory();
        $method = 'create' . ucfirst(strtolower($format)) . 'Serializer';

        $this->format = $format;
        $this->output = $factory->$method()->serialize($this->input);
    }

    /**
     * @When I deserialize it
     */
    public function iDeserializeIt()
    {
        $factory = new SerializerFactory();
        $method = 'create' . ucfirst(strtolower($this->format)) . 'Deserializer';
        $class = 'Fixtures\DTO\Person';

        $this->output = $factory->$method()->deserialize($this->input, $class);
    }

    /**
     * @When I map it to :type
     */
    public function iMapItTo($type)
    {
        $factory = new SerializerFactory();

        $this->output = $factory->createMapper()->map($this->input, $type);
    }

    /**
     * @Then I should have the corresponding string
     */
    public function iShouldHaveTheCorrespondingString()
    {
        $filename = $this->dataSource->getFilename($this->format);

        if (strtolower($this->format) === 'json') {
            PHPUnit::assertJsonStringEqualsJsonFile($filename, $this->output);
        } elseif (strtolower($this->format) === 'xml') {
            PHPUnit::assertXmlStringEqualsXmlFile($filename, $this->output);
        } else {
            PHPUnit::assertEquals(trim(file_get_contents($filename)), $this->output);
        }
    }

    /**
     * @Then I should have the corresponding DTO
     */
    public function iShouldHaveTheCorrespondingObject()
    {
        PHPUnit::assertEquals($this->dataSource->getDto(), $this->output);
    }

    /**
     * @Then I should have the corresponding array
     */
    public function iShouldHaveTheCorrespondingArray()
    {
        PHPUnit::assertEquals($this->dataSource->getArray(), $this->output);
    }
}
