Feature: JSON Serializer
  In order to send object over a network, using JSON
  As a developer
  I need a serializer to convert objects to JSON and vice versa

  Scenario: Serializing a DTO to JSON
    Given I have a DTO
    When I serialize it to JSON
    Then I should have the corresponding string

  Scenario: Deserializing a DTO from JSON
    Given I have a JSON string
    When I deserialize it
    Then I should have the corresponding DTO

