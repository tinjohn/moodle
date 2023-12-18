@core @core_courseformat
Feature: Single section course page
  In order to improve the course page
  As a user
  I need to be able to see a section in a single page

  Background:
    Given the following "course" exists:
      | fullname         | Course 1 |
      | shortname        | C1       |
      | category         | 0        |
      | numsections      | 3        |
    And the following "activities" exist:
      | activity | name                | course | idnumber | section |
      | assign   | Activity sample 0.1 | C1     | sample1  | 0       |
      | assign   | Activity sample 1.1 | C1     | sample1  | 1       |
      | assign   | Activity sample 1.2 | C1     | sample2  | 1       |
      | assign   | Activity sample 1.3 | C1     | sample3  | 1       |
      | assign   | Activity sample 2.1 | C1     | sample3  | 2       |
      | assign   | Activity sample 2.2 | C1     | sample3  | 2       |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    Given I am on the "C1" "Course" page logged in as "teacher1"

  @javascript
  Scenario: Collapsed sections are always expanded in the single section page
    Given I press "Collapse all"
    And I should not see "Activity sample 1.1" in the "region-main" "region"
    When I click on "Topic 1" "link" in the "region-main" "region"
    Then I should see "Activity sample 1.1"
    And I should see "Activity sample 1.2"
    And I should see "Activity sample 1.3"
    And I should not see "Activity sample 2.1" in the "region-main" "region"
    And I should not see "Activity sample 2.1" in the "region-main" "region"

  Scenario: General section is not displayed in the single section page
    When I click on "Topic 1" "link" in the "region-main" "region"
    Then I should not see "General" in the "region-main" "region"
    And I should not see "Activity sample 0.1" in the "region-main" "region"
    And I should see "Activity sample 1.1"
    And I should see "Activity sample 1.2"
    And I should see "Activity sample 1.3"
    And I should not see "Activity sample 2.1" in the "region-main" "region"
    And I should not see "Activity sample 2.1" in the "region-main" "region"

  @javascript
  Scenario: The view action for sections displays the single section page
    Given I turn editing mode on
    And I open section "1" edit menu
    When I click on "View" "link" in the "Topic 1" "section"
    Then I should not see "General" in the "region-main" "region"
    And I should not see "Activity sample 0.1" in the "region-main" "region"
    And I should see "Activity sample 1.1"
    And I should see "Activity sample 1.2"
    And I should see "Activity sample 1.3"
    And I should not see "Activity sample 2.1" in the "region-main" "region"
    And I should not see "Activity sample 2.1" in the "region-main" "region"
    And I am on "Course 1" course homepage
    And I open section "2" edit menu
    And I click on "View" "link" in the "Topic 2" "section"
    And I should not see "General" in the "region-main" "region"
    And I should not see "Activity sample 0.1" in the "region-main" "region"
    And I should not see "Activity sample 1.1"
    And I should not see "Activity sample 1.2"
    And I should not see "Activity sample 1.3"
    And I should see "Activity sample 2.1" in the "region-main" "region"
    And I should see "Activity sample 2.1" in the "region-main" "region"
    # The following steps will need to be changed in MDL-80248, when the General section will be displayed in isolation.
    But I am on "Course 1" course homepage
    And I open section "0" edit menu
    And I click on "View" "link" in the "General" "section"
    And I should see "General" in the "region-main" "region"
    And I should see "Activity sample 0.1" in the "region-main" "region"
    And I should see "Activity sample 1.1"
    And I should see "Activity sample 1.2"
    And I should see "Activity sample 1.3"
    And I should see "Activity sample 2.1" in the "region-main" "region"
    And I should see "Activity sample 2.1" in the "region-main" "region"
