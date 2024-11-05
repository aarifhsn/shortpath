# ShortPath

**RESTful API for a URL shortener service**.

## Table of Contents

-   [Installation](#installation)
-   [Documentation](#documentation)
-   [Usage](#usage)
-   [Configuration](#configuration)
-   [License](#license)

---

## Installation

1. **Clone the repository**:

    ```bash
    git clone https://github.com/aarifhsn/shortpath.git
    ```

2. **Install dependencies**:
   Make sure you have [Composer](https://getcomposer.org/) installed. Then run:

    ```bash
    composer install
    ```

3. **Environment setup**:
   Copy the `.env.example` to create your `.env` file:

    ```bash
    cp .env.example .env
    ```

    Configure your `.env` file with your database and other required settings.

4. **Generate application key** (for Laravel):

    ```bash
    php artisan key:generate
    ```

5. **Run migrations**:
    ```bash
    php artisan migrate
    ```

---

## Documentation

This project uses [Dedoc Scramble](https://github.com/dedoc/scramble) for automatic documentation generation. Dedoc Scramble allows you to generate API documentation directly from your code annotations.

### Generating Documentation

1. **Install Dedoc Scramble**:
   If Dedoc Scramble isn’t installed yet, you can add it via Composer:
    ```bash
    composer require dedoc/scramble --dev
    ```
2. **Generate the Documentation: Run the following command to create or update the documentation**:

    ```bash
    php artisan docs:generate
    ```

    This command will analyze your codebase and generate an API documentation file located at storage/api-docs by default.

3. **View the Documentation: Serve your documentation for testing:**
    ```bash
    php artisan serve
    ```
    Access it at http://localhost:8000/docs (or the path you configured in Dedoc Scramble).

**Customizing Documentation**
You can adjust the configuration of Dedoc Scramble in the scramble.php configuration file for custom endpoints, models, or descriptions.

## API Documentation

### Authentication Endpoints

**Register**

-   URL: /api/v1/register or /api/v2/register
-   Method: POST
-   Description: Register a new user.
-   Request Body

    ```bash
    {
        "name": "string",
        "email": "string",
        "password": "string",
        "password_confirmation": "string"
    }
    ```

    **Response**:

*   201 Created: Registration successful.
*   400 Bad Request: Validation error.

**Login**

-   URL: /api/v1/login or /api/v2/login
-   Method: POST
-   Description: Authenticate an existing user.
-   Request Body

    ```bash
    {
        "email": "string",
        "password": "string"
    }
    ```

    **Response**:

*   201 Created: Authentication successful with a token.
*   401 Unauthorized: Invalid credentials.

## URL Shortener Endpoints

**Shorten URL**

-   URL: api/v1/shorten or /api/v2/shorten
-   Method: POST
-   Description: Shortens a given long URL.
-   Request Body

    ```bash
    {
        "long_url": "string (URL format)"
    }
    ```

    **Response**:

*   200 OK: Returns the generated short URL
    ```bash
    {
        "short_url": "string"
    }
    ```
    -   422 Unprocessable Entity: Validation error for the long_url field.

**List URL**

-   URL: /api/v1/urls or /api/v2/urls
-   Method: GET
-   Description: Lists all shortened URLs created by the authenticated user with their visit counts.
-   Request Body

    ```bash
    {
        "long_url": "string (URL format)"
    }
    ```

    **Response**:

*   200 OK: Array of URLs with visit counts
    ```bash
    [
        {
            "short_code": "string",
            "long_url": "string",
            "visit_count": "integer"
        }
    ]
    ```

## URL Redirection

-   Redirect to Long URL

*   URL: /{shortCode}
*   Method: GET
*   Description: Redirects to the original long URL based on the provided short code and increments the visit count.
*   Response:
    -   302 Found: Redirects to the long URL.
    -   404 Not Found: If the short code does not exist.
