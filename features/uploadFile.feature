Feature: Upload Files
  In order to add data
  As a customer
  I need to be able to upload csv Files

  Rules:
  - File type should be .csv

  Scenario: Uploading standard CSV Header
    Given there is a "test.csv" file, with headers "name,color" and one row of data
    When I upload the file
    Then I should have a count of 1 in response.
