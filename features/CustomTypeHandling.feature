Feature:
  In order to prevent having to write custom mapping
  As a developer
  I need to be able to customize handling certain types

  Scenario: Serializing a DateTime object to JSON
    Given I have a DateTime object
    And I have a custom date serialization converter
    When I serialize it to JSON
    Then I should have a custom date string

  Scenario: Deserializing a DateTime object from JSON
    Given I have a custom JSON date string
    And I have a custom date deserialization filter
    When I deserialize it
    Then I should have the corresponding DateTime object

  Scenario: Mapping a DateTime object to a string
    Given I have a DateTime object
    And I have a custom date serialization converter
    When I map it to string
    Then I should have a custom date string

  Scenario: Mapping a string to a DateTime object
    Given I have a custom PHP date string
    And I have a custom date deserialization filter
    When I map it to DateTime
    Then I should have the corresponding DateTime object

  Scenario: Mapping an object to an entity
    Given I have an object
    And I have a custom person deserialization filter
    And I have a custom address deserialization filter
    And I have a custom phone number deserialization filter
    When I map it to "\Fixtures\Model\Person"
    Then I should have the corresponding entity

  Scenario: Mapping an entity to an object
    Given I have an entity
    And I have a custom person serialization converter
    And I have a custom address serialization converter
    And I have a custom phone number serialization converter
    When I map it to "\Fixtures\Person"
    Then I should have the corresponding object
