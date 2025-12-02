# Church Management System - Database Design

## 📊 Database Overview

**Database System**: MySQL 8.0+
**Storage Engine**: InnoDB
**Character Set**: utf8mb4
**Collation**: utf8mb4_unicode_ci
**Timezone**: UTC (for all timestamps)

---

## 🗂️ Core Tables

### 1. `users`
System users with authentication and role information.

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  role ENUM('admin', 'pastor', 'staff', 'member') DEFAULT 'member',
  avatar_url VARCHAR(500),
  phone VARCHAR(20),
  is_active BOOLEAN DEFAULT TRUE,
  email_verified_at TIMESTAMP NULL,
  two_factor_secret TEXT,
  two_factor_recovery_codes TEXT,
  last_login_at TIMESTAMP NULL,
  remember_token VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX idx_users_email (email),
  INDEX idx_users_role (role),
  INDEX idx_users_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 2. `members`
Core member information and demographics.

```sql
CREATE TABLE members (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(255),
  phone VARCHAR(20),
  alternate_phone VARCHAR(20),
  date_of_birth DATE,
  gender ENUM('male', 'female', 'other', 'prefer_not_to_say'),
  marital_status VARCHAR(50),
  occupation VARCHAR(100),
  address TEXT,
  city VARCHAR(100),
  postal_code VARCHAR(20),
  country VARCHAR(100) DEFAULT 'Ghana',
  profile_photo_url VARCHAR(500),
  bio TEXT,
  join_date DATE NOT NULL,
  member_status ENUM('active', 'inactive', 'pending', 'suspended') DEFAULT 'active',
  last_contact_date DATE,
  referral_source VARCHAR(100),
  notes TEXT,
  created_by BIGINT UNSIGNED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_members_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_members_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT chk_age CHECK (date_of_birth < CURDATE()),
  CONSTRAINT chk_email_or_phone CHECK (email IS NOT NULL OR phone IS NOT NULL),
  
  INDEX idx_members_name (last_name, first_name),
  INDEX idx_members_email (email),
  INDEX idx_members_phone (phone),
  INDEX idx_members_status (member_status),
  INDEX idx_members_join_date (join_date),
  INDEX idx_members_user_id (user_id),
  FULLTEXT idx_members_search (first_name, last_name, email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3. `attendance`
Track member attendance at services and events.

```sql
CREATE TABLE attendance (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  member_id BIGINT UNSIGNED NOT NULL,
  service_date DATE NOT NULL,
  service_type ENUM('sunday_service', 'midweek', 'prayer_meeting', 'special_event', 'other') NOT NULL,
  status ENUM('present', 'absent', 'excused', 'late') DEFAULT 'absent',
  notes TEXT,
  recorded_by BIGINT UNSIGNED,
  recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_attendance_member_id FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
  CONSTRAINT fk_attendance_recorded_by FOREIGN KEY (recorded_by) REFERENCES users(id) ON DELETE SET NULL,
  UNIQUE KEY unique_attendance (member_id, service_date, service_type),
  
  INDEX idx_attendance_member (member_id),
  INDEX idx_attendance_date (service_date),
  INDEX idx_attendance_status (status),
  INDEX idx_attendance_service_type (service_type),
  INDEX idx_attendance_date_member (member_id, service_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 4. `transactions`
Financial transactions (tithes, offerings, expenses, donations).

```sql
CREATE TABLE transactions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  member_id BIGINT UNSIGNED,
  transaction_type ENUM('tithe', 'offering', 'donation', 'expense', 'other_income') NOT NULL,
  amount DECIMAL(15, 2) NOT NULL,
  currency VARCHAR(3) DEFAULT 'GHS',
  category VARCHAR(100),
  sub_category VARCHAR(100),
  description TEXT,
  payment_method ENUM('cash', 'mobile_money', 'bank_transfer', 'check', 'card', 'other'),
  reference_number VARCHAR(100),
  receipt_url VARCHAR(500),
  receipt_notes TEXT,
  transaction_date DATE NOT NULL,
  status ENUM('pending', 'completed', 'reconciled', 'disputed') DEFAULT 'completed',
  created_by BIGINT UNSIGNED NOT NULL,
  approved_by BIGINT UNSIGNED,
  approved_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_transactions_member_id FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE SET NULL,
  CONSTRAINT fk_transactions_created_by FOREIGN KEY (created_by) REFERENCES users(id),
  CONSTRAINT fk_transactions_approved_by FOREIGN KEY (approved_by) REFERENCES users(id),
  CONSTRAINT chk_amount_positive CHECK (amount > 0),
  
  INDEX idx_transactions_type (transaction_type),
  INDEX idx_transactions_date (transaction_date),
  INDEX idx_transactions_member (member_id),
  INDEX idx_transactions_status (status),
  INDEX idx_transactions_category (category),
  INDEX idx_transactions_date_type (transaction_date, transaction_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 5. `services`
Church service/event schedules.

```sql
CREATE TABLE services (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  service_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  location VARCHAR(255),
  service_type ENUM('sunday_service', 'midweek', 'prayer_meeting', 'special_event', 'class', 'other'),
  capacity INT,
  expected_attendance INT,
  speaker_name VARCHAR(255),
  topic VARCHAR(255),
  created_by BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_services_created_by FOREIGN KEY (created_by) REFERENCES users(id),
  
  INDEX idx_services_date (service_date),
  INDEX idx_services_type (service_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 6. `equipment`
Equipment and asset tracking.

```sql
CREATE TABLE equipment (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  serial_number VARCHAR(100) UNIQUE,
  model VARCHAR(100),
  purchase_date DATE,
  purchase_price DECIMAL(15, 2),
  current_value DECIMAL(15, 2),
  location VARCHAR(255),
  status ENUM('active', 'inactive', 'maintenance', 'retired') DEFAULT 'active',
  assigned_to VARCHAR(255),
  last_maintenance DATE,
  next_maintenance DATE,
  notes TEXT,
  created_by BIGINT UNSIGNED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_equipment_created_by FOREIGN KEY (created_by) REFERENCES users(id),
  
  INDEX idx_equipment_category (category),
  INDEX idx_equipment_status (status),
  INDEX idx_equipment_location (location)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 7. `visitors`
Visitor information and follow-up tracking.

```sql
CREATE TABLE visitors (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(255),
  phone VARCHAR(20),
  address TEXT,
  visit_date DATE NOT NULL,
  service_type VARCHAR(50),
  how_heard VARCHAR(100),
  follow_up_required BOOLEAN DEFAULT TRUE,
  follow_up_status ENUM('pending', 'contacted', 'member_invited', 'converted', 'no_response') DEFAULT 'pending',
  follow_up_date DATE,
  notes TEXT,
  converted_member_id BIGINT UNSIGNED,
  recorded_by BIGINT UNSIGNED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_visitors_converted FOREIGN KEY (converted_member_id) REFERENCES members(id),
  CONSTRAINT fk_visitors_recorded_by FOREIGN KEY (recorded_by) REFERENCES users(id),
  
  INDEX idx_visitors_date (visit_date),
  INDEX idx_visitors_status (follow_up_status),
  INDEX idx_visitors_email (email),
  INDEX idx_visitors_phone (phone)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 8. `sms_broadcasts`
SMS broadcast campaigns and history.

```sql
CREATE TABLE sms_broadcasts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  recipient_group VARCHAR(100),
  recipient_count INT DEFAULT 0,
  scheduled_for TIMESTAMP NULL,
  sent_at TIMESTAMP NULL,
  status ENUM('draft', 'scheduled', 'sending', 'sent', 'failed', 'cancelled') DEFAULT 'draft',
  success_count INT DEFAULT 0,
  failure_count INT DEFAULT 0,
  cost DECIMAL(15, 2),
  created_by BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_sms_broadcasts_created_by FOREIGN KEY (created_by) REFERENCES users(id),
  
  INDEX idx_sms_broadcasts_status (status),
  INDEX idx_sms_broadcasts_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 9. `sms_broadcast_recipients`
Track individual SMS delivery status.

```sql
CREATE TABLE sms_broadcast_recipients (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  broadcast_id BIGINT UNSIGNED NOT NULL,
  member_id BIGINT UNSIGNED,
  phone_number VARCHAR(20) NOT NULL,
  status ENUM('pending', 'sent', 'delivered', 'failed', 'unsubscribed') DEFAULT 'pending',
  delivery_timestamp TIMESTAMP NULL,
  twilio_message_sid VARCHAR(100),
  error_code VARCHAR(10),
  error_message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_sms_recipients_broadcast FOREIGN KEY (broadcast_id) REFERENCES sms_broadcasts(id) ON DELETE CASCADE,
  CONSTRAINT fk_sms_recipients_member FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
  
  INDEX idx_sms_recipients_broadcast (broadcast_id),
  INDEX idx_sms_recipients_status (status),
  INDEX idx_sms_recipients_member (member_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 10. `audit_logs`
Track all user actions for compliance and debugging.

```sql
CREATE TABLE audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED,
  action VARCHAR(100) NOT NULL,
  table_name VARCHAR(100),
  record_id BIGINT UNSIGNED,
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  user_agent TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  CONSTRAINT fk_audit_logs_user FOREIGN KEY (user_id) REFERENCES users(id),
  
  INDEX idx_audit_logs_user (user_id),
  INDEX idx_audit_logs_table (table_name),
  INDEX idx_audit_logs_created (created_at),
  INDEX idx_audit_logs_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🔑 Key Constraints & Relationships

```
users (1) ──────── (many) members
  │                    │
  │                    └──── (many) attendance
  │                    └──── (many) visitors
  │
  ├────── (many) transactions
  ├────── (many) sms_broadcasts
  ├────── (many) audit_logs
  └────── (many) equipment

members (1) ──────── (many) transactions
   │                    └──── (many) attendance
   │
   └──── (1) visitors (conversion reference)
```

---

## 📊 Database Views

### View: `member_attendance_summary`
Pre-computed attendance statistics for performance.

```sql
CREATE VIEW member_attendance_summary AS
SELECT 
  m.id as member_id,
  m.first_name,
  m.last_name,
  COUNT(CASE WHEN a.status = 'present' THEN 1 END) as total_present,
  COUNT(CASE WHEN a.status = 'absent' THEN 1 END) as total_absent,
  COUNT(CASE WHEN a.status = 'excused' THEN 1 END) as total_excused,
  COUNT(a.id) as total_services,
  ROUND(100.0 * COUNT(CASE WHEN a.status = 'present' THEN 1 END) / 
        NULLIF(COUNT(a.id), 0), 2) as attendance_percentage,
  MAX(a.service_date) as last_attendance_date
FROM members m
LEFT JOIN attendance a ON m.id = a.member_id
WHERE m.member_status = 'active'
GROUP BY m.id, m.first_name, m.last_name;
```

### View: `monthly_financial_summary`
Monthly financial breakdown by transaction type.

```sql
CREATE VIEW monthly_financial_summary AS
SELECT 
  DATE_FORMAT(transaction_date, '%Y-%m') as month,
  transaction_type,
  SUM(amount) as total_amount,
  COUNT(*) as transaction_count,
  AVG(amount) as average_amount,
  MIN(amount) as min_amount,
  MAX(amount) as max_amount
FROM transactions
WHERE status IN ('completed', 'reconciled')
GROUP BY DATE_FORMAT(transaction_date, '%Y-%m'), transaction_type
ORDER BY month DESC, transaction_type;
```

---

## 🔧 Stored Procedures

### Financial Summary Procedure
```sql
DELIMITER $$
CREATE PROCEDURE GetFinancialSummary(
    IN start_date DATE,
    IN end_date DATE
)
BEGIN
    SELECT 
        transaction_type,
        SUM(amount) as total,
        COUNT(*) as count,
        AVG(amount) as average
    FROM transactions
    WHERE transaction_date BETWEEN start_date AND end_date
        AND status IN ('completed', 'reconciled')
    GROUP BY transaction_type
    
    UNION ALL
    
    SELECT 
        'NET_BALANCE' as transaction_type,
        SUM(CASE 
            WHEN transaction_type IN ('tithe', 'offering', 'donation', 'other_income') 
            THEN amount 
            ELSE -amount 
        END) as total,
        NULL as count,
        NULL as average
    FROM transactions
    WHERE transaction_date BETWEEN start_date AND end_date
        AND status IN ('completed', 'reconciled');
END$$
DELIMITER ;
```

### Attendance Report Procedure
```sql
DELIMITER $$
CREATE PROCEDURE GetAttendanceReport(
    IN member_id BIGINT,
    IN start_date DATE,
    IN end_date DATE
)
BEGIN
    SELECT 
        m.first_name,
        m.last_name,
        COUNT(CASE WHEN a.status = 'present' THEN 1 END) as present_count,
        COUNT(CASE WHEN a.status = 'absent' THEN 1 END) as absent_count,
        COUNT(a.id) as total_services,
        ROUND(100.0 * COUNT(CASE WHEN a.status = 'present' THEN 1 END) / COUNT(a.id), 2) as attendance_rate
    FROM members m
    LEFT JOIN attendance a ON m.id = a.member_id
    WHERE m.id = member_id
        AND a.service_date BETWEEN start_date AND end_date
    GROUP BY m.id, m.first_name, m.last_name;
END$$
DELIMITER ;
```

---

## 🔒 Database Triggers

### Audit Log Trigger
```sql
DELIMITER $$
CREATE TRIGGER tr_members_audit
AFTER UPDATE ON members
FOR EACH ROW
BEGIN
    INSERT INTO audit_logs (user_id, action, table_name, record_id, old_values, new_values)
    VALUES (
        @current_user_id,
        'UPDATE',
        'members',
        NEW.id,
        JSON_OBJECT('status', OLD.member_status, 'email', OLD.email),
        JSON_OBJECT('status', NEW.member_status, 'email', NEW.email)
    );
END$$
DELIMITER ;
```

### Transaction Balance Update Trigger
```sql
DELIMITER $$
CREATE TRIGGER tr_transaction_update_balance
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
    IF NEW.status IN ('completed', 'reconciled') THEN
        UPDATE financial_summary 
        SET balance = balance + IF(NEW.transaction_type = 'expense', -NEW.amount, NEW.amount)
        WHERE period = DATE_FORMAT(NEW.transaction_date, '%Y-%m');
    END IF;
END$$
DELIMITER ;
```

---

## 📋 Data Validation Rules

### Members
- Email: Valid email format if provided
- Phone: Valid phone format (E.164)
- Date of Birth: Must be in the past
- Join Date: Should be ≤ today

### Transactions
- Amount: Must be positive
- Currency: Valid ISO 4217 code
- Transaction Date: Should be ≤ today
- Status transitions: draft → approved → reconciled

### Attendance
- Service Date: Should be ≤ today
- Only one attendance record per member per service

### SMS Broadcasts
- Message: Not empty, max 160 characters per SMS segment
- Recipients: At least one recipient selected
- Scheduled Time: Must be in future if scheduled status

---

## 📊 Indexing Strategy

**Indexes Created For**:
- Primary keys (automatic B-tree index)
- Foreign keys (performance benefit)
- Frequently filtered columns (status, role, type)
- Frequently joined columns (member_id, user_id)
- Date columns used in range queries
- Columns used in ORDER BY
- Full-text search fields

**Indexes NOT Created For**:
- Low cardinality columns (<10 unique values)
- Rarely filtered columns
- Very small tables
- Columns with frequent updates

---

## 🔄 Backup & Recovery

### Backup Strategy
- **Frequency**: Daily automated backups using mysqldump
- **Retention**: 30-day backup history
- **Point-in-Time Recovery**: Using binary logs
- **Geographic Redundancy**: Off-site backup storage

### Backup Script
```bash
#!/bin/bash
# Daily backup script
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="church_management"
BACKUP_DIR="/backups/mysql"

mysqldump --single-transaction --routines --triggers --events \
  -u backup_user -p${DB_PASSWORD} ${DB_NAME} | \
  gzip > ${BACKUP_DIR}/backup_${DATE}.sql.gz

# Keep only last 30 days
find ${BACKUP_DIR} -name "backup_*.sql.gz" -mtime +30 -delete
```

### Disaster Recovery
- Manual backups: Weekly to external storage
- Database export: Monthly CSV exports
- Restoration testing: Quarterly
- Recovery Time Objective (RTO): 4 hours
- Recovery Point Objective (RPO): 24 hours

---

## 📈 Performance Optimization

### Query Optimization
- Use prepared statements
- Limit result sets with pagination
- Use indexed columns in WHERE clauses
- Avoid N+1 queries with proper JOINs

### Database Tuning
```sql
-- MySQL configuration optimizations (my.cnf)
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 256M
query_cache_size = 128M
max_connections = 200
innodb_flush_log_at_trx_commit = 2
```

### Partitioning Strategy
```sql
-- Partition large tables by date
ALTER TABLE transactions
PARTITION BY RANGE (YEAR(transaction_date)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION pfuture VALUES LESS THAN MAXVALUE
);
```

---

**Document Version**: 2.0
**Last Updated**: 2024
**Status**: Active
**Review Cycle**: Before each deployment