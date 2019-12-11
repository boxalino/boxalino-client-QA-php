# boxalino-client-QA-php
Boxalino QA(tests, examples) for PHP client SDK https://github.com/boxalino/boxalino-client-SDK-php

The repository is made of :
 - examples  :: code snippets on library integration
 - sample_data :: data used for the export feature
 - phpunit/tests :: unit tests on the library
 
 ## Installation
 Download the repo directly using 
 ``
 git clone git@github.com:boxalino/boxalino-client-QA-php.git
 ``
 or
add the repository as a dependency via composer.json:
``
"require": {
    "boxalino/boxalino-client-qa-php": "dev-master"
  }
``

!! Make sure you have received your credentials (account, password, API key&secret) from Boxalino to access your account (if you don't have them, please contact support@boxalino.com)

## Data Indexing examples

provided in a good order to learn them step by step!

###### backend data basic:
In this example, we take a very simple CSV file with product data, generate the specifications, load them, publish them and push the data to Boxalino Data Intelligence.

###### backend data debug xml:
In this example, we take a very simple CSV file with product data, generate the specifications and print them in xml format.

###### backend data categories:
In this example, we take a very simple CSV file with product and categories data (and the link between them), generate the specifications, load them, publish them and push the data to Boxalino Data Intelligence.

###### backend data split field values:
In this example, we take a very simple CSV file with product data, generate the specifications of a field splitting it's values (field provided as coma separated values in one csv cell), load them, publish them and push the data to Boxalino Data Intelligence.

###### backend data resource:
In this example, we take a very simple CSV file with product data a reference data (and the link between them), generate the specifications, load them, publish them and push the data to Boxalino Data Intelligence.

###### backend data customers:
In this example, we take very simple CSV files with product data and customer data, generate the specifications, load them, publish them and push the data to Boxalino Data Intelligence.

###### backend data transactions:
In this example, we take very simple CSV files with product data, customer data and transactions historical data generate the specifications, load them, publish them and push the data to Boxalino Data Intelligence.


## Batch examples

The batch requests are a convenient way to access your customers profile index in order to retrieve recommendations and content as per your widget design.

###### frontend batch:
In this example, we make a simple batch request to access newsletter recommended products for 3 account IDs.

## Search examples

provided in a good order to learn them step by step!

###### frontend search basic:
In this example, we make a simple search query, get the search results and print their ids including a total counter.

###### frontend search return fields:
In this example, we make a simple search query, defined additional fields to be returned for each reserult, get the search results and print their field values.

###### frontend search 2nd page:
In this example, we make a simple search query, get the second page of search results and print their ids.

###### frontend search sort field:
In this example, we make a simple search query with a special sort order and get the first search results according to this order.

###### frontend search facet:
In this example, we make a simple search query, request a facet and get the search results and print the facet values and counter.

###### frontend search facet category:
In this example, we make a simple search query, request a facet and get the search results and print the facet values and counter of categories.

###### frontend search facet price:
In this example, we make a simple search query, request a facet and get the search results and print the facet values and counter for price ranges.

###### frontend search corrected:
In this example, we make a simple search query with a typo, get the search results and print the corrected query and the search results ids.

###### frontend search sub phrases:
In this example, we make a simple search query containing two keywords which both provides search results alone, but none together. Then we show the two sub-phrases groups to let the user chose to search for one or the other.

###### frontend search filter:
In this example, we make a simple search query, add a filter and get the search results and print their ids.

###### frontend search filter advanced:
In this example, we make a simple search query, add a more advanced filters with 2 fields with values and an or conditions between them and get the search results and print their ids.

###### frontend search debug request:
In this example, we make a simple search query and we print the request object. This is very helpful to understand what could be the cause of a problem. Please always include the printout of this object in your support request to Boxalino.

## Search autocomplete examples

provided in a good order to learn them step by step!

###### frontend search autocomplete basic:
In this example, we make a simple search autocomplete query, get the textual search suggestions.

###### frontend search autocomplete items:
In this example, we make a simple search autocomplete query, get the textual search suggestions and the item suggestions for each textual suggestion and globally.

###### frontend search autocomplete items bundled:
In this example, we make several search autocomplete queries, and for each get the textual search suggestions and the item suggestions for each textual suggestion and globally.

###### frontend search autocomplete property:
In this example, we show how to get autocomplete response on a property (to see what property value start with the query as prefix and how many search result they return if searched)

## Recommendations examples

provided in a good order to learn them step by step!

###### frontend recommendations similar:
In this example, we make a simple recommendation example to display similar recommendations on a product detail page.

###### frontend recommendations similar complementary:
In this example, we make a simple recommendation example to display both similar and complementary recommendations on a product detail page

###### frontend recommendations basket:
In this example, we make a simple recommendation example to display cross selling recommendations on a basket page.

## Contact us!

If you have any question, just contact us at support@boxalino.com