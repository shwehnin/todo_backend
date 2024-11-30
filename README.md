# Todo API

This is a simple Todo API built with Laravel, providing CRUD operations to manage todo items. It includes endpoints for listing, creating, updating, retrieving, and deleting todos. The API is built to handle various formats for the `due_date` field.

## Features

- **Create a Todo**: Allows the creation of a new todo.
- **Read Todos**: Retrieve a list of all todos or a specific todo by its ID.
- **Update a Todo**: Modify an existing todo's title or due date.
- **Delete a Todo**: Remove a todo item by its ID.

## Requirements

- PHP >= 8.0
- Laravel >= 9.x
- Composer
- MySQL or any other database supported by Laravel

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/todo_backend.git
    ```

2. Navigate to the project directory:

    ```bash
    cd todo_backend
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Set up environment configuration:

    Copy the example `.env` file and configure the environment settings (database credentials, etc.):

    ```bash
    cp .env.example .env
    ```

5. Set up the database:

    - Configure database settings in the `.env` file.
    - Run migrations:

    ```bash
    php artisan migrate
    ```

6. (Optional) Seed the database with dummy data:

    ```bash
    php artisan db:seed
    ```

7. Start the development server:

    ```bash
    php artisan serve
    ```

    The API will be available at `http://localhost:8000`.
    

## API Endpoints

### 1. **Get Todo List**
- **URL**: `/api/v1/todos`
- **Method**: `GET`
- **Description**: Fetch all todos in descending order.
- **Response**:

    ```json
    {
        "status": true,
        "message": "Todo List",
        "data": [
            {
                "id": 1,
                "title": "Learn PHP",
                "due_date": "2024-12-01",
                "created_at": "2024-11-30T10:00:00",
                "updated_at": "2024-11-30T10:00:00"
            }
        ]
    }
    ```

### 2. **Get Specific Todo**
- **URL**: `/api/v1/todos/{id}`
- **Method**: `GET`
- **Description**: Fetch a specific todo by its ID.
- **Response**:

    ```json
    {
        "status": true,
        "message": "Todo retrieved successfully",
        "data": {
            "id": 1,
            "title": "Learn PHP",
            "due_date": "2024-12-01",
            "created_at": "2024-11-30T10:00:00",
            "updated_at": "2024-11-30T10:00:00"
        }
    }
    ```

### 3. **Create a Todo**
- **URL**: `/api/v1/todos`
- **Method**: `POST`
- **Description**: Create a new todo item.
- **Request**:

    ```json
    {
        "title": "Learn PHP",
        "due_date": "2024-12-01"
    }
    ```

- **Response**:

    ```json
    {
        "status": true,
        "message": "Todo created successfully!",
        "data": {
            "id": 1,
            "title": "Learn PHP",
            "due_date": "2024-12-01",
            "created_at": "2024-11-30T10:00:00",
            "updated_at": "2024-11-30T10:00:00"
        }
    }
    ```

### 4. **Update a Todo**
- **URL**: `/api/v1/todos/{id}`
- **Method**: `PUT`
- **Description**: Update an existing todo item.
- **Request**:

    ```json
    {
        "title": "Learn Laravel",
        "due_date": "2024-12-10"
    }
    ```

- **Response**:

    ```json
    {
        "status": true,
        "message": "Todo updated successfully",
        "data": {
            "id": 1,
            "title": "Learn Laravel",
            "due_date": "2024-12-10",
            "created_at": "2024-11-30T10:00:00",
            "updated_at": "2024-11-30T12:00:00"
        }
    }
    ```

### 5. **Delete a Todo**
- **URL**: `/api/v1/todos/{id}`
- **Method**: `DELETE`
- **Description**: Delete a todo item by ID.
- **Response**:

    ```json
    {
        "status": true,
        "message": "Todo deleted successfully",
        "data": {
            "id": 1,
            "title": "Learn Laravel",
            "due_date": "2024-12-10",
            "created_at": "2024-11-30T10:00:00",
            "updated_at": "2024-11-30T12:00:00"
        }
    }
    ```

## Unit Testing with Pest

This project uses **Pest** for unit testing. Below are the tests for the API endpoints.

### Run Test

To get started with Pest, run:

```bash
php artisan test
