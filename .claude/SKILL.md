# Church CMS - API Skills & Capabilities Reference

**Version**: 1.0.0
**Last Updated**: December 28, 2025

---

## 📋 Table of Contents

1. [API Overview](#api-overview)
2. [Authentication & Authorization](#authentication--authorization)
3. [Core API Capabilities](#core-api-capabilities)
4. [Mobile API Skills](#mobile-api-skills)
5. [Advanced Features](#advanced-features)
6. [Integration Capabilities](#integration-capabilities)
7. [Performance & Optimization](#performance--optimization)

---

## API Overview

### Base URLs
```
Production:   https://your-domain.com/api/v1
Staging:      https://staging.your-domain.com/api/v1
Local:        http://localhost:8000/api/v1
Mobile:       http://localhost:8000/api/mobile/v1
```

### Response Format
All API responses follow this standard structure:
```json
{
  "status": "success|error",
  "message": "Human-readable message",
  "data": { /* Response payload */ },
  "meta": { /* Pagination, etc */ }
}
```

### HTTP Status Codes
```
200 OK              - Request successful
201 Created         - Resource created
204 No Content      - Delete successful
400 Bad Request     - Invalid input
401 Unauthorized    - Authentication required
403 Forbidden       - Insufficient permissions
404 Not Found       - Resource doesn't exist
422 Unprocessable   - Validation failed
500 Server Error    - Internal error
```

---

## Authentication & Authorization

### 1. Authentication Methods

#### Laravel Sanctum (Token-Based)
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@church.com",
  "password": "SecurePassword123!",
  "device_name": "Web Browser"
}

Response:
{
  "status": "success",
  "data": {
    "user": { /* User object */ },
    "token": "1|abc123...",
    "token_type": "Bearer",
    "expires_in": 3600
  }
}
```

#### Using the Token
```http
GET /api/v1/members
Authorization: Bearer 1|abc123...
```

### 2. Role-Based Permissions

#### Available Roles
```
- Super Admin    - Full system access
- Pastor         - Ministry oversight, approvals
- Department Head - Department access
- Finance Officer - Financial operations
- Staff          - Basic operations
- Member         - Limited self-service
```

#### Permission Checking
```php
// In API requests
if (!auth()->user()->hasRole('admin')) {
    return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
}
```

### 3. Two-Factor Authentication

```http
POST /api/v1/auth/verify-2fa
Content-Type: application/json

{
  "token": "123456",
  "remember": true
}
```

---

## Core API Capabilities

### 1. Member Management API

#### List Members
```http
GET /api/v1/members?status=active&search=john&page=1&per_page=20
Authorization: Bearer {token}

Response:
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "full_name": "John Doe",
      "email": "john@example.com",
      "phone": "+233201234567",
      "status": "active",
      "shepherd": { /* Shepherd details */ },
      "service_units": [ /* Units */ ]
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 150,
    "per_page": 20
  }
}
```

#### Create Member
```http
POST /api/v1/members
Authorization: Bearer {token}
Content-Type: application/json

{
  "full_name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+233201234567",
  "date_of_birth": "1990-01-15",
  "gender": "female",
  "marital_status": "single",
  "shepherd_id": 5,
  "service_unit_ids": [1, 3]
}

Response:
{
  "status": "success",
  "message": "Member created successfully",
  "data": { /* New member object */ }
}
```

### 2. Attendance API

#### Mark Attendance (Bulk)
```http
POST /api/v1/attendance/bulk
Authorization: Bearer {token}
Content-Type: application/json

{
  "service_date": "2025-12-28",
  "service_type": "sunday_first",
  "attendance": [
    { "member_id": 1, "status": "present" },
    { "member_id": 2, "status": "present" },
    { "member_id": 3, "status": "absent" }
  ]
}
```

#### Get Attendance Reports
```http
GET /api/v1/attendance/reports?start_date=2025-01-01&end_date=2025-12-31&member_id=1
Authorization: Bearer {token}

Response:
{
  "status": "success",
  "data": {
    "attendance_rate": 85.5,
    "total_services": 52,
    "present": 44,
    "absent": 8,
    "monthly_breakdown": { /* Monthly stats */ }
  }
}
```

### 3. Financial API

#### Record Transaction
```http
POST /api/v1/transactions
Authorization: Bearer {token}
Content-Type: application/json

{
  "type": "income",
  "category": "tithe",
  "amount": 500.00,
  "member_id": 1,
  "payment_method": "mobile_money",
  "reference": "MM-123456",
  "description": "Sunday tithe"
}
```

#### Approve Transaction
```http
PUT /api/v1/transactions/{id}/approve
Authorization: Bearer {token}
Content-Type: application/json

{
  "approval_notes": "Verified and approved"
}

# Requires 'pastor' or 'admin' role
```

### 4. SMS Broadcast API

#### Send Broadcast
```http
POST /api/v1/sms/broadcast
Authorization: Bearer {token}
Content-Type: application/json

{
  "message": "Service starts at 8:00 AM tomorrow. See you there!",
  "recipient_group": "all_members",
  "schedule_at": null,  // null = send immediately
  "use_template": false
}

Response:
{
  "status": "success",
  "data": {
    "broadcast_id": 123,
    "total_recipients": 450,
    "estimated_cost": 45.00,
    "status": "queued"
  }
}
```

#### Track Delivery
```http
GET /api/v1/sms/broadcast/{id}/delivery-status
Authorization: Bearer {token}

Response:
{
  "status": "success",
  "data": {
    "total": 450,
    "sent": 445,
    "delivered": 440,
    "failed": 5,
    "pending": 5,
    "delivery_rate": 97.8
  }
}
```

---

## Mobile API Skills

### 1. Mobile Registration

#### Step 1: Request OTP
```http
POST /api/mobile/v1/register/member
Content-Type: application/json

{
  "phone": "+233201234567",
  "full_name": "John Doe",
  "email": "john@example.com"
}

Response:
{
  "status": "success",
  "message": "OTP sent to +233201234567",
  "data": {
    "registration_id": "temp-uuid-123",
    "expires_in": 300
  }
}
```

#### Step 2: Verify OTP
```http
POST /api/mobile/v1/verify-otp
Content-Type: application/json

{
  "registration_id": "temp-uuid-123",
  "otp": "123456"
}

Response:
{
  "status": "success",
  "data": {
    "user": { /* User object */ },
    "token": "mobile-token-abc",
    "verification_status": "pending_admin"
  }
}
```

### 2. QR Code Check-In

#### Generate Personal QR
```http
GET /api/mobile/v1/qr-code/personal
Authorization: Bearer {mobile-token}

Response:
{
  "status": "success",
  "data": {
    "qr_code_data": "encrypted-qr-data",
    "qr_code_image": "data:image/png;base64,...",
    "valid_until": "2025-12-28T12:00:00Z"
  }
}
```

#### Service Check-In
```http
POST /api/mobile/v1/check-in/service
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "qr_data": "scanned-service-qr-data",
  "location": {
    "latitude": 5.6037,
    "longitude": -0.1870,
    "accuracy": 15
  }
}

Response:
{
  "status": "success",
  "message": "Welcome! You're checked in",
  "data": {
    "service": "Sunday 1st Service",
    "time": "2025-12-28 08:00:00",
    "status": "checked_in"
  }
}
```

### 3. Mobile Payment

#### Initiate Payment
```http
POST /api/mobile/v1/payment/initiate
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "amount": 100.00,
  "category": "tithe",
  "payment_method": "mtn_mobile_money",
  "phone": "+233201234567"
}

Response:
{
  "status": "success",
  "data": {
    "payment_id": "pay-123",
    "checkout_url": "https://payment-gateway.com/checkout/abc",
    "reference": "CMS-PAY-123456"
  }
}
```

#### Verify Payment
```http
POST /api/mobile/v1/payment/verify
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "payment_id": "pay-123",
  "reference": "CMS-PAY-123456"
}

Response:
{
  "status": "success",
  "data": {
    "payment_status": "completed",
    "receipt_url": "https://.../receipt.pdf",
    "transaction_id": 456
  }
}
```

### 4. Equipment Management

#### Scan Equipment QR
```http
GET /api/mobile/v1/equipment/scan/{qrCode}
Authorization: Bearer {mobile-token}

Response:
{
  "status": "success",
  "data": {
    "equipment_id": 10,
    "name": "Canon Camera EOS 5D",
    "status": "available",
    "location": "Media Room",
    "last_checkout": null,
    "condition": "excellent"
  }
}
```

#### Checkout Equipment
```http
POST /api/mobile/v1/equipment/checkout
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "equipment_id": 10,
  "return_date": "2025-12-30",
  "purpose": "Sunday service recording",
  "notes": ""
}

