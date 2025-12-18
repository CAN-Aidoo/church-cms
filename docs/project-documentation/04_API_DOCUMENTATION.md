# Church Management System - API Documentation

## 🌐 API Overview

**Base URL**: `https://api.churchms.com/api/v1`
**Authentication**: Bearer token (Laravel Sanctum)
**Content-Type**: `application/json`
**API Version**: v1.0

---

## 🔐 Authentication

### Login
```
POST /api/v1/auth/login
```

**Request Body**:
```json
{
  "email": "admin@church.com",
  "password": "password123"
}
```

**Response**: `200 OK`
```json
{
  "status": "success",
  "data": {
    "user": {
      "id": 1,
      "email": "admin@church.com",
      "full_name": "John Admin",
      "role": "admin"
    },
    "token": "1|laravel_sanctum_token_here",
    "token_type": "Bearer",
    "expires_at": "2024-01-15T10:00:00Z"
  }
}
```

### Register
```
POST /api/v1/auth/register
```

**Request Body**:
```json
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "password": "SecurePassword123!",
  "password_confirmation": "SecurePassword123!",
  "phone": "+233247123456"
}
```

### Logout
```
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

**Response**: `200 OK`
```json
{
  "status": "success",
  "message": "Successfully logged out"
}
```

### Refresh Token
```
POST /api/v1/auth/refresh
Authorization: Bearer {token}
```

### Forgot Password
```
POST /api/v1/auth/forgot-password
```

**Request Body**:
```json
{
  "email": "user@example.com"
}
```

### Reset Password
```
POST /api/v1/auth/reset-password
```

**Request Body**:
```json
{
  "email": "user@example.com",
  "token": "reset_token",
  "password": "NewPassword123!",
  "password_confirmation": "NewPassword123!"
}
```

---

## 🔑 Authorization Headers

All protected endpoints require:
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

## 👥 MEMBERS ENDPOINTS

### List Members
```
GET /api/v1/members
```

**Query Parameters**:
- `search`: string (search by name, email, phone)
- `status`: active|inactive|pending|suspended
- `gender`: male|female|other
- `sort_by`: first_name|last_name|join_date|created_at
- `sort_order`: asc|desc
- `page`: number (default: 1)
- `per_page`: number (default: 20, max: 100)

**Response**: `200 OK`
```json
{
  "status": "success",
  "data": {
    "members": [
      {
        "id": 1,
        "user_id": 123,
        "first_name": "John",
        "last_name": "Doe",
        "email": "john@example.com",
        "phone": "+233247123456",
        "date_of_birth": "1990-05-15",
        "gender": "male",
        "member_status": "active",
        "join_date": "2023-01-01",
        "created_at": "2023-01-01T10:00:00Z",
        "updated_at": "2024-01-15T15:30:00Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 547,
      "last_page": 28,
      "from": 1,
      "to": 20
    }
  }
}
```

### Get Member Detail
```
GET /api/v1/members/{id}
```

**Response**: `200 OK`
```json
{
  "status": "success",
  "data": {
    "member": {
      "id": 1,
      "user_id": 123,
      "first_name": "John",
      "last_name": "Doe",
      "email": "john@example.com",
      "phone": "+233247123456",
      "alternate_phone": "+233247123457",
      "date_of_birth": "1990-05-15",
      "gender": "male",
      "marital_status": "married",
      "occupation": "Engineer",
      "address": "123 Main St",
      "city": "Takoradi",
      "postal_code": "230001",
      "member_status": "active",
      "join_date": "2023-01-01",
      "last_contact_date": "2024-01-15",
      "profile_photo_url": "https://...",
      "bio": "Member bio",
      "notes": "Internal notes",
      "referral_source": "Friend",
      "attendance_stats": {
        "total_services": 45,
        "total_present": 40,
        "attendance_percentage": 88.89
      },
      "created_at": "2023-01-01T10:00:00Z",
      "updated_at": "2024-01-15T15:30:00Z"
    }
  }
}
```

### Create Member
```
POST /api/v1/members
```

**Request Body**:
```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+233247123456",
  "date_of_birth": "1990-05-15",
  "gender": "male",
  "marital_status": "married",
  "address": "123 Main St",
  "city": "Takoradi",
  "postal_code": "230001",
  "join_date": "2024-01-01",
  "member_status": "active"
}
```

**Response**: `201 Created` + Member object

**Validation Rules**:
- Email must be valid format
- Phone must be valid E.164 format
- date_of_birth must be in past
- Required fields: first_name, last_name, phone (or email), join_date

### Update Member
```
PUT /api/v1/members/{id}
```

**Request Body**: (All fields optional)
```json
{
  "first_name": "John",
  "email": "newemail@example.com",
  "member_status": "inactive",
  "notes": "Updated notes"
}
```

**Response**: `200 OK` + Updated member object

### Delete Member
```
DELETE /api/v1/members/{id}
```

**Response**: `200 OK`
```json
{
  "status": "success",
  "message": "Member deleted successfully"
}
```

**Note**: Soft delete in production - sets member_status to 'inactive'

### Upload Member Photo
```
POST /api/v1/members/{id}/photo
Content-Type: multipart/form-data
```

**Form Data**:
- `photo`: File (JPEG/PNG, max 5MB)

**Response**: `200 OK`
```json
{
  "status": "success",
  "data": {
    "photo_url": "https://..."
  }
}
```

---

## 📋 ATTENDANCE ENDPOINTS

### List Attendance Records
```
GET /api/v1/attendance
```

**Query Parameters**:
- `member_id`: number (filter by member)
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD
- `service_type`: sunday_service|midweek|prayer_meeting
- `status`: present|absent|excused|late
- `page`: number (default: 1)
- `per_page`: number (default: 20)

**Response**:
```json
{
  "status": "success",
  "data": {
    "attendance": [
      {
        "id": 1,
        "member_id": 123,
        "member_name": "John Doe",
        "service_date": "2024-01-15",
        "service_type": "sunday_service",
        "status": "present",
        "notes": "Optional notes",
        "recorded_by": "username",
        "recorded_at": "2024-01-15T10:00:00Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 1200
    }
  }
}
```

### Mark Attendance
```
POST /api/v1/attendance
```

**Request Body**:
```json
{
  "member_id": 123,
  "service_date": "2024-01-15",
  "service_type": "sunday_service",
  "status": "present",
  "notes": "Optional notes"
}
```

**Response**: `201 Created` + Attendance record

### Bulk Mark Attendance
```
POST /api/v1/attendance/bulk
```

**Request Body**:
```json
{
  "service_date": "2024-01-15",
  "service_type": "sunday_service",
  "records": [
    {
      "member_id": 123,
      "status": "present",
      "notes": "Optional"
    },
    {
      "member_id": 124,
      "status": "absent"
    }
  ]
}
```

**Response**: `201 Created`
```json
{
  "status": "success",
  "data": {
    "processed": 45,
    "failed": 0,
    "created_count": 45
  }
}
```

### Update Attendance Record
```
PUT /api/v1/attendance/{id}
```

### Delete Attendance Record
```
DELETE /api/v1/attendance/{id}
```

### Get Attendance Report
```
GET /api/v1/attendance/reports/member/{member_id}
```

**Query Parameters**:
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD

---

## 💰 FINANCE ENDPOINTS

### List Transactions
```
GET /api/v1/transactions
```

**Query Parameters**:
- `type`: tithe|offering|donation|expense|other_income
- `category`: string
- `member_id`: number
- `status`: pending|completed|reconciled|disputed
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD
- `page`: number
- `per_page`: number

**Response**:
```json
{
  "status": "success",
  "data": {
    "transactions": [
      {
        "id": 1,
        "member_id": 123,
        "member_name": "John Doe",
        "transaction_type": "tithe",
        "amount": 500.00,
        "currency": "GHS",
        "category": "Online",
        "description": "Weekly tithe",
        "payment_method": "mobile_money",
        "reference_number": "REF123",
        "transaction_date": "2024-01-15",
        "status": "completed",
        "created_at": "2024-01-15T10:00:00Z"
      }
    ],
    "summary": {
      "total_amount": 25000.00,
      "transaction_count": 50,
      "average": 500.00
    },
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 500
    }
  }
}
```

### Create Transaction
```
POST /api/v1/transactions
```

**Request Body**:
```json
{
  "member_id": 123,
  "transaction_type": "tithe",
  "amount": 500.00,
  "category": "Online",
  "description": "Weekly tithe",
  "payment_method": "mobile_money",
  "reference_number": "REF123",
  "transaction_date": "2024-01-15"
}
```

### Approve Transaction
```
PUT /api/v1/transactions/{id}/approve
```

**Response**: `200 OK`
```json
{
  "status": "success",
  "data": {
    "approved_by": 1,
    "approved_at": "2024-01-15T10:00:00Z"
  }
}
```

### Get Financial Summary
```
GET /api/v1/finance/summary
```

**Query Parameters**:
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD

**Response**:
```json
{
  "status": "success",
  "data": {
    "period": {
      "start_date": "2024-01-01",
      "end_date": "2024-01-31"
    },
    "income": {
      "tithes": 15000.00,
      "offerings": 8000.00,
      "donations": 5000.00,
      "other": 2000.00,
      "total": 30000.00
    },
    "expenses": {
      "salaries": 5000.00,
      "utilities": 2000.00,
      "maintenance": 1500.00,
      "other": 1500.00,
      "total": 10000.00
    },
    "net_balance": 20000.00,
    "opening_balance": 50000.00,
    "closing_balance": 70000.00
  }
}
```

### Generate Financial Report
```
GET /api/v1/finance/reports
```

**Query Parameters**:
- `report_type`: monthly|quarterly|annual|custom
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD
- `format`: json|pdf|csv|excel

---

## 📱 SMS ENDPOINTS

### List SMS Broadcasts
```
GET /api/v1/sms/broadcasts
```

**Query Parameters**:
- `status`: draft|scheduled|sent|failed
- `page`: number
- `per_page`: number

### Create SMS Broadcast
```
POST /api/v1/sms/broadcasts
```

**Request Body**:
```json
{
  "title": "Sunday Service Reminder",
  "message": "Join us this Sunday at 9:00 AM. Location: Main Hall",
  "recipient_group": "active_members",
  "scheduled_for": "2024-01-21T08:00:00Z"
}
```

**Validation**:
- Message max 160 chars (standard SMS) or up to 1600 for multi-part
- At least 1 recipient group
- Scheduled time in future if provided

### Send SMS Broadcast
```
POST /api/v1/sms/broadcasts/{id}/send
```

### Get SMS Delivery Status
```
GET /api/v1/sms/broadcasts/{id}/status
```

---

## 🎛️ EQUIPMENT ENDPOINTS

### List Equipment
```
GET /api/v1/equipment
```

**Query Parameters**:
- `category`: string
- `status`: active|inactive|maintenance|retired
- `search`: string
- `page`: number
- `per_page`: number

### Create Equipment
```
POST /api/v1/equipment
```

**Request Body**:
```json
{
  "name": "Projector",
  "category": "Audio/Visual",
  "serial_number": "SN12345",
  "model": "Model X",
  "purchase_date": "2023-06-01",
  "purchase_price": 5000.00,
  "location": "Sanctuary",
  "status": "active"
}
```

---

## 👥 VISITORS ENDPOINTS

### List Visitors
```
GET /api/v1/visitors
```

**Query Parameters**:
- `follow_up_status`: pending|contacted|member_invited
- `start_date`: YYYY-MM-DD
- `end_date`: YYYY-MM-DD
- `page`: number
- `per_page`: number

### Create Visitor
```
POST /api/v1/visitors
```

**Request Body**:
```json
{
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane@example.com",
  "phone": "+233247654321",
  "visit_date": "2024-01-15",
  "service_type": "sunday_service",
  "how_heard": "Friend",
  "notes": "Interested in Bible study"
}
```

### Update Visitor Follow-up
```
PUT /api/v1/visitors/{id}/followup
```

### Convert Visitor to Member
```
POST /api/v1/visitors/{id}/convert
```

---

## 📊 DASHBOARD ENDPOINTS

### Get Dashboard Stats
```
GET /api/v1/dashboard/stats
```

**Response**:
```json
{
  "status": "success",
  "data": {
    "total_members": 547,
    "new_members_30_days": 5,
    "financial_balance": 1370000.00,
    "upcoming_birthdays_30_days": 39,
    "service_attendance_rate": 82.5,
    "recent_visitors": 12
  }
}
```

### Get Member Demographics
```
GET /api/v1/dashboard/demographics
```

### Get Birthdays This Month
```
GET /api/v1/dashboard/birthdays?month=01&limit=50
```

---

## 📊 REPORTS ENDPOINTS

### Generate Report
```
POST /api/v1/reports/generate
```

**Request Body**:
```json
{
  "report_type": "attendance|financial|membership|visitor",
  "format": "pdf|excel|csv",
  "period": "monthly|quarterly|annual|custom",
  "start_date": "2024-01-01",
  "end_date": "2024-01-31",
  "filters": {
    "member_status": "active",
    "transaction_type": "tithe"
  }
}
```

**Response**:
```json
{
  "status": "success",
  "data": {
    "report_id": "report_123",
    "download_url": "https://api.churchms.com/reports/download/report_123",
    "expires_at": "2024-01-16T10:00:00Z"
  }
}
```

---

## 🔄 Response Formats

### Success Response
```json
{
  "status": "success",
  "data": { },
  "message": "Operation completed successfully"
}
```

### Error Response
```json
{
  "status": "error",
  "message": "User-friendly error message",
  "errors": {
    "field_name": [
      "The field is required.",
      "The field must be a valid email."
    ]
  }
}
```

### Validation Error Response (422)
```json
{
  "status": "error",
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "phone": ["The phone format is invalid."]
  }
}
```

---

## 📊 HTTP Status Codes

- `200 OK` - Success
- `201 Created` - Resource created
- `204 No Content` - Success, no response body
- `400 Bad Request` - Invalid input
- `401 Unauthorized` - Missing/invalid auth token
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found
- `409 Conflict` - Duplicate/conflict
- `422 Unprocessable Entity` - Validation failed
- `429 Too Many Requests` - Rate limit exceeded
- `500 Internal Server Error` - Server error

---

## 🚨 Rate Limiting

API endpoints are rate-limited to prevent abuse:

- **Default**: 60 requests per minute
- **Authentication endpoints**: 5 requests per minute
- **SMS endpoints**: 10 requests per hour
- **Report generation**: 10 requests per hour

Rate limit headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1642339200
```

---

## 🔒 Security Headers

All responses include security headers:
```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000; includeSubDomains
```

---

## 🧪 Testing Endpoints

### Health Check
```
GET /api/v1/health
```

**Response**:
```json
{
  "status": "healthy",
  "database": "connected",
  "cache": "connected",
  "queue": "normal"
}
```

---

## 📝 API Versioning

The API uses URL versioning:
- Current version: `/api/v1/`
- Future versions: `/api/v2/`, `/api/v3/`

Deprecated endpoints return:
```
X-API-Deprecation: true
X-API-Deprecation-Date: 2024-12-31
```

---

**Document Version**: 2.0
**Last Updated**: 2024
**Status**: Active
**Review Cycle**: Before each API change