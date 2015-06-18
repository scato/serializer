Feature: PHP Mapper
  In order to build a DTO layer, without having to write tons of mappers
  As a developer
  I need a mapper to convert data of one type to data of another type

  Scenario: Mapping an array to an object
    Given I have an array
    When I map it to "Fixtures\Person"
    Then I should have the corresponding object
