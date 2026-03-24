# API ENDPOINTS REFERENCE
## Sistem Manajemen Tugas (Task Management System)

---

## ENDPOINT OVERVIEW

Aplikasi Task Management System memiliki dua kategori route:
1. **Web Routes** - Untuk browser (HTML responses)
2. **API Routes** - Untuk JSON responses (optional/future)

---

## WEB ROUTES

### Authentication Routes

#### 1. Display Register Form
```
GET /register
Middleware: guest
Response: register.blade.php form
```

**Example:**
```http
GET /register HTTP/1.1
Host: localhost:8000
```

---

#### 2. Store Register (Create Account)
```
POST /register
Middleware: guest
Parameters:
  - name: string(required, max 255)
  - email: string(required, unique, email)
  - password: string(required, min 8)
  - password_confirmation: string(required, same as password)
Response: Redirect to /dashboard
```

**Example:**
```http
POST /register HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

name=Budi+Santoso&email=budi@example.com&password=Password123&password_confirmation=Password123
```

**Response:**
- Success: 302 Redirect to /dashboard + success flash
- Error: 302 Redirect to /register + error messages

---

#### 3. Display Login Form
```
GET /login
Middleware: guest
Response: login.blade.php form
```

---

#### 4. Store Login (Authenticate)
```
POST /login
Middleware: guest
Parameters:
  - email: string(required)
  - password: string(required)
  - remember: boolean(optional)
Response: Redirect
```

**Example:**
```http
POST /login HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

email=budi@example.com&password=Password123&remember=on
```

**Response:**
- Success: 302 to /dashboard with session
- Error: 302 to /login with error message

---

#### 5. Logout
```
POST /logout
Middleware: auth
Response: 302 Redirect to /
Parameters: None (uses CSRF token)
```

**Example:**
```http
POST /logout HTTP/1.1
Host: localhost:8000
```

---

### Dashboard Routes

#### 6. View Dashboard
```
GET /dashboard
Middleware: auth
Response: dashboard.blade.php
Data:
  - stats[]
    - total_tasks: int
    - completed_tasks: int
    - pending_tasks: int
    - high_priority_tasks: int
  - recentTasks: Collection
```

**Example:**
```http
GET /dashboard HTTP/1.1
Host: localhost:8000
Cookie: XSRF-TOKEN=...;Laravel_Session=...
```

---

### Task Management Routes

#### 7. List All Tasks
```
GET /tasks
Middleware: auth
Query Parameters:
  - search: string(optional) - search by title
  - status: enum(optional) - filter by status (todo|in_progress|completed)
  - priority: enum(optional) - filter by priority (low|medium|high)
  - page: int(optional) - pagination page
Response: tasks/index.blade.php with paginated tasks
```

**Examples:**

```http
GET /tasks HTTP/1.1
Host: localhost:8000
```

```http
GET /tasks?search=laravel HTTP/1.1
Host: localhost:8000
```

```http
GET /tasks?status=completed&priority=high HTTP/1.1
Host: localhost:8000
```

```http
GET /tasks?page=2 HTTP/1.1
Host: localhost:8000
```

---

#### 8. Show Create Task Form
```
GET /tasks/create
Middleware: auth
Response: tasks/create.blade.php form
```

---

#### 9. Store New Task
```
POST /tasks
Middleware: auth
Parameters:
  - title: string(required, max 255)
  - description: string(optional)
  - priority: enum(required) - low|medium|high
  - due_date: date(optional, after today)
Response: 302 Redirect to /tasks
```

**Example:**
```http
POST /tasks HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

title=Belajar+Laravel&description=Mempelajari+MVC&priority=high&due_date=2024-03-20
```

**Response:**
- Success: 302 to /tasks with success message
- Error: 302 back to create with validation errors

---

#### 10. Show Edit Task Form
```
GET /tasks/{id}/edit
Middleware: auth
Parameters: (in URL)
  - id: int - Task ID
Response: tasks/edit.blade.php with pre-filled form
Authorization: User must own the task
```

**Example:**
```http
GET /tasks/5/edit HTTP/1.1
Host: localhost:8000
```

---

#### 11. Update Task
```
PUT /tasks/{id}
Middleware: auth
Parameters: (in URL)
  - id: int
Parameters: (in data)
  - title: string(required, max 255)
  - description: string(optional)
  - priority: enum(required)
  - status: enum(required) - todo|in_progress|completed
  - due_date: date(optional)
Response: 302 Redirect to /tasks
Authorization: User must own the task
```

**Example:**
```http
PUT /tasks/5 HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

title=Belajar+Laravel+Advanced&status=in_progress&priority=medium
```

**Note:** Laravel forms use method spoofing:
```html
<form method="POST" action="/tasks/5">
  @csrf
  @method('PUT')
  ...
</form>
```

---

#### 12. Delete Task
```
DELETE /tasks/{id}
Middleware: auth
Parameters:
  - id: int - Task ID
Response: 302 Redirect to /tasks
Authorization: User must own the task
```

**Example:**
```http
DELETE /tasks/5 HTTP/1.1
Host: localhost:8000
```

**HTML Form:**
```html
<form method="POST" action="/tasks/5">
  @csrf
  @method('DELETE')
  <button type="submit">Delete</button>
</form>
```

---

#### 13. Update Task Status (AJAX)
```
POST /tasks/{id}/updateStatus
Middleware: auth
Content-Type: application/json
Parameters (JSON):
  - status: enum - todo|in_progress|completed
Response: JSON
  {
    "success": true,
    "message": "Status updated"
  }
Authorization: User must own the task
```

