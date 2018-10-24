### README

#### To install the project:

1. Clone the repository with:

`git clone https://github.com/DailyMatters/symfDiscounts.git`

2. After having the project installed, create the database schema and load the fixtures with:

`cd discounts
./bin/create_database.sh`

The Doctrine prompt will ask you a couple of questions, just answer yes on both of them.

3. To launch the project, use Symfony built in server with:

`php bin/console server:run`

4. From here you can either use Postman to make requests to `http://127.0.0.1:8002/order/discount` (you might have to change the port according to the output off the server:run command). Or, if you're like me and are battling with a striped down version of Linux you can use cUrl for this:

`
curl -i -H "Content-Type: application/json" --request POST -d '	
{
  "id": "1",
  "customer-id": "1",
  "items": [
    {
      "product-id": "B102",
      "quantity": "10", 
      "unit-price": "4.99",
      "total": "49.90"	
    }
  ],
  "total": "49.90"
}' http://127.0.0.1:8000/order/discount
`

--------

5. Use `.bin/phpunit` to run the unit tests.

#### Regarding the project itself an my implementation.

1. It is clearly missing unit testing. I'm pretty conscious of that, I would also like to mention that I haven't implemented them due to time issues, but if you look at other repos of mine you can see that I can do them (ex: https://github.com/DailyMatters/redditSearch)

2. Validation wise, teh implementation is pretty lacking. I did use the Symfony validation package to implement validations through annotations, but those are already being caught, and errors are being triggered by the setter methods through type hinting.

3. The implementation of the discount system is dependant on a main method that trigger all the different discount options. This is a method that works, but is a nightmare to test. Being tightly coupled to the manager method, all the private methods that have the logic for the discounts are practically untestable.
