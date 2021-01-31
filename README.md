## Routes

- "POST" --> '/teams'
	- Create a new team
- "Get" --> '/teams'
	- Display all teams
- "GET" --> '/rankings'
	- Display rankings

For a quick start you can import the routes collection on postman from the json file [here](https://github.com/abdohadi/teamsAPI/blob/main/teamsAPI.postman_collection.json).

You can test with tokens with any grant type but not with the Client Credentials Grant

## Available Scopes

- There are two scopes:
	- "manage-team" scope: using this scope, you can create a team, view all teams and their rankings.
	- "create-match" scope: to create a new match. 

## Installation

`composer install`
`npm install && npm run dev`
`php artisan migrate`
`php artisan passport:install`
`php artisan serve`
