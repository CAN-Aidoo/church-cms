# Church Management System - User Flow Logic Documentation

This document provides comprehensive user flow logic for all major system operations in the Church CMS, including decision points, state transitions, and business rules.

---

## Table of Contents

1. [Authentication & Access Control Flows](#1-authentication--access-control-flows)
2. [Member Management Flows](#2-member-management-flows)
3. [Attendance & Check-in Flows](#3-attendance--check-in-flows)
4. [Financial Transaction Flows](#4-financial-transaction-flows)
5. [Communication Flows](#5-communication-flows)
6. [Ministry-Specific Flows](#6-ministry-specific-flows)
7. [Administrative Flows](#7-administrative-flows)

---

## 1. Authentication & Access Control Flows

### 1.1 System User Login Flow

The web/desktop system uses admin-controlled access with mandatory two-factor authentication.

```mermaid
flowchart TD
    A[User Visits Login Page] --> B{Has Account?}
    B -->|No| C[Contact Admin for Account Creation]
    B -->|Yes| D[Enter Email/Username & Password]
    D --> E{Credentials Valid?}
    E -->|No| F[Increment Failed Attempts]
    F --> G{Failed >= 5?}
    G -->|Yes| H[Lock Account for 30 Minutes]
    G -->|No| I[Show Error & Retry]
    I --> D
    E -->|Yes| J[Prompt for 2FA Code]
    J --> K{2FA Valid?}
    K -->|No| L[Show 2FA Error]
    L --> J
    K -->|Yes| M{First Login?}
    M -->|Yes| N[Force Password Change]
    N --> O[Setup 2FA Method]
    O --> P[Redirect to Dashboard]
    M -->|No| P
    H --> Q[Send Lockout Notification to Admin]
```

**Business Logic:**

| Rule | Description |
|------|-------------|
| No Self-Registration | System accounts can ONLY be created by administrators |
| Mandatory 2FA | All system users must complete 2FA setup on first login |
| Account Lockout | 5 failed attempts = 30-minute lockout + admin notification |
| Session Timeout | Inactive sessions expire after 30 minutes |
| Password Policy | Min 12 chars, uppercase, lowercase, numbers, special chars |
| Password Expiry | System users must change password every 90 days |

---

### 1.2 Mobile Member Registration & Verification Flow

Mobile app allows self-registration with progressive access based on admin verification.

```mermaid
flowchart TD
    A[User Downloads Mobile App] --> B[Tap Register]
    B --> C[Enter Phone Number]
    C --> D[System Sends OTP via SMS]
    D --> E[User Enters OTP]
    E --> F{OTP Valid?}
    F -->|No| G{Attempts < 3?}
    G -->|Yes| H[Resend OTP Option]
    H --> E
    G -->|No| I[Block Registration for 1 Hour]
    F -->|Yes| J[Create Basic Profile]
    J --> K[Grant LIMITED Access]
    K --> L[Notification Sent to Admin]
    L --> M{Admin Reviews Profile}
    M --> N{Verify Identity}
    N -->|Rejected| O[Send Rejection Notice]
    N -->|Approved| P[Assign to Shepherd]
    P --> Q[Grant FULL Member Access]
    Q --> R[Send Welcome Message]

    subgraph "LIMITED Access"
        LA1[View Service Times]
        LA2[Update Own Profile]
        LA3[View Public Announcements]
        LA4[Check-in as Visitor]
    end

    subgraph "FULL Access After Verification"
        FA1[Make Tithes/Offerings]
        FA2[Register for Programs]
        FA3[Access Member Directory]
        FA4[Submit Prayer Requests]
        FA5[Use Messaging Features]
        FA6[Join Service Units]
    end
```

**Access Progression Matrix:**

| Feature | Unverified | Verified Member |
|---------|------------|-----------------|
| View service times | ✅ | ✅ |
| Update own profile | ✅ | ✅ |
| View announcements | ✅ | ✅ |
| Check-in (visitor mode) | ✅ | ✅ |
| Make financial contributions | ❌ | ✅ |
| Register for programs/events | ❌ | ✅ |
| Access member directory | ❌ | ✅ (limited) |
| Submit prayer requests | ❌ | ✅ |
| Use messaging features | ❌ | ✅ |
| Join service units | ❌ | ✅ (with leader approval) |

---

### 1.3 Password Reset Flow

```mermaid
sequenceDiagram
    participant U as User
    participant S as System
    participant E as Email/SMS

    U->>S: Click "Forgot Password"
    U->>S: Enter registered email/phone
    S->>S: Validate email/phone exists
    alt Account Found
        S->>E: Send reset link (valid 1 hour)
        S->>U: Display "Check email/SMS"
        U->>S: Click reset link
        S->>S: Validate token & expiry
        alt Token Valid
            S->>U: Show password reset form
            U->>S: Enter new password
            S->>S: Validate password policy
            S->>S: Check against last 5 passwords
            S->>U: Password updated successfully
            S->>U: Redirect to login
        else Token Invalid/Expired
            S->>U: Show error, request new link
        end
    else Account Not Found
        S->>U: Generic "If account exists, email sent"
    end
```

**Security Rules:**
- Reset links expire after 1 hour
- Tokens are single-use
- New password cannot match last 5 passwords
- Generic response prevents account enumeration

---

### 1.4 Role-Based Access Escalation Flow

```mermaid
flowchart TD
    A[Staff/Leader Needs System Access] --> B[Submit Access Request to Dept Head]
    B --> C{Dept Head Approves?}
    C -->|No| D[Request Denied - End]
    C -->|Yes| E[Forward to System Admin]
    E --> F{Admin Reviews}
    F --> G{Approve?}
    G -->|No| D
    G -->|Yes| H[Create System Account]
    H --> I[Assign Role & Permissions]
    I --> J[Generate Temporary Password]
    J --> K[Send Credentials via Secure Channel]
    K --> L[User Logs In]
    L --> M[Force Password Change]
    M --> N[Setup 2FA]
    N --> O[Access Granted Based on Role]
```

**Role Hierarchy:**

```mermaid
graph TD
    SA[Super Admin] --> P[Pastor/Clergy]
    SA --> FO[Finance Officer]
    P --> DH[Department Head]
    DH --> SUL[Service Unit Leader]
    DH --> SC[Secretary/Clerk]
    
    subgraph "System Users Only"
        SA
        P
        FO
        DH
        SUL
        SC
    end
    
    subgraph "Mobile Users"
        VM[Verified Member]
        UM[Unverified Member]
        V[Visitor]
    end
```

---

## 2. Member Management Flows

### 2.1 New Member Onboarding Flow

```mermaid
flowchart TD
    A[New Member Created/Converted] --> B[Generate Member ID]
    B --> C[Generate QR Code]
    C --> D[Assign to Shepherd Group]
    D --> E{Shepherd Capacity < 15?}
    E -->|No| F[Find Alternative Shepherd]
    F --> D
    E -->|Yes| G[Add to Shepherd's Flock]
    G --> H[Create Onboarding Checklist]
    H --> I[Schedule Orientation]
    I --> J[Send Welcome Package]
    J --> K[Notify Shepherd for Follow-up]
    
    subgraph "Onboarding Checklist"
        OC1[Complete Profile 100%]
        OC2[Attend Membership Class]
        OC3[Water Baptism if applicable]
        OC4[Join Service Unit]
        OC5[First-time Tithe]
    end
```

**Onboarding Stages:**

| Stage | Trigger | Actions |
|-------|---------|---------|
| Registration | Profile created | Generate ID, QR code, send welcome SMS |
| Assignment | Auto after creation | Assign shepherd (max 12-15 members each) |
| Orientation | Scheduled by admin | Add to orientation class |
| Integration | After orientation | Encourage service unit joining |
| Milestone | 1 year anniversary | Recognition, review engagement |

---

### 2.2 Visitor to Member Conversion Flow (5-Visit Rule)

```mermaid
flowchart TD
    A[Visitor Registers] --> B[Record Visit #1]
    B --> C[Send Welcome SMS within 24hrs]
    C --> D[Pastor Welcome Call within 48hrs]
    D --> E[Visitor Returns?]
    E -->|No| F[Follow-up after 7 days]
    F --> G{Returns within 30 days?}
    G -->|No| H[Mark as Inactive Visitor]
    G -->|Yes| E
    E -->|Yes| I[Record Visit #2, #3, #4...]
    I --> J{Visit Count >= 5?}
    J -->|No| K[Continue Tracking]
    K --> E
    J -->|Yes| L[System Triggers Conversion Prompt]
    L --> M[Pre-fill Member Registration Form]
    M --> N{Visitor Accepts?}
    N -->|No| O[Keep as Preferred Visitor]
    N -->|Yes| P[Convert to Member]
    P --> Q[Execute Onboarding Flow]
```

**Visit Tracking Logic:**

```
IF visitor.visit_count >= 5 AND visitor.status == 'active' THEN
    trigger_conversion_prompt()
    prefill_member_form(visitor.profile)
    notify_admin("Conversion candidate: " + visitor.name)
END IF

TRACK visit_history:
    - Visit date/time
    - Service type attended
    - Days between visits
    - Follow-up actions taken
```

---

### 2.3 Family Management Flow

```mermaid
flowchart TD
    A[Member Opens Family Management] --> B{Has Existing Family Unit?}
    B -->|No| C[Create New Family Unit]
    C --> D[Set as Family Head]
    B -->|Yes| E[View Family Members]
    D --> F[Add Family Members]
    E --> F
    F --> G{Member Already in System?}
    G -->|Yes| H[Link Existing Member]
    G -->|No| I[Create New Member Profile]
    I --> J[Mark as Dependent/Spouse/Child]
    H --> J
    J --> K[Enable Family Check-in]
    K --> L[Generate Family QR Code]
    
    subgraph "Family Benefits"
        FB1[Single QR for all members]
        FB2[Family attendance view]
        FB3[Combined giving statements]
        FB4[Family anniversary tracking]
    end
```

---

## 3. Attendance & Check-in Flows

### 3.1 QR Code Service Check-in Flow

```mermaid
flowchart TD
    A[Member Arrives at Service] --> B[Scan QR Code at Entrance]
    B --> C{QR Code Valid?}
    C -->|No - Expired| D[Generate New QR on App]
    D --> B
    C -->|No - Invalid| E[Manual Check-in Fallback]
    C -->|Yes| F{GPS Verification Enabled?}
    F -->|Yes| G{Within Church Radius?}
    G -->|No| H[Flag as Remote Attendance]
    G -->|Yes| I[Mark as Present - In Person]
    F -->|No| I
    H --> J[Record with GPS Location]
    I --> J
    J --> K{Family Members?}
    K -->|Yes| L[Prompt: Check-in Family?]
    L --> M{Confirm Family Check-in?}
    M -->|Yes| N[Mark All Family Present]
    M -->|No| O[Single Member Only]
    K -->|No| O
    N --> P[Display Confirmation + Seat Info]
    O --> P
    
    subgraph "Service Selection"
        SS1[1st Service]
        SS2[2nd Service]
        SS3[3rd Service]
        SS4[Special Service]
    end
```

**Check-in Business Rules:**

| Rule | Value | Description |
|------|-------|-------------|
| GPS Radius | 100 meters | Church location verification |
| QR Validity | Per service | Codes expire after service ends |
| Late Threshold | 30 minutes | After service start = marked "Late" |
| Family Check-in | Single scan | One QR checks in entire family |
| Duplicate Prevention | Session-based | Cannot check-in twice for same service |

---

### 3.2 Manual Attendance Marking Flow

```mermaid
sequenceDiagram
    participant Admin
    participant System
    participant DB as Database

    Admin->>System: Select Service Type & Date
    System->>DB: Fetch member list
    DB->>System: Return active members
    System->>Admin: Display member list with checkboxes
    
    loop For Each Member
        Admin->>System: Mark attendance status
        Note right of Admin: Present/Absent/Excused/Late/Online
    end
    
    Admin->>System: Submit attendance
    System->>System: Validate no duplicates
    System->>DB: Save attendance records
    System->>System: Calculate service statistics
    System->>Admin: Show summary (Total, Present %, etc.)
    
    alt Bulk Actions
        Admin->>System: "Mark All Present"
        System->>DB: Update all to Present
    end
```

---

### 3.3 Children's Ministry Secure Check-in/Check-out Flow

```mermaid
flowchart TD
    A[Parent Arrives with Child] --> B[Scan Parent QR or Enter Phone]
    B --> C[System Displays Registered Children]
    C --> D[Select Children to Check-in]
    D --> E[Generate Matching Security Codes]
    E --> F[Print Parent Label]
    E --> G[Print Child Label with Same Code]
    F --> H[Parent Keeps Label]
    G --> I[Child Wears Label]
    I --> J[Assign to Age-Appropriate Class]
    J --> K[Display Allergy/Medical Alerts to Teacher]
    K --> L[Child Checked In]
    
    M[Parent Returns for Pickup] --> N[Present Parent Label]
    N --> O{Security Code Matches?}
    O -->|No| P[Alert Security + Verify ID]
    P --> Q{Identity Verified?}
    Q -->|No| R[Deny Release - Contact Admin]
    Q -->|Yes| S[Manual Override with Audit Log]
    O -->|Yes| T[Release Child to Parent]
    S --> T
    T --> U[Mark Child Checked Out]
    U --> V[Send Parent Notification]
```

**Security Code Logic:**

```
FUNCTION generate_security_code():
    code = random(1000, 9999)  # 4-digit unique code
    WHILE code_exists_today(code):
        code = random(1000, 9999)
    RETURN code

CHECK-OUT VALIDATION:
    IF parent_code != child_code THEN
        log_security_alert()
        require_manual_verification()
        notify_security_team()
    END IF
```

**Age-Based Class Assignment:**

| Age Range | Class Name | Teacher Ratio |
|-----------|------------|---------------|
| 0-2 years | Nursery | 1:3 |
| 3-4 years | Toddlers | 1:4 |
| 5-6 years | Beginners | 1:6 |
| 7-9 years | Primary | 1:8 |
| 10-12 years | Juniors | 1:10 |
| 13-17 years | Teens | 1:12 |

---

## 4. Financial Transaction Flows

### 4.1 Mobile Giving Flow (Tithe/Offering)

```mermaid
flowchart TD
    A[Member Opens Mobile App] --> B[Tap "Give"]
    B --> C{Member Verified?}
    C -->|No| D[Prompt to Complete Verification]
    C -->|Yes| E[Select Giving Type]
    E --> F{Type Selected}
    F -->|Tithe| G[Pre-calculate 10% of Income Option]
    F -->|Offering| H[Enter Custom Amount]
    F -->|Pledge| I[Select Existing Pledge]
    F -->|Project| J[Select Project Campaign]
    G --> K[Enter/Confirm Amount]
    H --> K
    I --> K
    J --> K
    K --> L[Select Payment Method]
    L --> M{Payment Method}
    M -->|Mobile Money| N[Redirect to Paystack/Flutterwave]
    M -->|Card| O[Enter Card Details]
    M -->|Bank Transfer| P[Display Bank Details + Reference]
    N --> Q[Process Payment]
    O --> Q
    Q --> R{Payment Successful?}
    R -->|No| S[Show Error + Retry Option]
    R -->|Yes| T[Record Transaction]
    T --> U[Generate Digital Receipt]
    U --> V[Send Receipt via SMS/Email]
    V --> W[Update Member Giving History]
    P --> X[Manual Verification Required]
```

**Giving Categories:**

| Category | Description | Allocation |
|----------|-------------|------------|
| Tithe | 10% of income | General Fund |
| Offering | Voluntary amount | Operations |
| Pledge | Commitment payments | As specified |
| Building Fund | Construction projects | Capital |
| Missions | Evangelism support | Missions |
| Welfare | Member assistance | Welfare Fund |

---

### 4.2 Transaction Approval Workflow

```mermaid
flowchart TD
    A[Transaction Created] --> B{Amount > GHS 5,000?}
    B -->|No| C[Auto-Approve for Authorized User]
    B -->|Yes| D[Require Dual Approval]
    D --> E[First Approver Reviews]
    E --> F{First Approval?}
    F -->|Rejected| G[Transaction Rejected]
    F -->|Approved| H[Move to Second Approver]
    H --> I{Second Approval?}
    I -->|Rejected| G
    I -->|Approved| J[Transaction Approved]
    C --> K[Execute Transaction]
    J --> K
    K --> L[Update Ledger]
    L --> M[Generate Audit Trail]
    G --> N[Notify Submitter with Reason]

    subgraph "Approval Roles"
        AR1[Finance Officer - Level 1]
        AR2[Pastor/Admin - Level 2]
    end
```

**Approval Thresholds:**

| Amount Range (GHS) | Approval Required |
|--------------------|-------------------|
| 0 - 1,000 | Secretary/Clerk |
| 1,001 - 5,000 | Finance Officer |
| 5,001 - 20,000 | Finance Officer + Pastor |
| 20,001+ | Finance Officer + Pastor + Admin |

---

### 4.3 Expense Submission & Reimbursement Flow

```mermaid
sequenceDiagram
    participant Staff
    participant System
    participant Manager
    participant Finance
    participant Bank

    Staff->>System: Submit expense claim
    Staff->>System: Upload receipt photo
    System->>System: Validate receipt & category
    System->>Manager: Notify for approval
    Manager->>System: Review expense
    
    alt Approved
        Manager->>System: Approve expense
        System->>Finance: Route for payment
        Finance->>System: Verify bank details
        Finance->>Bank: Process reimbursement
        Bank->>Staff: Transfer funds
        System->>Staff: Notify payment complete
    else Rejected
        Manager->>System: Reject with reason
        System->>Staff: Notify rejection
    else More Info Needed
        Manager->>System: Request clarification
        System->>Staff: Request additional info
        Staff->>System: Provide clarification
        Manager->>System: Re-review
    end
```

---

## 5. Communication Flows

### 5.1 SMS Broadcast Flow

```mermaid
flowchart TD
    A[Admin Opens SMS Broadcast] --> B[Compose Message]
    B --> C{Character Count}
    C -->|<= 160| D[Single SMS]
    C -->|> 160| E[Multi-SMS with Indicator]
    D --> F[Select Recipients]
    E --> F
    F --> G{Recipient Group}
    G -->|All Members| H[Fetch all active phones]
    G -->|Specific Group| I[Filter by criteria]
    G -->|Custom List| J[Manual selection]
    H --> K[Preview Recipients]
    I --> K
    J --> K
    K --> L[Calculate Cost]
    L --> M{Sufficient Credits?}
    M -->|No| N[Show Credit Purchase Option]
    M -->|Yes| O{Schedule?}
    O -->|Now| P[Send Immediately]
    O -->|Later| Q[Add to Queue]
    P --> R[Process via Twilio]
    Q --> R
    R --> S[Track Delivery Status]
    S --> T{Delivery Report}
    T -->|Delivered| U[Mark Success]
    T -->|Failed| V[Queue for Retry]
    V --> W{Retry Count < 3?}
    W -->|Yes| R
    W -->|No| X[Mark Failed - Notify Admin]
```

**Message Template Variables:**

| Variable | Description | Example |
|----------|-------------|---------|
| `{{first_name}}` | Member's first name | John |
| `{{last_name}}` | Member's last name | Doe |
| `{{service_time}}` | Next service time | 9:00 AM |
| `{{event_name}}` | Event title | Youth Conference |
| `{{event_date}}` | Event date | 25th January |
| `{{church_name}}` | Church name | Grace Chapel |

---

### 5.2 Birthday/Anniversary Automation Flow

```mermaid
flowchart TD
    A[12:00 AM Daily Job Runs] --> B[Query Today's Birthdays]
    B --> C{Any Birthdays?}
    C -->|No| D[Check Anniversaries]
    C -->|Yes| E[For Each Celebrant]
    E --> F[Load Birthday Template]
    F --> G[Personalize Message]
    G --> H[Send SMS]
    H --> I[Send Email with E-Card]
    I --> J[Add to Service Announcements]
    J --> K[Notify Pastor]
    K --> L{Milestone Birthday?}
    L -->|Yes - 50, 60, 70...| M[Flag for Special Recognition]
    L -->|No| D
    M --> D
    D --> N{Any Anniversaries?}
    N -->|No| O[Job Complete]
    N -->|Yes| P[Process Wedding Anniversaries]
    P --> Q[Process Membership Anniversaries]
    Q --> O
```

**Milestone Configuration:**

| Event | Milestone Years | Special Actions |
|-------|-----------------|-----------------|
| Birthday | 18, 21, 50, 60, 70, 80+ | Certificate, special prayer |
| Wedding Anniversary | 25, 50 | Recognition in service |
| Membership | 5, 10, 25, 50 | Award, certificate |

---

### 5.3 Prayer Request Submission & Response Flow

```mermaid
flowchart TD
    A[Member Submits Prayer Request] --> B{Anonymous?}
    B -->|Yes| C[Mask Submitter Identity]
    B -->|No| D[Include Submitter Name]
    C --> E[Categorize Request]
    D --> E
    E --> F[Set Urgency Level]
    F --> G{Privacy Level}
    G -->|Public| H[Add to Prayer List]
    G -->|Prayer Team Only| I[Notify Prayer Warriors]
    G -->|Pastoral Only| J[Route to Pastor]
    H --> K[Assign to Intercessors]
    I --> K
    J --> L[Pastor Reviews]
    K --> M[Intercessors Pray]
    M --> N[Log Prayer Updates]
    N --> O{Answered?}
    O -->|Yes| P[Mark as Answered]
    P --> Q[Collect Testimony]
    Q --> R{Share Testimony?}
    R -->|Yes| S[Add to Testimonies]
    R -->|No| T[Archive]
    O -->|No| U{Still Active?}
    U -->|Yes| M
    U -->|No| T
    L --> V{Requires Counselling?}
    V -->|Yes| W[Schedule Counselling Session]
    V -->|No| K
```

**Request Categories & Assignment:**

| Category | Priority Score | Default Assignees |
|----------|---------------|-------------------|
| Health/Healing | High | 3 intercessors |
| Family | Medium | 2 intercessors |
| Financial | Medium | 2 intercessors |
| Spiritual Growth | Normal | 1 intercessor |
| Career/Work | Normal | 1 intercessor |
| Emergency | Urgent | All available + Pastor |

---

## 6. Ministry-Specific Flows

### 6.1 Shepherd Flock Management Flow

```mermaid
flowchart TD
    A[Shepherd Opens App] --> B[View Flock Dashboard]
    B --> C{Action?}
    C -->|View Members| D[Display Flock List]
    D --> E[Member Details with Quick Actions]
    C -->|Record Visit| F[Select Member to Visit]
    F --> G[Navigate to Member Home]
    G --> H[GPS Check-in at Location]
    H --> I{Within Member Address Radius?}
    I -->|No| J[Flag Unverified Visit]
    I -->|Yes| K[Confirm Visit Location]
    J --> L[Complete Visit Report]
    K --> L
    L --> M[Record Prayer Points]
    M --> N[Schedule Follow-up]
    N --> O[Submit Report]
    C -->|Schedule Meeting| P[Create Flock Meeting]
    P --> Q[Set Date/Time/Venue]
    Q --> R[Notify All Flock Members]
    C -->|Send Message| S[Compose SMS]
    S --> T[Send to All Flock]

    subgraph "Flock Dashboard Metrics"
        FD1[Flock Size: 12/15]
        FD2[Attendance Rate: 85%]
        FD3[Visits This Month: 8]
        FD4[Pending Follow-ups: 3]
    end
```

**Shepherd Performance Metrics:**

| Metric | Target | Calculation |
|--------|--------|-------------|
| Flock Attendance | > 80% | Flock present / Total flock members |
| Visitation Rate | 1 per member/month | Visits completed / Members |
| Report Submission | 100% weekly | Reports submitted on time |
| Member Retention | > 95% | Active members / Total assigned |

---

### 6.2 Service Unit Duty Roster Flow

```mermaid
flowchart TD
    A[Unit Leader Opens Roster Management] --> B[Select Service Date Range]
    B --> C[View Available Members]
    C --> D{Auto-Generate Roster?}
    D -->|Yes| E[Apply Rotation Algorithm]
    E --> F[Check Member Availability]
    F --> G[Assign Positions]
    D -->|No| H[Manual Assignment]
    H --> G
    G --> I[Preview Roster]
    I --> J{Conflicts Detected?}
    J -->|Yes| K[Highlight Conflicts]
    K --> L[Resolve Manually]
    L --> I
    J -->|No| M[Save Draft Roster]
    M --> N{Publish?}
    N -->|Yes| O[Send Notifications to All]
    O --> P[Enable Swap Requests]
    N -->|No| Q[Keep as Draft]

    subgraph "Rotation Algorithm"
        RA1[Balance duty frequency]
        RA2[Respect availability]
        RA3[Consider skill requirements]
        RA4[Avoid back-to-back duties]
    end
```

**Duty Swap Request Flow:**

```mermaid
sequenceDiagram
    participant M1 as Member A
    participant S as System
    participant M2 as Member B
    participant L as Unit Leader

    M1->>S: Request duty swap
    S->>M2: Notify swap request
    M2->>S: Accept/Decline
    alt Accepted
        S->>L: Notify for approval
        L->>S: Approve swap
        S->>S: Update roster
        S->>M1: Confirm swap
        S->>M2: Confirm swap
    else Declined
        S->>M1: Notify declined
        M1->>S: Find different partner
    end
```

---

### 6.3 Counselling Session Booking Flow

```mermaid
flowchart TD
    A[Member Requests Counselling] --> B[Select Issue Category]
    B --> C[Set Urgency Level]
    C --> D[Choose Communication Mode]
    D --> E{Specific Counsellor Preference?}
    E -->|Yes| F[Check Counsellor Availability]
    E -->|No| G[Auto-Match Based on Specialty]
    F --> H{Available Slots?}
    G --> H
    H -->|No| I[Show Alternative Counsellors]
    I --> F
    H -->|Yes| J[Select Time Slot]
    J --> K[Submit Booking Request]
    K --> L[Counsellor Notified]
    L --> M{Counsellor Confirms?}
    M -->|No| N[Suggest Alternative Times]
    N --> J
    M -->|Yes| O[Session Confirmed]
    O --> P[Send Reminders]
    P --> Q[Day of Session]
    Q --> R[Conduct Session]
    R --> S[Record Encrypted Notes]
    S --> T{Follow-up Needed?}
    T -->|Yes| U[Schedule Next Session]
    T -->|No| V[Close Session]
```

**Counsellor Matching Logic:**

```
FUNCTION match_counsellor(request):
    candidates = get_counsellors_by_specialty(request.category)
    
    # Apply filters
    IF request.gender_preference:
        candidates = filter_by_gender(candidates, request.gender_preference)
    
    IF request.language:
        candidates = filter_by_language(candidates, request.language)
    
    # Sort by workload (fewer active cases = higher priority)
    candidates = sort_by_workload(candidates, ascending=True)
    
    # Return top available counsellor
    FOR counsellor IN candidates:
        IF has_available_slot(counsellor, request.preferred_times):
            RETURN counsellor
    
    RETURN None  # No match found
```

---

### 6.4 Welfare Case Management Flow

```mermaid
flowchart TD
    A[Case Submitted] --> B[Initial Review]
    B --> C[Assign Case Worker]
    C --> D[Home Visitation]
    D --> E[Collect Documentation]
    E --> F[Financial Assessment]
    F --> G[Calculate Priority Score]
    G --> H{Score >= Threshold?}
    H -->|No| I[Recommend Rejection]
    H -->|Yes| J[Prepare Recommendation]
    I --> K[Welfare Committee Review]
    J --> K
    K --> L{Committee Decision}
    L -->|Rejected| M[Notify Applicant with Reason]
    L -->|Approved| N[Allocate Funds]
    N --> O[Disburse Assistance]
    O --> P[Track Beneficiary Progress]
    P --> Q{Case Goals Met?}
    Q -->|No| R[Continue Support]
    R --> P
    Q -->|Yes| S[Graduate from Program]
    S --> T[Collect Testimony]
```

**Priority Scoring Algorithm:**

| Factor | Weight | Score Range |
|--------|--------|-------------|
| Urgency | 30% | 1-10 |
| Financial Need | 25% | 1-10 |
| Family Situation | 20% | 1-10 |
| Church Involvement | 15% | 1-10 |
| Prior Assistance | 10% | 1-10 (inverse) |

```
PRIORITY_SCORE = (Urgency * 0.30) + (FinancialNeed * 0.25) + 
                 (FamilySituation * 0.20) + (ChurchInvolvement * 0.15) + 
                 ((10 - PriorAssistance) * 0.10)

THRESHOLD = 6.0  // Minimum score for approval consideration
```

---

### 6.5 Program/Event Registration Flow

```mermaid
flowchart TD
    A[Program Published] --> B[Member Views Program]
    B --> C{Registration Required?}
    C -->|No| D[Open Attendance - Just Show Up]
    C -->|Yes| E{Registration Open?}
    E -->|No| F[Show Registration Dates]
    E -->|Yes| G{Member Eligible?}
    G -->|No| H[Show Eligibility Requirements]
    G -->|Yes| I{Fee Required?}
    I -->|No| J[Simple Registration Form]
    I -->|Yes| K[Registration + Payment Form]
    J --> L[Submit Registration]
    K --> M[Process Payment]
    M --> N{Payment Successful?}
    N -->|No| O[Show Payment Error]
    O --> K
    N -->|Yes| L
    L --> P{Capacity Available?}
    P -->|No| Q[Add to Waitlist]
    P -->|Yes| R[Confirm Registration]
    R --> S[Generate QR Ticket]
    S --> T[Send Confirmation]
    Q --> U[Notify When Spot Opens]
    U --> V{Accept Spot?}
    V -->|Yes| R
    V -->|No| W[Remove from Waitlist]
```

**Registration State Machine:**

```mermaid
stateDiagram-v2
    [*] --> Browsing
    Browsing --> Registering : Click Register
    Registering --> PaymentPending : Fee Required
    Registering --> Registered : No Fee
    PaymentPending --> Registered : Payment Success
    PaymentPending --> PaymentFailed : Payment Error
    PaymentFailed --> PaymentPending : Retry
    PaymentFailed --> Cancelled : Give Up
    Registered --> CheckedIn : Scan QR at Event
    Registered --> NoShow : Event Ends Without Check-in
    Registered --> Waitlisted : Capacity Full
    Waitlisted --> Registered : Spot Opens
    CheckedIn --> Completed : Event Ends
    Completed --> [*]
    NoShow --> [*]
    Cancelled --> [*]
```

---

## 7. Administrative Flows

### 7.1 Report Generation & Scheduling Flow

```mermaid
flowchart TD
    A[Admin Opens Reports Module] --> B{Report Type}
    B -->|Standard Report| C[Select Report Category]
    C --> D[Set Date Range & Filters]
    D --> E[Generate Report]
    B -->|Custom Report| F[Open Report Builder]
    F --> G[Drag-Drop Fields]
    G --> H[Configure Filters]
    H --> I[Add Calculations]
    I --> J[Preview Report]
    J --> K{Save as Template?}
    K -->|Yes| L[Save Template]
    K -->|No| E
    L --> E
    E --> M[View Report Results]
    M --> N{Export?}
    N -->|PDF| O[Generate PDF]
    N -->|Excel| P[Generate Excel]
    N -->|CSV| Q[Generate CSV]
    N -->|Schedule| R[Configure Schedule]
    R --> S[Set Frequency]
    S --> T[Add Recipients]
    T --> U[Save Schedule]
    U --> V[Auto-Generate & Email]
```

**Report Scheduling Options:**

| Frequency | Trigger | Use Case |
|-----------|---------|----------|
| Daily | 6:00 AM | Attendance summary |
| Weekly | Sunday 11:59 PM | Weekly giving report |
| Monthly | 1st of month | Financial statements |
| Quarterly | End of quarter | Performance review |
| Annual | January 1st | Year-end summary |

---

### 7.2 QR Code Management Flow

```mermaid
flowchart TD
    A[Admin Opens QR Management] --> B{Action}
    B -->|Generate New| C[Select QR Type]
    C --> D{QR Type}
    D -->|Member| E[Select Member]
    D -->|Service| F[Configure Service QR]
    D -->|Equipment| G[Select Equipment]
    D -->|Event| H[Select Event]
    E --> I[Set Expiry Options]
    F --> I
    G --> I
    H --> I
    I --> J{Expiry Type}
    J -->|Never| K[Generate Permanent QR]
    J -->|Time-Limited| L[Set Expiry Date/Time]
    J -->|One-Time Use| M[Generate Single-Use QR]
    K --> N[Generate & Store QR]
    L --> N
    M --> N
    N --> O[Download/Print Options]
    B -->|Revoke| P[Search Existing QR]
    P --> Q[Select QR to Revoke]
    Q --> R[Confirm Revocation]
    R --> S[Mark QR as Invalid]
    S --> T[Audit Log Entry]
    B -->|View Analytics| U[Display QR Scan Statistics]
```

**QR Code Types & Uses:**

| QR Type | Purpose | Typical Expiry |
|---------|---------|----------------|
| Member QR | Attendance check-in | Never (tied to member) |
| Service QR | Service attendance | End of service |
| Equipment QR | Asset tracking | Never |
| Event QR | Event registration/check-in | Event end date |
| Payment QR | Mobile giving link | Never |

---

### 7.3 Equipment Check-out/Return Flow

```mermaid
flowchart TD
    A[Staff Scans Equipment QR] --> B[Display Equipment Details]
    B --> C{Equipment Status}
    C -->|Available| D[Show Checkout Form]
    C -->|Checked Out| E[Show Current Borrower]
    C -->|Maintenance| F[Show Maintenance Schedule]
    D --> G[Enter Checkout Details]
    G --> H[Expected Return Date]
    H --> I[Confirm Checkout]
    I --> J[Update Equipment Status]
    J --> K[Send Confirmation to Borrower]
    E --> L{Same Borrower Returning?}
    L -->|Yes| M[Process Return]
    L -->|No| N[Contact Current Borrower]
    M --> O[Scan Equipment QR Again]
    O --> P[Condition Check]
    P --> Q{Condition OK?}
    Q -->|Yes| R[Mark as Available]
    Q -->|No| S[Report Damage]
    S --> T[Create Maintenance Request]
    T --> U[Mark as Under Maintenance]
    R --> V[Send Return Confirmation]
    U --> V
```

**Equipment Checkout Rules:**

```
MAX_CHECKOUT_DAYS = 7
OVERDUE_REMINDER_DAYS = [1, 3, 5]  # Days after due date

FUNCTION check_overdue_items():
    FOR item IN checked_out_equipment:
        IF item.due_date < today():
            days_overdue = today() - item.due_date
            IF days_overdue IN OVERDUE_REMINDER_DAYS:
                send_reminder(item.borrower)
            IF days_overdue > 7:
                escalate_to_admin(item)
```

---

### 7.4 System Backup & Recovery Flow

```mermaid
flowchart TD
    A[Admin Opens Backup Settings] --> B{Action}
    B -->|Manual Backup| C[Select Backup Type]
    C --> D{Backup Scope}
    D -->|Full| E[Database + Files + Config]
    D -->|Database Only| F[Database Dump]
    D -->|Files Only| G[Media & Documents]
    E --> H[Start Backup Process]
    F --> H
    G --> H
    H --> I[Compress & Encrypt]
    I --> J[Store Backup File]
    J --> K{Cloud Upload?}
    K -->|Yes| L[Upload to AWS S3]
    K -->|No| M[Local Storage Only]
    L --> N[Backup Complete]
    M --> N
    
    B -->|Schedule Backup| O[Configure Schedule]
    O --> P[Set Frequency]
    P --> Q[Set Retention Policy]
    Q --> R[Enable Auto-Delete Old Backups]
    
    B -->|Restore| S[List Available Backups]
    S --> T[Select Backup to Restore]
    T --> U[Verify Backup Integrity]
    U --> V{Integrity OK?}
    V -->|No| W[Backup Corrupted - Use Different]
    V -->|Yes| X[Confirm Restore]
    X --> Y[⚠️ Current Data Will Be Overwritten]
    Y --> Z[Execute Restore]
    Z --> AA[Verify Restored Data]
```

**Backup Retention Policy:**

| Backup Type | Frequency | Retention |
|-------------|-----------|-----------|
| Daily | Every day at 2:00 AM | 7 days |
| Weekly | Every Sunday 3:00 AM | 4 weeks |
| Monthly | 1st of month 4:00 AM | 12 months |
| Annual | January 1st 5:00 AM | 7 years |

---

## Summary: Key Decision Points

| Flow Category | Critical Decision | Business Impact |
|---------------|-------------------|-----------------|
| Authentication | Failed attempts >= 5 | Account lockout, admin notification |
| Member Registration | Admin verification | Access level (limited vs full) |
| Attendance | GPS verification | In-person vs remote attendance |
| Financial | Amount > GHS 5,000 | Single vs dual approval required |
| Children's Ministry | Security code match | Child release or security alert |
| Visitor Tracking | Visit count >= 5 | Conversion prompt triggered |
| Welfare | Priority score >= 6.0 | Case approved for committee review |
| Equipment | Condition check fail | Maintenance workflow triggered |

---

## Related Documentation

- [API Documentation](file:///c:/xampp/htdocs/church-cms-docs/SKILL.md)
- [Authentication System](file:///c:/xampp/htdocs/church-cms-docs/docs/project-documentation/06_AUTHENTICATION_COMPLETE.md)
- [Feature Modules](file:///c:/xampp/htdocs/church-cms-docs/docs/project-documentation/07_FEATURE_MODULES_UPDATED.md)
- [Database Design](file:///c:/xampp/htdocs/church-cms-docs/docs/project-documentation/03_DATABASE_DESIGN.md)

---

**Document Version**: 1.0  
**Last Updated**: January 13, 2026  
**Author**: System Documentation
