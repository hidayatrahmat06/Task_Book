# DIAGRAM SISTEM DAN PERANCANGAN
## Sistem Manajemen Tugas - Task Management System

---

## 1. USE CASE DIAGRAM (Teks Format)

```
┌──────────────────────────────────────────────────────────────┐
│         TASK MANAGEMENT SYSTEM - USE CASE DIAGRAM             │
└──────────────────────────────────────────────────────────────┘

                         System Use Cases

           ┌──────────────────────────────────────┐
           │   Task Management System             │
           │                                      │
           │  ┌────────────────────────────────┐  │
           │  │    Authentication Module       │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-01: Register          │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-02: Login             │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-03: Logout            │  │  │
           │  │ └──────────────────────────┘  │  │
           │  └────────────────────────────────┘  │
           │                                      │
           │  ┌────────────────────────────────┐  │
           │  │    Dashboard Module            │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-04: View Dashboard    │  │  │
           │  │ └──────────────────────────┘  │  │
           │  └────────────────────────────────┘  │
           │                                      │
           │  ┌────────────────────────────────┐  │
           │  │    Task Management Module      │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-05: Create Task       │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-06: Read Task         │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-07: Update Task       │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-08: Delete Task       │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-09: Change Status     │  │  │
           │  │ └──────────────────────────┘  │  │
           │  │ ┌──────────────────────────┐  │  │
           │  │ │ UC-10: Set Priority      │  │  │
           │  │ └──────────────────────────┘  │  │
           │  └────────────────────────────────┘  │
           │                                      │
           └──────────────────────────────────────┘
                         ▲
                         │
                    ┌────┴────┐
                    │          │
            ┌───────▼──┐  ┌──▼──────────┐
            │   User   │  │ Admin User  │
            │          │  │             │
            │ (Guest)  │  │ (Optional)  │
            └──────────┘  └─────────────┘
```

---

## 2. ACTIVITY DIAGRAM - LOGIN PROCESS

```
┌─────────────────────────────────────────────────────────────┐
│          ACTIVITY DIAGRAM: LOGIN PROCESS                    │
└─────────────────────────────────────────────────────────────┘

                          START
                            │
                            ▼
              ┌──────────────────────────┐
              │ User Opens Login Page    │
              └──────────────────────────┘
                            │
                            ▼
              ┌──────────────────────────┐
              │ Display Login Form       │
              │ - Email field            │
              │ - Password field         │
              │ - Remember me checkbox   │
              └──────────────────────────┘
                            │
                            ▼
              ┌──────────────────────────┐
              │ User Enters Credentials  │
              └──────────────────────────┘
                            │
                            ▼
              ┌──────────────────────────┐
              │ User Clicks Submit       │
              └──────────────────────────┘
                            │
                            ▼
            ╔═══════════════════════════════╗
            ║  Client-Side Validation       ║
            ║  - Email format check         ║
            ║  - Password not empty         ║
            ╚═══════════════════════════════╝
                            │
                    ┌───────┴───────┐
                    │               │
               Valid              Invalid
                    │               │
                    ▼               ▼
            ┌──────────────┐  ┌──────────────┐
            │ POST to      │  │ Show Error   │
            │ /login       │  │ Message      │
            └──────────────┘  └──────────────┘
                    │               │
                    │               ▼
                    │          ┌──────────────┐
                    │          │ Highlight   │
                    │          │ Fields       │
                    │          └──────────────┘
                    │               │
                    │               ▼
                    │          ┌──────────────┐
                    │          │ Return to    │
                    │          │ Login Form   │
                    │          └──────────────┘
                    │
                    ▼
        ╔═════════════════════════════════╗
        ║ Server-Side Validation          ║
        ║ - Check email exists            ║
        ║ - Verify password hash          ║
        ║ - Check account status          ║
        ╚═════════════════════════════════╝
                    │
            ┌───────┴───────┐
            │               │
       Credentials       Credentials
       Valid         Invalid/Expired
            │               │
            ▼               ▼
    ┌──────────────┐  ┌──────────────┐
    │ Generate     │  │ Log failed   │
    │ Session ID   │  │ login        │
    └──────────────┘  └──────────────┘
            │               │
            ▼               ▼
    ┌──────────────┐  ┌──────────────┐
    │ Store in     │  │ Return to    │
    │ Cookie       │  │ Login Form   │
    └──────────────┘  │ with error   │
            │         └──────────────┘
            ▼
    ┌──────────────┐
    │ Redirect to  │
    │ Dashboard    │
    └──────────────┘
            │
            ▼
    ┌──────────────┐
    │ Display      │
    │ User Tasks   │
    └──────────────┘
            │
            ▼
          END

```

