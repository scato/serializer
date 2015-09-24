Feature:
  In order to prevent having to write custom mapping
  As a developer
  I need to be able to customize handling certain types

  Scenario: Serializing a DateTime object to JSON
    Given I have a DateTime object
    And I have a custom date serialization filter
    When I serialize it to JSON
    Then I should have a custom date string
