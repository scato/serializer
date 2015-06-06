Feature: JSON Serializer
  In order to send object over a network, using JSON
  As a developer
  I need a serializer to convert object to JSON and vice versa

  Scenario: Serializing an object to JSON
    Given I have an object
    When I serialize it to JSON
    Then I should have the corresponding string

  Scenario: Deserializing an object from JSON
    Given I have a JSON string
    When I deserialize it
    Then I should have the corresponding object

