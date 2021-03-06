<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Fixtures\CustomDateDeserializationFilter;
use Fixtures\DataSource;
use Fixtures\CustomDateSerializationConverter;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines steps related to the data source
 */
class DataSourceContext extends SerializerContext implements SnippetAcceptingContext
{
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
     * @Given I have an object
     */
    public function iHaveAnObject()
    {
        $this->input = $this->dataSource->getObject();
    }

    /**
     * @Given I have a :format string
     */
    public function iHaveAString($format)
    {
        $this->format = $format;
        $this->class = 'Fixtures\Person';
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
     * @Given I have a DateTime object
     */
    public function iHaveADateTimeObject()
    {
        $this->input = $this->dataSource->getDateTime();
    }

    /**
     * @Given I have a custom :format date string
     */
    public function iHaveACustomJSONDateString($format)
    {
        $this->format = $format;
        $this->class = 'DateTime';
        $this->input = $this->dataSource->getCustomDateString($format);
    }

    /**
     * @Given I have a custom date serialization converter
     */
    public function iHaveACustomDateSerializationFilter()
    {
        $this->converters[] = new CustomDateSerializationConverter();
    }

    /**
     * @Given I have a custom date deserialization filter
     */
    public function iHaveACustomDateDeserializationFilter()
    {
        $this->filters[] = new CustomDateDeserializationFilter();
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
     * @Then I should have the corresponding object
     */
    public function iShouldHaveTheCorrespondingObject()
    {
        PHPUnit::assertEquals($this->dataSource->getObject(), $this->output);
    }

    /**
     * @Then I should have the corresponding array
     */
    public function iShouldHaveTheCorrespondingArray()
    {
        PHPUnit::assertEquals($this->dataSource->getArray(), $this->output);
    }

    /**
     * @Then I should have a custom date string
     */
    public function iShouldHaveACustomDateString()
    {
        PHPUnit::assertEquals($this->dataSource->getCustomDateString($this->format), $this->output);
    }

    /**
     * @Then I should have the corresponding DateTime object
     */
    public function iShouldHaveTheCorrespondingDateTimeObject()
    {
        PHPUnit::assertEquals($this->dataSource->getDateTime(), $this->output);
    }
}
