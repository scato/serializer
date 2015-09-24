<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Fixtures\DataSource;
use Fixtures\CustomDateSerializationFilter;
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
     * @Given I have a custom date serialization filter
     */
    public function iHaveACustomDateSerializationFilter()
    {
        $this->filters[] = new CustomDateSerializationFilter();
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
        PHPUnit::assertEquals($this->dataSource->getCustomDateString(), $this->output);
    }
}