Response:
{
  "status": "success",
  "data": {
    "checkout_id": 50,
    "security_code": "1234",
    "return_by": "2025-12-30 18:00:00"
  }
}
```

### 5. Shepherd Tools API

#### Get Flock Members
```http
GET /api/mobile/v1/shepherd/flock
Authorization: Bearer {mobile-token}

Response:
{
  "status": "success",
  "data": [
    {
      "member_id": 1,
      "full_name": "John Doe",
      "phone": "+233201234567",
      "attendance_rate": 85.5,
      "last_visit": "2025-12-20",
      "engagement_status": "committed"
    }
  ]
}
```

#### Record Visit
```http
POST /api/mobile/v1/shepherd/visit/record
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "member_id": 1,
  "visit_type": "home",
  "visit_date": "2025-12-28",
  "notes": "Discussed spiritual growth",
  "prayer_points": "Career guidance",
  "location": {
    "latitude": 5.6037,
    "longitude": -0.1870
  }
}
```

---

## Advanced Features

### 1. QR Code Management

#### Generate Service QR
```http
POST /api/v1/qr-management/generate
Authorization: Bearer {token}
Content-Type: application/json

{
  "type": "SERVICE_ATTENDANCE",
  "service_date": "2025-12-28",
  "service_type": "sunday_first",
  "service_time": "08:00",
  "activation_offset": -15,  // 15 mins before
  "expiration_offset": 30,   // 30 mins after
  "gps_required": true,
  "location_radius": 100
}