---

## 3. ACTIVITY DIAGRAM - CRUD TASK PROCESS

```
┌──────────────────────────────────────────────────────────────┐
│       ACTIVITY DIAGRAM: TASK CRUD OPERATIONS                │
└──────────────────────────────────────────────────────────────┘

                      Logged in User
                            │
                            ▼
                  ┌───────────────────┐
                  │ Access Task Menu  │
                  └───────────────────┘
                            │
            ┌───────┬───────┼───────┬────────┐
            │       │       │       │        │
            ▼       ▼       ▼       ▼        ▼
        CREATE   READ    UPDATE  DELETE    SEARCH

        ┌─────────────────────────────────────────┐
        │ CREATE NEW TASK                        │
        ├─────────────────────────────────────────┤
        │ ▼                                       │
        │ Display Create Form                    │
        │ ├─ Title field                         │
        │ ├─ Description field                   │
        │ ├─ Priority dropdown                   │
        │ └─ Due date picker                     │
        │ ▼                                       │
        │ User Fills Form                        │
        │ ▼                                       │
        │ Client-side Validation                 │
        │ ├─ Required fields check               │
        │ └─ Date format validation              │
        │ ▼                                       │
        │ POST /tasks (Form Data)                │
        │ ▼                                       │
        │ Server-side Validation                 │
        │ ├─ Title not empty (max 255 chars)    │
        │ ├─ Description optional                │
        │ └─ Priority in (low, medium, high)    │
        │ ▼                                       │
        │ Insert into DB                         │
        │ ▼                                       │
        │ Redirect to Task List                  │
        │ + Success Message                      │
        └─────────────────────────────────────────┘

        ┌─────────────────────────────────────────┐
        │ READ / VIEW TASKS                       │
        ├─────────────────────────────────────────┤
        │ ▼                                       │
        │ GET /tasks                             │
        │ ▼                                       │
        │ Query all user tasks                   │
        │ ├─ Apply filters (status, priority)   │
        │ ├─ Apply search (title)                │
        │ └─ Paginate results                    │
        │ ▼                                       │
        │ Display Tasks Table                    │
        │ ├─ Title, Priority, Status             │
        │ ├─ Due Date, Actions                   │
        │ └─ Pagination controls                 │
        └─────────────────────────────────────────┘

        ┌─────────────────────────────────────────┐
        │ UPDATE EXISTING TASK                    │
        ├─────────────────────────────────────────┤
        │ ▼                                       │
        │ GET /tasks/{id}/edit                   │
        │ ▼                                       │
        │ Query task by ID                       │
        │ ├─ Verify ownership (same user)       │
        │ └─ Load current values                 │
        │ ▼                                       │
        │ Display Edit Form                      │
        │ ├─ Pre-fill all fields                │
        │ └─ Add Status field (new)              │
        │ ▼                                       │
        │ User Modifies Fields                   │
        │ ▼                                       │
        │ Validation                             │
        │ ▼                                       │
        │ PUT /tasks/{id} (Form Data)            │
        │ ▼                                       │
        │ Update database                        │
        │ ▼                                       │
        │ Redirect to Task List                  │
        │ + "Updated Successfully" Message       │
        └─────────────────────────────────────────┘

        ┌─────────────────────────────────────────┐
        │ DELETE TASK                             │
        ├─────────────────────────────────────────┤
        │ ▼                                       │
        │ User Clicks Delete Button               │
        │ ▼                                       │
        │ Show Confirmation Dialog                │
        │ "Apakah yakin hapus?"                   │
        │ ├─ Yes ──────┐                        │
        │ └─ No ───┐   │                        │
        │         │   ▼                        │
        │         │ DELETE /tasks/{id}        │
        │         │ ▼                        │
        │         │ Verify ownership        │
        │         │ ▼                        │
        │         │ Delete from DB          │
        │         │ ▼                        │
        │         │ Redirect to Task List   │
        │         │ + "Deleted" Message     │
        │         │                         │
        │         ▼                         │
        │      Back to Task List            │
        └─────────────────────────────────────────┘

                        │
                        ▼
                    Return to
                    Task Menu
                        │
                        ▼
                      END
```

---

## 4. ENTITY RELATIONSHIP DIAGRAM (ERD) - DETAIL

