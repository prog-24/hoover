Hoover Challenge
---

### Requirements
- PHP 7 with Composer installed

### Setup Instructions 
- Browse into the application directory
- Run composer install `This should install all dependencies`


### Testing
- Run `./vendor/phpunit/phpunit/phpunit tests/` from the application directory to run tests.

### Providing Input
Send a `POST` request to the server.  
For example  
`{
   "roomSize" : [5, 5],
   "coords" : [1, 2],
   "patches" : [
     [1, 0],
     [2, 2],
     [2, 3]
   ]
 }`