Response:
{
  "status": "success",
  "data": {
    "qr_id": "qr-uuid-123",
    "qr_image": "data:image/png;base64,...",
    "activation_time": "2025-12-28 07:45:00",
    "expiration_time": "2025-12-28 09:30:00",
    "download_url": "/qr-management/qr-uuid-123/download"
  }
}
```

#### QR Analytics
```http
GET /api/v1/qr-management/{id}/analytics
Authorization: Bearer {token}

Response:
{
  "status": "success",
  "data": {
    "total_scans": 487,
    "unique_users": 423,
    "success_rate": 94.3,
    "scan_timeline": { /* Hourly breakdown */ },
    "location_distribution": { /* GPS data */ },
    "failed_reasons": { /* Error breakdown */ }
  }
}
```

### 2. Reporting API

#### Custom Report Builder
```http
POST /api/v1/reports/custom
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Monthly Financial Summary",
  "type": "financial",
  "date_range": {
    "start": "2025-12-01",
    "end": "2025-12-31"
  },
  "fields": ["date", "category", "amount", "payment_method"],
  "filters": {
    "type": "income",
    "category": ["tithe", "offering"]
  },
  "group_by": "category",
  "format": "pdf"
}

Response:
{
  "status": "success",
  "data": {
    "report_id": 123,
    "download_url": "/reports/123/download",
    "preview_data": [ /* First 50 rows */ ]
  }
}
```

### 3. Children's Ministry API

#### Secure Check-In
```http
POST /api/mobile/v1/children/check-in
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "child_id": 10,
  "service_date": "2025-12-28",
  "service_type": "sunday_first",
  "parent_signature": "data:image/png;base64,..."
}

Response:
{
  "status": "success",
  "data": {
    "check_in_id": 50,
    "security_code": "4567",
    "class_room": "Nursery A",
    "teacher": "Mrs. Smith",
    "check_in_time": "2025-12-28 08:00:00"
  }
}
```

#### Check-Out with Security
```http
POST /api/mobile/v1/children/check-out
Authorization: Bearer {mobile-token}
Content-Type: application/json

{
  "check_in_id": 50,
  "security_code": "4567",
  "pickup_person": "John Doe",
  "pickup_signature": "data:image/png;base64,..."
}
```

### 4. Welfare Management API

#### Submit Welfare Case
```http
POST /api/v1/welfare/cases
Authorization: Bearer {token}
Content-Type: application/json

