# Laravel Movie App

A Laravel 5.8 application for searching and saving favorite movies using the OMDb API.

## Features

-   **Authentication**: Custom login using Username (`aldmic`) and Password (`123abc123`).
-   **Movie Search**: Search movies via OMDb API.
-   **Movie Details**: View detailed information about a movie.
-   **Favorites**: Add/Remove movies to/from your personal favorites list.
-   **Infinite Scroll**: Automatically load more movies as you scroll down the list.
-   **Lazy Loading**: Images are loaded only when they come into view for better performance.
-   **Localization**: Multi-language support (English / Indonesian) for static text.

## Tech Stack & Architecture

-   **Framework**: Laravel 5.8 (PHP 7.4 compatible)
-   **Database**: SQLite (Configured for portability)
-   **Frontend**: Blade Templates, Bootstrap 4, jQuery
-   **API Integration**: GuzzleHTTP Client
-   **Architecture**:
    -   **MVC**: Standard Model-View-Controller pattern.
    -   **Service Layer**: `OmdbService` handles all third-party API interactions.
    -   **Middleware**: `SetLocale` for handling language switching.

## Libraries Used

-   `guzzlehttp/guzzle`: For making HTTP requests to OMDb API.
-   `jquery`: For DOM manipulation, AJAX (Search/Infinite Scroll).
-   `bootstrap`: For responsive UI and styling.

## Installation & Setup

1.  **Clone the repository** (or download source).
2.  **Install Dependencies**:
    ```bash
    composer install
    ```
3.  **Environment Setup**:
    -   Copy `.env.example` to `.env`.
    -   Set `DB_CONNECTION=sqlite`.
    -   Add your OMDb API Key: `OMDB_API_KEY=your_key_here`. 
    -   (Note: The project comes with a pre-configured .env and SQLite database for the demo).
4.  **Database**:
    -   Create `database/database.sqlite` if it doesn't exist.
    -   Run migrations: `php artisan migrate`.
    -   Seed user: `php artisan db:seed --class=UsersTableSeeder`.
5.  **Run Application**:
    ```bash
    php artisan serve
    ```
6.  **Access**:
    -   URL: `http://localhost:8000`
    -   Login: `aldmic` / `123abc123`

## Screenshots

*(Place screenshots here)*

## Requirements Checklist

-   [x] Laravel 5 Framework (5.8 used).
-   [x] Login Page (User: aldmic, Pass: 123abc123).
-   [x] List Movie Page with Search & Infinite Scroll.
-   [x] Detail Movie Page.
-   [x] Error handling for login.
-   [x] Favorites System (Add/Remove/List).
-   [x] Multi-language (ID/EN).
-   [x] Lazy Load implementation.
