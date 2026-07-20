# SchoolMS - School Management System

A full-stack, multi-school management platform built with Laravel 12. Manage students, teachers, classes, attendance, exams, fees, and report cards — all in one place.

**[Live Demo](https://school-management-system-syiu.onrender.com)** · **[GitHub Repository](https://github.com/berwastore-glitch/School-Management-System)**

---

## Features

### Student Management
- Student registration with admission number, class assignment, and profile management
- Student directory with search, filter, and pagination
- Individual student profiles with attendance history, results, and fee status

### Teacher Management
- Teacher registration with employee ID, qualifications, and subject assignment
- Teacher directory with detailed profiles
- Subject-teacher-class assignment via pivot relationships

### Class Management
- Create and manage classes with sections, capacity, and assigned class teachers
- Link classes to curricula, grade levels, and academic years
- View class details with enrolled students

### Attendance Tracking
- Daily attendance marking (present, absent, late) per class
- Edit and delete attendance records
- Attendance reports with trends and statistics

### Examination Module
- Create exams with subject, date, time, total marks, and passing marks
- Enter and manage student marks per exam
- Automatic grade calculation based on configurable grading scales
- Exam results with student ranking and report card generation

### Fee Management
- Record fee payments (tuition, registration, laboratory, library, sports)
- Track paid, pending, and overdue fees per student
- Print payment receipts
- Fee collection overview with charts

### Academic Structure
- **Curricula**: CBC (Competency Based Curriculum), IB, and custom curricula
- **Academic Years**: Define school years with start/end dates
- **Terms**: Break academic years into terms
- **Grade Levels**: Organize grades within curricula
- **Grading Scales**: Configurable grade letters (A–F) with percentage ranges and grade points

### Report Cards
- Premium A4-formatted report cards with school logo
- Student ranking within class
- Attendance summary and teacher/principal signatures
- QR code verification

### Multi-School Architecture
- Shared database with school-scoped data isolation
- School context middleware for automatic filtering
- Per-school settings and branding

### Role-Based Access Control
- **Super Admin**: Full system access across all schools
- **Admin**: School-level management (students, teachers, classes, fees, exams)
- **Teacher**: Class-level access (mark attendance, enter marks, view students)
- **Student**: Personal dashboard (view results, attendance, fees, exams)

### Activity Log
- Track all user actions with timestamps
- Filterable activity history per school

### Dashboard & Analytics
- Role-specific dashboards with key metrics
- Attendance trend charts (line graphs)
- Fee collection trends (bar charts)
- Fee breakdown (doughnut charts)
- Recent activity feed

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 12 (PHP 8.2) |
| **Frontend** | Blade Templates, Tailwind CSS 3, Alpine.js |
| **Build Tool** | Vite 6 |
| **Database** | PostgreSQL (production), SQLite (local) |
| **Auth** | Laravel Breeze |
| **Charts** | Chart.js |
| **Icons** | Font Awesome 6 |
| **Deployment** | Docker on Render |
| **Version Control** | Git / GitHub |

---

## Project Structure

```
SchoolMS/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/          # Admin CRUD controllers
│   │       ├── Student/        # Student-facing controllers
│   │       └── Teacher/        # Teacher-facing controllers
│   ├── Models/                 # Eloquent models (16 total)
│   ├── Services/               # DashboardService
│   └── Traits/                 # SchoolScoped, NeedsSchool
├── database/
│   ├── migrations/             # 20+ migrations
│   └── seeders/                # DatabaseSeeder with full sample data
├── resources/
│   └── views/
│       ├── admin/              # 42 admin views
│       ├── student/            # 7 student views
│       ├── teacher/            # 18 teacher views
│       ├── frontend/           # Landing page & pricing
│       └── layouts/            # Role-specific layouts
├── routes/
│   └── web.php                 # All route definitions
├── Dockerfile                  # PHP 8.2-cli with PostgreSQL
├── start.sh                    # Container startup script
└── composer.json
```

---

## Local Development

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (default) or PostgreSQL

### Setup

```bash
# Clone the repository
git clone https://github.com/berwastore-glitch/School-Management-System.git
cd School-Management-System

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seed
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

The app will be available at `http://localhost:8000`.

### Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `admin@schoolms.com` | `password` |
| School Admin | `school@schoolms.com` | `password` |
| Teacher | `teacher@test.com` | `password` |
| Student | `student@test.com` | `password` |

---

## Production Deployment (Render)

### Environment Variables

Set these in the Render dashboard:

| Variable | Value |
|----------|-------|
| `APP_KEY` | Generate with `php artisan key:generate` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://your-app.onrender.com` |
| `DB_HOST` | Your Render PostgreSQL host |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | Your database name |
| `DB_USERNAME` | Your database user |
| `DB_PASSWORD` | Your database password |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |

### Deploy

1. Push to GitHub
2. Create a **Web Service** on Render
3. Connect your GitHub repository
4. Render will auto-build using the `Dockerfile`
5. The `start.sh` script handles migrations, seeding, and server startup

---

## Database Schema

Key tables with their relationships:

```
School ──< User
School ──< Teacher ──< User
School ──< Student ──< User
School ──< SchoolClass ──< Teacher
SchoolClass ──< Student
SchoolClass ──< Exam ──< Subject
Student ──< Attendance
Student ──< Result ──< Exam
Student ──< Fee
School ──< Curriculum ──< GradeLevel
School ──< AcademicYear ──< Term
```

---

## API Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Public landing page |
| `/login` | GET/POST | Authentication |
| `/admin/dashboard` | GET | Admin dashboard |
| `/admin/students` | GET | Student management |
| `/admin/teachers` | GET | Teacher management |
| `/admin/classes` | GET | Class management |
| `/admin/attendance` | GET | Attendance tracking |
| `/admin/exams` | GET | Examination management |
| `/admin/fees` | GET | Fee management |
| `/admin/curriculums` | GET | Curriculum management |
| `/admin/academic-years` | GET | Academic year management |
| `/teacher/dashboard` | GET | Teacher dashboard |
| `/student/dashboard` | GET | Student dashboard |
| `/profile/edit` | GET/POST | Profile management |

---

## License

MIT License. See [LICENSE](LICENSE) for details.