{
  "beneficiary_id": 1,
  "category": "medical",
  "description": "Emergency medical assistance needed",
  "amount_requested": 5000.00,
  "supporting_documents": ["doc1.pdf", "doc2.jpg"],
  "urgency": "high"
}

Response:
{
  "status": "success",
  "data": {
    "case_id": 15,
    "case_number": "WF-2025-00000015",
    "status": "under_review",
    "priority_score": 85
  }
}
```

---

## Integration Capabilities

### 1. Webhook Support

#### Register Webhook
```http
POST /api/v1/webhooks/register
Authorization: Bearer {token}
Content-Type: application/json

{
  "url": "https://your-app.com/webhook/church-cms",
  "events": ["member.created", "transaction.approved", "attendance.marked"],
  "secret": "your-webhook-secret"
}
```

#### Webhook Payload Example
```json
{
  "event": "member.created",
  "timestamp": "2025-12-28T10:00:00Z",
  "data": {
    "member": { /* Member object */ }
  },
  "signature": "sha256-signature"
}
```

### 2. Export API

#### Export Data
```http
POST /api/v1/export
Authorization: Bearer {token}
Content-Type: application/json

{
  "entity": "members",
  "format": "csv",
  "filters": {
    "status": "active",
    "created_after": "2025-01-01"
  },
  "fields": ["full_name", "email", "phone", "shepherd_name"]
}

Response:
{
  "status": "success",
  "data": {
    "export_id": 123,
    "status": "processing",
    "estimated_time": 30
  }
}
```

### 3. Third-Party Integrations

#### Twilio SMS
```php
// Configured in .env
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_PHONE=+1234567890

// Used automatically by SMS service
```

#### Payment Gateways
```php
// Paystack (Ghana)
PAYSTACK_PUBLIC_KEY=pk_test_xxx
PAYSTACK_SECRET_KEY=sk_test_xxx

// Flutterwave
FLUTTERWAVE_PUBLIC_KEY=FLWPUBK-xxx
FLUTTERWAVE_SECRET_KEY=FLWSECK-xxx
```

---

## Performance & Optimization

### 1. Caching

All API responses are cached where appropriate:
```
- Member lists: 5 minutes
- Dashboard stats: 5 minutes
- Reports: 10 minutes
- Church info: 1 hour
```

Use cache control headers:
```http
GET /api/v1/members
Cache-Control: max-age=300
```

### 2. Rate Limiting

```
Authenticated:  60 requests/minute
Unauthenticated: 10 requests/minute
SMS API: 10 requests/hour
```

Response headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1640000000
```

### 3. Pagination

All list endpoints support pagination:
```http
GET /api/v1/members?page=1&per_page=20

Response includes:
{
  "data": [ /* Items */ ],
  "meta": {
    "current_page": 1,
    "from": 1,
    "to": 20,
    "total": 150,
    "last_page": 8,
    "per_page": 20
  },
  "links": {
    "first": "?page=1",
    "last": "?page=8",
    "prev": null,
    "next": "?page=2"
  }
}
```

### 4. Filtering & Searching

```http
GET /api/v1/members
  ?search=john
  &status=active
  &shepherd_id=5
  &service_unit=1
  &sort_by=full_name
  &sort_order=asc
```

---

## Error Handling

### Validation Errors
```json
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."],
    "phone": ["The phone format is invalid."]
  }
}
```

### Not Found
```json
{
  "status": "error",
  "message": "Member not found",
  "error_code": "MEMBER_NOT_FOUND"
}
```

### Server Errors
```json
{
  "status": "error",
  "message": "An unexpected error occurred",
  "error_code": "INTERNAL_SERVER_ERROR",
  "request_id": "req-123456"
}
```

---

## API Versioning

Current version: **v1**

Breaking changes will result in a new API version (v2).

Non-breaking changes (additions) will be added to existing version.

---

## Support & Resources

- **Documentation**: `/docs/api`
- **API Status**: `https://status.your-church.com`
- **Support**: `api-support@your-church.com`
- **Changelog**: `CHANGELOG.md`

---

**Last Updated**: December 28, 2025
**API Version**: 1.0.0