```
┌───────────────────────────────────────────────────────────────┐
│                    DATABASE SCHEMA                            │
│                    ERD - Relational View                       │
└───────────────────────────────────────────────────────────────┘

┌─────────────────────────────────┐
│          USERS TABLE            │
├─────────────────────────────────┤
│ PK  id (BIGINT)                 │
├─────────────────────────────────┤
│     name (VARCHAR 255)          │
│     email (VARCHAR 255) UNIQUE  │
│     password (VARCHAR 255)      │
│     remember_token (TEXT)       │
│     created_at (TIMESTAMP)      │
│     updated_at (TIMESTAMP)      │
└─────────────────────────────────┘
           │
           │ 1
           │
        Has Many
           │
        (1:∞)
           │
           ▼ ∞
┌─────────────────────────────────┐
│          TASKS TABLE            │
├─────────────────────────────────┤
│ PK  id (BIGINT)                 │
│ FK  user_id (BIGINT)            │
├─────────────────────────────────┤
│     title (VARCHAR 255)         │
│     description (TEXT)          │
│     priority (ENUM)             │
│     status (ENUM)               │
│     due_date (DATE)             │
│     created_at (TIMESTAMP)      │
│     updated_at (TIMESTAMP)      │
└─────────────────────────────────┘

RELATIONSHIP DEFINITION:
├─ Type: One-to-Many (1:∞)
├─ User (1) ──────── (∞) Task
├─ Cardinality: 1 user can have many tasks
├─ Ownership: One task belongs to one user
├─ Foreign Key: tasks.user_id → users.id
└─ Delete Rule: CASCADE (delete user = delete tasks)
```

---

## 5. DATA FLOW DIAGRAM (DFD) - LEVEL 0

```
┌──────────────────────────────────────────────────────────────┐
│        DATA FLOW DIAGRAM LEVEL 0 (CONTEXT DIAGRAM)          │
└──────────────────────────────────────────────────────────────┘

                        ┌─────────────┐
                        │    User     │
                        └──────┬──────┘
                               │
                    ┌──────────┼──────────┐
                    │          │          │
                    ▼          ▼          ▼
            login/register  task data  task actions
                    │          │          │
                    │      ┌───┴──────────┴──┐
                    │      │                 │
                    ▼      ▼                 ▼
            ┌───────────────────────────────────────┐
            │   Task Management Application        │
            │                                       │
            │  ┌─── Authentication Module ───┐     │
            │  │ - Login                      │     │
            │  │ - Register                   │     │
            │  │ - Logout                     │     │
            │  └────────────────────────────┘      │
            │                                       │
            │  ┌─── Dashboard Module ────────┐     │
            │  │ - Display Statistics         │     │
            │  │ - Show Recent Tasks          │     │
            │  └────────────────────────────┘      │
            │                                       │
            │  ┌─── Task Management Module ──┐     │
            │  │ - Create Task                │     │
            │  │ - Read Tasks                 │     │
            │  │ - Update Task                │     │
            │  │ - Delete Task                │     │
            │  │ - Filter/Search              │     │
            │  └────────────────────────────┘      │
            │                                       │
            └───────────────────────────────────────┘
                    │          │          │
                    ▼          ▼          ▼
            response    task list   confirmation
                    │          │          │
                    └──────────┼──────────┘
                               │
                               ▼
                        ┌─────────────┐
                        │    User     │
                        └─────────────┘

                   ┌──────────────────┐
                   │   MySQL Database │
                   │                  │
                   │ - users table    │
                   │ - tasks table    │
                   └──────────────────┘
                        ▲  │
                        └──┘
                    (Store/Retrieve)
```

---

## 6. SEQUENCE DIAGRAM - REGISTER FLOW

```
┌──────────────────────────────────────────────────────────────┐
│     SEQUENCE DIAGRAM: USER REGISTRATION FLOW                 │
└──────────────────────────────────────────────────────────────┘

User          Browser        Web Server      Database
 │              │                  │             │
 │──Register────>│                  │             │
 │              │──GET /register────>             │
 │              │                  │             │
 │              │<─Register Form───│             │
 │              │                  │             │
 │<─Show Form───│                  │             │
 │              │                  │             │
 │─Fill Form───>│                  │             │
 │              │                  │             │
 │─Click Submit─>│                  │             │
 │              │──POST /register──>│            │
 │              │(name, email, pwd) │            │
 │              │                  │             │
 │              │           Validate Input       │
 │              │                  │             │
 │              │    Check Email───────────────>│
 │              │                  │<─Response─│
 │              │                  │             │
 │              │    If Email Exists:            │
 │              │<─400 Bad Request─│             │
 │              │                  │             │
 │              │<─Error Message───│             │
 │              │                  │             │
 │<─Show Error──│                  │             │
 │              │                  │             │
 │              │    If Email Valid:            │
 │              │    Hash Password              │
 │              │    Create User────────────────>│
 │              │                  │<─ID Return─│
 │              │<─Create Session──│             │
 │              │                  │             │
 │              │<─Set Cookie──────│             │
 │              │                  │             │
 │              │<─302 Redirect to ─            │
 │              │    dashboard     │             │
 │              │                  │             │
 │<─Dashboard───│                  │             │
 │(Authenticated)                  │             │
 │              │                  │             │
```

