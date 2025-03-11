# NYTimes Best Sellers API

This project implements a single endpoint around the NYT Best Sellers API. The endpoint supports querying the best sellers list with a subset of the NYT API's query parameters.

## Features

- **Implemented endpoint:** `GET /api/books/best-sellers`
- **Supported Query Parameters:**
  - `author` (string): Filter results by author name.
  - `isbns` (array): Filter results by ISBN numbers.
  - `title` (string): Filter results by book title.
  - `offset` (integer): Offset the list of returned results. Must be zero or multiple of 20

## Documentation

For detailed information about the NYT Best Sellers API, please refer to the official documentation:
[NYT Best Sellers API Documentation](https://developer.nytimes.com/docs/books-product/1/routes/lists/best-sellers/history.json/get)

## Implementation Details

- **Framework:** Laravel 12
- **Data Handling:** Utilizes Spatie's Laravel Data package for data transfer objects.

- **Testing:** Includes feature and unit tests to ensure the endpoint returns the correct structure and data.
- **Code quality:** Installed rector and phpstan to keep code in check.

## Possible improvements

- **Project granulation:** Parts of the project could be more detailed. For example NYT client with abstract class and it's implementation could be made. This would allow to be used with other APIs of NY Times API if anything apart of Books API is to be used. This way `NYTimesBooksApiService` would be more focused on it's own responsibility
- **Error Handling:** Enhance error handling to provide more detailed error messages and troubleshooting information.
- **Caching:** Implement caching to reduce the number of API calls to the NYT API and improve response times.
- **Rate Limiting:** Implement rate limiting on Laravel side to prevent abuse of the API endpoint.
- **Laravel API versioning:** At this moment NY Times API version is defined in `.env` and is matched with proper implementation of the service. But if we were to use simultanously more then one version of the API at the same time (for example FE could use more then one) - it could be done.

## Remarks

- **Parameter names:** Query param `isbns` is used and as an array. It is then converted to imploaded string version as `isbn` when calling NYTimes API.
- **Imploaded version not working:** Noticed that searching by multiple `isbns` does not work as expected. It must be some issue on NY Times Books API. It was double checked in Postman directly in requests to NY Times Books API.

## Getting Started

1. **Clone the repository:**
   ```sh
   git clone https://github.com/kobus-pro/nytimes-books-api.git
   cd nytimes-books-api
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Set up environment variables:**
   Copy the `.env.example` file to `.env` and update the necessary environment variables, including the NYT API key (`NYTIMES_API_KEY`). Generate app key - `php artisan key:generate`.


4. **Run migrations (default db is sqlite):**
   ```sh
   php artisan migrate
   ```

5. **Run the application:**
   ```sh
   php artisan serve
   ```

6. **Run tests:**
   ```sh
   php artisan test
   ```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any improvements or bug fixes.

## License

This example project is licensed under the MIT License.
