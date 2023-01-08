Feature: Jobs API

  Scenario: As a user I would like to get all jobs
    When I request "/jobs"
    Then the response code is 200
    And the response body is a JSON array of length 40

  Scenario: As a user I would like to get Collection jobs for Fox Pubs Ltd where number of items is less or greater than 10
    Given the following query parameters are set:
    | filters[customer][eq]        | Fox Pubs Ltd |
    | filters[number_of_items][eq] | 10           |
    When I request "/jobs"
    Then the response code is 200
    And the response body is a JSON array of length 3
    And the response body contains JSON:
    """
    [
        {
            "jobId": "@variableType(string)",
            "jobType": "Collection",
            "customer": {
                "customerId": "@variableType(string)",
                "name": "Fox Pubs Ltd"
            },
            "site": {
                "siteId": "@variableType(string)",
                "name": "The Old Fox"
            },
            "dueBy": "2022-06-05T09:00:00+00:00",
            "completedAt": "2022-06-05T08:41:00+00:00",
            "late": false,
            "flagged": false,
            "numberOfItems": 10
        },
        {
            "jobId": "@variableType(string)",
            "jobType": "Collection",
            "customer": {
                "customerId": "@variableType(string)",
                "name": "Fox Pubs Ltd"
            },
            "site": {
                "siteId": "@variableType(string)",
                "name": "The Old Fox"
            },
            "dueBy": "2022-06-11T09:00:00+00:00",
            "completedAt": "2022-06-11T09:41:00+00:00",
            "late": true,
            "flagged": true,
            "numberOfItems": 10
        },
        {
            "jobId": "@variableType(string)",
            "jobType": "Collection",
            "customer": {
                "customerId": "@variableType(string)",
                "name": "Fox Pubs Ltd"
            },
            "site": {
                "siteId": "@variableType(string)",
                "name": "The Old Fox"
            },
            "dueBy": "2022-06-18T09:00:00+00:00",
            "completedAt": "2022-06-18T08:34:00+00:00",
            "late": false,
            "flagged": false,
            "numberOfItems": 10
        }
    ]
    """