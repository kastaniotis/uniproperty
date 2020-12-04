Feature:
  In order to be able to access properties of unknown objects by name
  As a developer
  I need a library that can check for the existence of public properties, or private ones with getter/setters

  Scenario: Get the value of a property in an unknown object by name
    Given a Post with a parameter status that has a value draft
    When I try to get the value for the parameter
    And when I try to get the value of a wrong one
    Then I get draft for the parameter
    And an exception for the wrong one

  Scenario: Check if an unknown object has a property by name
    Given a Post with a parameter status that has a value draft
    When I check for the existence of the property
    And I check for the existence on a wrong property
    Then I get true for the existing property
    And I get false for the wrong property

  Scenario: Set the value of a property in an unknown object
    Given a Post with a parameter status that has a value draft
    When I try to change the status to published
    And when I try to change a wrong parameter to published
    Then when I get the status value it is published
    And I get an exception for the wrong one