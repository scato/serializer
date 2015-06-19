Feature: Data Mapper
  In order to build a DTO layer, without having to write tons of mappers
  As a developer
  I need a mapper to convert data of one type to data of another type

  Scenario: Mapping an array to a DTO
    Given I have an array
    When I map it to "Fixtures\Dto\Person"
    Then I should have the corresponding DTO

  Scenario: Mapping a DTO to an array
    Given I have a DTO
    When I map it to "array"
    Then I should have the corresponding array

  Scenario: Mapping an entity to a DTO
    Given I have an entity
    When I map it to "Fixtures\Dto\Person"
    Then I should have the corresponding DTO
