Feature: XML Serializer
  In order to send object over a network, using XML
  As a developer
  I need a serializer to convert objects to XML and vice versa

  Scenario: Serializing a DTO to XML
    Given I have a DTO
    When I serialize it to XML
    Then I should have the corresponding string

  Scenario: Deserializing a DTO from XML
    Given I have a XML string
    When I deserialize it
    Then I should have the corresponding DTO