---

## 7. CLASS DIAGRAM (Simplified)

```
┌──────────────────────────────────────────────────────────────┐
│            CLASS DIAGRAM - APPLICATION STRUCTURE             │
└──────────────────────────────────────────────────────────────┘

┌─────────────────────────────────┐
│        User Model               │
├─────────────────────────────────┤
│ - id: int                       │
│ - name: string                  │
│ - email: string                 │
│ - password: string              │
│ - created_at: timestamp         │
│ - updated_at: timestamp         │
├─────────────────────────────────┤
│ + tasks(): Collection           │
│ + getTaskCount(): int           │
│ + getCompletedTaskCount(): int  │
│ + getPendingTaskCount(): int    │
│ + getHighPriorityTaskCount():int│
└─────────────────────────────────┘
           ▲
           │ Owns
           │ (1:∞)
           │
           ▼
┌─────────────────────────────────┐
│        Task Model               │
├─────────────────────────────────┤
│ - id: int                       │
│ - user_id: int (FK)             │
│ - title: string                 │
│ - description: text             │
│ - priority: enum                │
│ - status: enum                  │
│ - due_date: date                │
│ - created_at: timestamp         │
│ - updated_at: timestamp         │
├─────────────────────────────────┤
│ + user(): User                  │
│ + isCompleted(): boolean        │
│ + isPending(): boolean          │
│ + isOverdue(): boolean          │
│ + getPriorityBadgeClass(): str  │
│ + getStatusBadgeClass(): str    │
└─────────────────────────────────┘

┌──────────────────────────────────┐
│    AuthController               │
├──────────────────────────────────┤
│ + showRegister()                │
│ + register(Request)             │
│ + showLogin()                   │
│ + login(Request)                │
│ + logout(Request)               │
└──────────────────────────────────┘

┌──────────────────────────────────┐
│  DashboardController            │
├──────────────────────────────────┤
│ + index()                       │
└──────────────────────────────────┘

┌──────────────────────────────────┐
│  TaskController                 │
├──────────────────────────────────┤
│ + index(Request)                │
│ + create()                      │
│ + store(Request)                │
│ + edit(Task)                    │
│ + update(Request, Task)         │
│ + destroy(Task)                 │
│ + updateStatus(Request, Task)   │
└──────────────────────────────────┘
```

---

## 8. DEPLOYMENT ARCHITECTURE DIAGRAM

```
┌──────────────────────────────────────────────────────────────┐
│           DEPLOYMENT ARCHITECTURE DIAGRAM                    │
└──────────────────────────────────────────────────────────────┘

                    ┌─────────────────┐
                    │   WWW / User    │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │  Web Browser    │
                    │  (HTTP/HTTPS)   │
                    └────────┬────────┘
                             │
                    ┌────────▼────────────────────┐
                    │   Web Server (Laravel)      │
                    │                             │
                    │  ┌─────────────────────┐   │
                    │  │ Routing              │   │
                    │  ├─────────────────────┤   │
                    │  │ Controllers          │   │
                    │  │ - AuthController    │   │
                    │  │ - TaskController    │   │
                    │  │ - DashboardCtrl     │   │
                    │  ├─────────────────────┤   │
                    │  │ Views (Blade)       │   │
                    │  │ - layouts/          │   │
                    │  │ - auth/              │   │
                    │  │ - tasks/             │   │
                    │  ├─────────────────────┤   │
                    │  │ Models              │   │
                    │  │ - User              │   │
                    │  │ - Task              │   │
                    │  ├─────────────────────┤   │
                    │  │ Middleware          │   │
                    │  │ - Authenticate      │   │
                    │  └─────────────────────┘   │
                    │                             │
                    └────────┬────────────────────┘
                             │
                             │ (PDO/SQL)
                             │
                    ┌────────▼────────────────────┐
                    │   MySQL Database Server     │
                    │                             │
                    │  ┌─────────────────────┐   │
                    │  │ Database: task_mgmt │   │
                    │  ├─────────────────────┤   │
                    │  │ Tables:             │   │
                    │  │ - users             │   │
                    │  │ - tasks             │   │
                    │  ├─────────────────────┤   │
                    │  │ Indexes:            │   │
                    │  │ - email (users)     │   │
                    │  │ - user_id (tasks)   │   │
                    │  └─────────────────────┘   │
                    │                             │
                    └─────────────────────────────┘
```

