Feature: JSON Serializer
  In order to send object over a network, using JSON
  As a developer
  I need a serializer to convert objects to JSON and vice versa

  Scenario: Serializing an object to URL encoding
    Given I have an object
    When I serialize it to URL
    Then I should have the corresponding string

  Scenario: Deserializing an object from URL encoding
    Given I have a URL string
    When I deserialize it
    Then I should have the corresponding object