**Example (jQuery/AJAX):**
```javascript
$.ajax({
  type: 'POST',
  url: '/tasks/5/updateStatus',
  data: JSON.stringify({
    status: 'completed',
    _token: csrfToken
  }),
  contentType: 'application/json',
  success: function(response) {
    console.log(response.message);
  }
});
```

---

## ROUTE SUMMARY TABLE

| HTTP | URL | Action | Auth | Purpose |
|------|-----|--------|------|---------|
| GET | /register | showRegister | guest | Show register form |
| POST | /register | register | guest | Create account |
| GET | /login | showLogin | guest | Show login form |
| POST | /login | login | guest | Authenticate user |
| POST | /logout | logout | auth | Logout user |
| GET | /dashboard | index | auth | View dashboard |
| GET | /tasks | index | auth | List tasks |
| GET | /tasks/create | create | auth | Create form |
| POST | /tasks | store | auth | Save new task |
| GET | /tasks/{id}/edit | edit | auth | Edit form |
| PUT | /tasks/{id} | update | auth | Update task |
| DELETE | /tasks/{id} | destroy | auth | Delete task |
| POST | /tasks/{id}/updateStatus | updateStatus | auth | Update status (AJAX) |

---

## HTTP STATUS CODES

| Code | Meaning | Usage |
|------|---------|-------|
| 200 | OK | Successful GET request |
| 302 | Found | Redirect (after POST/PUT/DELETE) |
| 400 | Bad Request | Validation error |
| 401 | Unauthorized | Not authenticated |
| 403 | Forbidden | Not authorized (no ownership) |
| 404 | Not Found | Resource not found |
| 422 | Unprocessable Entity | Validation error (detailed) |
| 500 | Server Error | Internal server error |

---

## REQUEST HEADERS (Important)

```
GET /tasks HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded
Cookie: XSRF-TOKEN=abc123;Laravel_Session=xyz789
X-CSRF-TOKEN: abc123 (needed for state-changing requests)
```

---

## CSRF PROTECTION

Semua POST/PUT/DELETE requests membutuhkan CSRF token:

**In Blade Forms:**
```html
<form method="POST" action="/tasks">
  @csrf
  <input type="text" name="title">
  <button type="submit">Create</button>
</form>
```

**The @csrf directive generates:**
```html
<input type="hidden" name="_token" value="ABC123XYZ...">
```

**In AJAX:**
```javascript
headers: {
  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
```

---

## AUTHENTICATION FLOW

```
1. User tidak login → show /login form
2. User submit login → server validate credentials
3. Creds valid → create session → redirect to /dashboard
4. User access /tasks → middleware check auth
5. Auth valid → load tasks → display
6. User not auth → redirect to /login
7. User logout → destroy session → redirect to /
```

---

## FORMS & VALIDATION

### Register Form
```html
POST /register
- name (required, max 255)
- email (required, email, unique:users)
- password (required, min 8, confirmed)
- password_confirmation (required, same:password)
```

### Login Form
```html
POST /login
- email (required, email)
- password (required)
- remember (optional, checkbox)
```

### Task Forms
```html
POST /tasks (Create)
- title (required, max 255)
- description (optional, text)
- priority (required, in:low,medium,high)
- due_date (optional, date, after:today)

PUT /tasks/{id} (Update)
- title (required, max 255)
- description (optional, text)
- priority (required, in:low,medium,high)
- status (required, in:todo,in_progress,completed)
- due_date (optional, date)
```

---

## QUERY EXAMPLES

### Search Tasks
```
GET /tasks?search=laravel
```
Returns tasks dengan "laravel" di title

### Filter by Status
```
GET /tasks?status=completed
```
Returns hanya completed tasks

### Filter by Priority
```
GET /tasks?priority=high
```
Returns hanya high priority tasks

### Kombinasi
```
GET /tasks?search=php&status=in_progress&priority=high&page=1
```
Returns tasks yang match semua filter

---

## ERROR RESPONSES

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["Email sudah terdaftar"],
    "password": ["Password minimal 8 karakter"]
  }
}
```

### Unauthorized (401)
```html
Redirect to /login
```

### Not Authorized (403)
```html
403 Forbidden
```

### Not Found (404)
```html
404 Not Found
```

---

## PAGINATION

List endpoints mendukung pagination:

```
GET /tasks?page=1
```

Response mencakup:
- items (on current page)
- total count
- links (previous, next)
- current page
- per page count

**Example Response:**
```html
<!-- Blade template automatically includes pagination -->
{{ $tasks->links() }}

<!-- Output -->
<div class="pagination">
  <a href="?page=1">1</a>
  <span>2</span>  <!-- current page -->
  <a href="?page=3">3</a>
</div>
```

---

## RATE LIMITING

Tidak ada rate limiting di aplikasi ini (development stage).

Untuk production, bisa tambahkan:
```php
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/tasks', ...);
    Route::post('/tasks/{id}', ...);
    Route::delete('/tasks/{id}', ...);
});
```

---

## TESTING ENDPOINTS

### Menggunakan Postman

1. Import collection atau buat manual
2. Set base URL: `http://localhost:8000`
3. Setup CSRF token di pre-request script
4. Test setiap endpoint

### Menggunakan cURL

```bash
# Register
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=Budi&email=budi@example.com&password=Password123&password_confirmation=Password123"

# Login
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=budi@example.com&password=Password123"

# Get tasks
curl -X GET http://localhost:8000/tasks \
  -H "Cookie: Laravel_Session=..."

# Create task
curl -X POST http://localhost:8000/tasks \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "Cookie: Laravel_Session=..." \
  -d "title=Test&priority=high&_token=..."
```

---

**Last Updated**: Maret 2024  
**API Version**: 1.0
