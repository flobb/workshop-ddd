@user
Feature:
    As a client i should be able to call the user api

    Background:
        Given the user table is empty

    @post
    Scenario: I should be able to create a user
        Given I add "Content-Type" header equal to "application/json"
        When I send a "POST" request to "/api/users" with body:
        """
        {
            "email": "email@ddd-test.com",
            "password": "mypassword"
        }
        """
        Then the response status code should be 201
        And the header "Location" should match "#/api/users/[0-9a-z\-]*#"

    Scenario: I should be able to read a user
        Given I add a user with the userid "761586b8-e723-4efb-8e0d-c4af0dbef54c" and email "email@ddd-test.com"
        And I add "Content-Type" header equal to "application/json"
        When I send a "GET" request to "/api/users/761586b8-e723-4efb-8e0d-c4af0dbef54c"
        Then the response status code should be 200
        And the JSON node "email" should be equal to "email@ddd-test.com"
