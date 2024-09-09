Here’s the updated `README.md` with the Postman link added to the documentation section:

---

# Task Management API (Advanced Level)

## Overview
This project is an advanced **Task Management API** built with Laravel. The API allows users to create, read, update, delete (CRUD), and assign tasks with different properties such as title, description, priority, due date, status, and assigned user. The system includes role-based access control (Admin, Manager, and User) and advanced model handling with features like `fillable`, `guarded`, `primaryKey`, `table`, and `timestamps`.

## Project Features
### 1. **Task Management (CRUD)**
- Create, read, update, delete tasks with various attributes.
- Role-based access control: 
  - **Admin** can manage all tasks.
  - **Manager** can assign tasks and manage tasks they created or assigned.
  - **User** can only modify tasks assigned to them.
  
### 2. **Role Management**
- Users have different roles (`Admin`, `Manager`, `User`).
- **Admin** has full control over tasks and users.
- **Manager** can assign tasks to users and manage tasks they've assigned or created.
- **User** can only update the status and details of tasks assigned to them.

### 3. **Date Handling**
- Custom formatting for due dates using accessors and mutators (format: `d-m-Y H:i`).

### 4. **Soft Deletes**
- Tasks and users are soft-deletable, meaning they can be restored after deletion.

### 5. **Query Scopes**
- Filter tasks based on `priority` and `status` using advanced query scopes.

---

## Installation and Setup
### Prerequisites:
- PHP >= 8.0
- Composer
- MySQL (or any preferred database)
- Laravel 10.x

### Steps:
1. Clone the repository:
   ```bash
   git clone https://github.com/your-repository/task-management-api.git
   ```
2. Navigate to the project directory:
   ```bash
   cd task-management-api
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Set up environment variables:
   ```bash
   cp .env.example .env
   ```
   Update your `.env` file with the correct database credentials.

5.Generate the application key:
``Terminal
php artisan key:generate

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

---

## API Endpoints
### Task Management:
- **POST /tasks**: Create a new task.
- **GET /tasks**: List all tasks (filterable by `priority` and `status`).
- **GET /tasks/{id}**: Show task details.
- **PUT /tasks/{id}**: Update task (only the assigned user can edit).
- **DELETE /tasks/{id}**: Soft delete the task.

### Task Assignment:
- **POST /tasks/{id}/assign**: Assign a task to a user (Managers only).

### User Management:
- **POST /users**: Create a new user.
- **GET /users**: List all users.
- **PUT /users/{id}**: Update user information (Admin only).
- **DELETE /users/{id}**: Soft delete the user.

---

## Database Models

### Task Model:
- **Fillable**: `title`, `description`, `priority`, `due_date`, `status`, `assigned_to`
- **Guarded**: None
- **Primary Key**: `task_id` (if different from default `id`)
- **Table**: `tasks` (default)
- **Timestamps**: Custom names for timestamps:
  - `CREATED_AT = 'created_on'`
  - `UPDATED_AT = 'updated_on'`

### User Model:
- **Guarded**:  `role`
- **Timestamps**: Default

---

## Roles and Permissions

1. **Admin**:
   - Full access to all tasks and users.
   - Can create, update, assign, and delete tasks.
   - Can update and delete users.

2. **Manager**:
   - Can create and assign tasks.
   - Can manage tasks they've created or assigned to others.

3. **User**:
   - Can only update the status of tasks assigned to them.

---

## Soft Deletes and Recovery
- Tasks and users can be soft deleted, allowing recovery later if needed.
- To restore deleted records, you can use Laravel’s built-in `restore()` method.

---

## Query Scopes
- **Filter by priority**:
  ```php
  public function scopePriority($query, $priority) {
      return $query->where('priority', $priority);
  }
  ```
- **Filter by status**:
  ```php
  public function scopeStatus($query, $status) {
      return $query->where('status', $status);
  }
  ```

---

## Documentation and Testing

You can test the API and explore detailed documentation using **Postman**:

[Task Management API - Postman Documentation](https://documenter.getpostman.com/view/34411360/2sAXjSy8tW)

The Postman documentation includes example requests and responses for all available API endpoints, along with the necessary parameters and expected results.

---

## Code Quality
- The code is structured with clean, readable comments and documentation.
- Proper validation, authorization checks, and security measures are implemented.
  
## Testing
- API can be tested using **Postman** or integrated with **Swagger** for auto-generated API documentation.

---

## License
This project is licensed under the MIT License.

---

## Contributors
- samer abbas

---

This update includes the Postman link under the "Documentation and Testing" section for easy access to the Postman collection.
