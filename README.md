# Basic PHP and Symfony 4.4 interview

Dear candidate, please follow this README and solve all questions.

**This test requires:**
- access to the internet
- an php capable IDE (we suggest PhpStorm with symfony, yaml, twig and php annotations plugin)
- working setup of PHP 7.2+ *(https://symfony.com/doc/4.4/setup.html)*
- composer *(https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)*
- MySQL
- Apache or alternative web server

*Tip: Clone the test repository and make sure its working.*
Access the project with your favourite browser. You should see similar welcome screen. **Dont forget to run composer install.**
![Symfony welcome screen](https://raw.githubusercontent.com/FELDSAM-INC/basic-symfony44-interview-test/master/symfony_screenshot.png)

**Good luck!**


--------


## Test tasks:

1. Change the text on symfony homepage from `Welcome to Symfony 4.4.2` to `This is a test`

1. Run the PhpUnit test. Check if there are any errors, if so fix them.

1. Create a method `hello` under `src\Controller\DefaultController`
   - for route `/hello`
   - with a proper json return `{"hello":"world!"}`

1. Create a new Bundle `NeoBundle` within the namespace `App\Neo`

1. Use the **api.nasa.gov**
   - the API-KEY is `0PwUQG3UbV278anbQuKzGOFpUKWuU2aQC8vFsXcE`
   - documentation: https://api.nasa.gov/neo/?api_key=0PwUQG3UbV278anbQuKzGOFpUKWuU2aQC8vFsXcE
  
1. Write a command `neo:fetch` that should accept 1 option `--since -s` with default `3 days`
   - to request the data `since` requested time from nasa api
   - response contains count of Near-Earth Objects (NEOs)
   - persist the values in DB
   - Define the Doctrine model as follows:
     - date
     - reference (neo_reference_id)
     - name
     - speed (kilometers_per_hour)
     - is hazardous (is_potentially_hazardous_asteroid)

1. Create a route `/neo/hazardous`
   - display all DB entries which contain potentially hazardous asteroids
   - format JSON

1. Create a route `/neo/fastest/{hazardous}`
   - analyze all data
   - calculate and return the model of the fastest asteroid
   - with a optional `hazardous` route parameter, when included means `is hazardous`
   - default hazardous value is `false`
   - format JSON

1. Create a route `/neo/best-year/{hazardous}`
   - analyze all data
   - calculate and return a year with most asteroids
   - with a optional `hazardous` route parameter, when included means `is hazardous`
   - default hazardous value is `false`
   - format JSON

1. Create a route `/neo/best-month/{hazardous}`
   - analyze all data
   - calculate and return a month with most asteroids (not a month in a year)
   - with a optional `hazardous` route parameter, when included means `is hazardous`
   - default hazardous value is `false`
   - format JSON

## Bonus tasks

1. write a prompt for the command `neo:fetch`
   - Prompt text is `This is a test. Do you want to continue (y/N) ?`
   - If you decline, return error `Nothing done. Exiting...`
   - If you accept, run the command
   
1. add `--non-interactive -ni` option to the command `neo:fetch` so prompt can be skipped
   
1. dockerize application
   - use docker-compose
   - define cron job which fetch neo data every day (you can use [funkyfuture/deck-chores](https://hub.docker.com/r/funkyfuture/deck-chores/))
   
## Additional Instructions

- Tests are not optional
- After you're done, provide us the link to your repository.
- Leave comments where you were not sure how to properly proceed.
- Implementations without a README will be automatically rejected.

# That's it!

**Thank you for your participation! Good luck submitting your results!**


# My comments

## Task 3
I used annotation for routes, since that was default configuration in project. 
On bigger projects I prefer to use YAML for better and easier organization

## note
I added maker bundle and use annotation for models.
I decoupled logic so there is service for fetching data from api,
and service for managing and saving data to the database. If data exist in db, it will not
be persisted.

I complete one bonus task.

Also I added `/neo/best-month-without-year/{hazardous}` because I was unsure about specification, so I added both cases with year and without year

# instructions

1. clone repository
2. run composer install
3. setup access to database
4. setup access to the db and run `do:da:cr`
4. run `do:sc:cr`
5 run `neo:fetch`
6. navigate throught the routes