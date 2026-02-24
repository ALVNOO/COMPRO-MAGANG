# High-Level Architecture Diagram
## Sistem Penerimaan Magang - PT Telkom Indonesia

Diagram ini menunjukkan arsitektur sistem secara keseluruhan dari level tinggi.

---

## High-Level Architecture Diagram

```mermaid
graph TB
    subgraph "Client Layer"
        A[Web Browser<br/>Chrome, Firefox, Safari]
        A1[Mobile Browser<br/>Responsive Design]
    end
    
    subgraph "Presentation Layer"
        B[Blade Templates<br/>Views]
        B1[CSS Framework<br/>Bootstrap]
        B2[JavaScript<br/>Vanilla JS + Chart.js]
        B3[Vite Assets<br/>Build System]
    end
    
    subgraph "Application Layer - Laravel Framework"
        C[Routing Layer<br/>routes/web.php]
        C1[Middleware<br/>Auth, CSRF, 2FA]
        C2[Controllers<br/>Business Logic]
        C3[Validation<br/>Request Validation]
    end
    
    subgraph "Business Logic Layer"
        D[Models<br/>Eloquent ORM]
        D1[Services<br/>File Processing]
        D2[Mail Services<br/>Email Notifications]
        D3[PDF Services<br/>DomPDF]
        D4[Excel Services<br/>Maatwebsite Excel]
        D5[QR Code Services<br/>SimpleSoftwareIO]
    end
    
    subgraph "Data Access Layer"
        E[Eloquent ORM<br/>Database Abstraction]
        E1[Query Builder<br/>Complex Queries]
        E2[File Storage<br/>Laravel Storage]
    end
    
    subgraph "Data Persistence Layer"
        F[(SQLite Database<br/>Primary Data Store)]
        F1[File System<br/>Storage/app/public]
        F2[File System<br/>Storage/app/private]
        F3[Cache<br/>Session & Application Cache]
        F4[Logs<br/>Laravel Log Files]
    end
    
    subgraph "External Services"
        G[Email Service<br/>SMTP/Mail Driver]
        G1[PDF Generator<br/>DomPDF Library]
        G2[Excel Export<br/>PhpSpreadsheet]
        G3[QR Code<br/>Bacon QR Code]
        G4[2FA Service<br/>Google2FA]
    end
    
    subgraph "Security Layer"
        H[Authentication<br/>Session-based]
        H1[Authorization<br/>Role-based Access]
        H2[2FA<br/>Two-Factor Auth]
        H3[CSRF Protection<br/>Token-based]
        H4[Password Hashing<br/>bcrypt]
    end
    
    A --> B
    A1 --> B
    B --> B1
    B --> B2
    B --> B3
    
    B --> C
    C --> C1
    C1 --> C2
    C2 --> C3
    
    C2 --> D
    D --> D1
    D --> D2
    D --> D3
    D --> D4
    D --> D5
    
    D --> E
    E --> E1
    D1 --> E2
    
    E --> F
    E1 --> F
    E2 --> F1
    E2 --> F2
    C1 --> F3
    C2 --> F4
    
    D2 --> G
    D3 --> G1
    D4 --> G2
    D5 --> G3
    C1 --> G4
    
    C1 --> H
    C2 --> H1
    C1 --> H2
    C1 --> H3
    H --> H4
    
    style A fill:#e1f5ff
    style A1 fill:#e1f5ff
    style B fill:#fff4e1
    style B1 fill:#fff4e1
    style B2 fill:#fff4e1
    style B3 fill:#fff4e1
    style C fill:#e8f5e9
    style C1 fill:#e8f5e9
    style C2 fill:#e8f5e9
    style C3 fill:#e8f5e9
    style D fill:#f3e5f5
    style D1 fill:#f3e5f5
    style D2 fill:#f3e5f5
    style D3 fill:#f3e5f5
    style D4 fill:#f3e5f5
    style D5 fill:#f3e5f5
    style E fill:#fce4ec
    style E1 fill:#fce4ec
    style E2 fill:#fce4ec
    style F fill:#fff9c4
    style F1 fill:#fff9c4
    style F2 fill:#fff9c4
    style F3 fill:#fff9c4
    style F4 fill:#fff9c4
    style G fill:#e0f2f1
    style G1 fill:#e0f2f1
    style G2 fill:#e0f2f1
    style G3 fill:#e0f2f1
    style G4 fill:#e0f2f1
    style H fill:#ffebee
    style H1 fill:#ffebee
    style H2 fill:#ffebee
    style H3 fill:#ffebee
    style H4 fill:#ffebee
```

---

## Arsitektur MVC (Model-View-Controller)

```mermaid
graph LR
    subgraph "MVC Architecture"
        subgraph "Model Layer"
            M1[User Model]
            M2[InternshipApplication Model]
            M3[Assignment Model]
            M4[Certificate Model]
            M5[Attendance Model]
            M6[Logbook Model]
        end
        
        subgraph "View Layer"
            V1[Auth Views<br/>login, register, 2fa]
            V2[Dashboard Views<br/>peserta, mentor, admin]
            V3[Admin Views<br/>management, reports]
            V4[Mentor Views<br/>penugasan, sertifikat]
            V5[Peserta Views<br/>status, tugas, absensi]
        end
        
        subgraph "Controller Layer"
            C1[AuthController<br/>Authentication]
            C2[DashboardController<br/>Peserta Dashboard]
            C3[AdminController<br/>Admin Functions]
            C4[MentorDashboardController<br/>Mentor Functions]
            C5[AttendanceController<br/>Absensi]
            C6[LogbookController<br/>Logbook]
        end
        
        subgraph "Database"
            DB[(SQLite<br/>Database)]
        end
    end
    
    C1 --> M1
    C2 --> M2
    C2 --> M3
    C3 --> M2
    C4 --> M2
    C4 --> M3
    C4 --> M4
    C5 --> M5
    C6 --> M6
    
    M1 --> DB
    M2 --> DB
    M3 --> DB
    M4 --> DB
    M5 --> DB
    M6 --> DB
    
    C1 --> V1
    C2 --> V2
    C2 --> V5
    C3 --> V3
    C4 --> V4
    C5 --> V5
    C6 --> V5
    
    style M1 fill:#e3f2fd
    style M2 fill:#e3f2fd
    style M3 fill:#e3f2fd
    style M4 fill:#e3f2fd
    style M5 fill:#e3f2fd
    style M6 fill:#e3f2fd
    style V1 fill:#fff3e0
    style V2 fill:#fff3e0
    style V3 fill:#fff3e0
    style V4 fill:#fff3e0
    style V5 fill:#fff3e0
    style C1 fill:#e8f5e9
    style C2 fill:#e8f5e9
    style C3 fill:#e8f5e9
    style C4 fill:#e8f5e9
    style C5 fill:#e8f5e9
    style C6 fill:#e8f5e9
    style DB fill:#fff9c4
```

---

## Arsitektur Request-Response Flow

```mermaid
sequenceDiagram
    participant U as User/Browser
    participant R as Router
    participant M as Middleware
    participant C as Controller
    participant V as View
    participant Mo as Model
    participant D as Database
    participant S as Services
    
    U->>R: HTTP Request
    R->>M: Route Matching
    M->>M: Auth Check
    M->>M: CSRF Check
    M->>M: 2FA Check (if needed)
    M->>C: Forward Request
    C->>C: Validate Request
    C->>Mo: Business Logic
    Mo->>D: Query Database
    D-->>Mo: Return Data
    Mo-->>C: Return Model
    C->>S: External Services (if needed)
    S-->>C: Return Result
    C->>V: Prepare View Data
    V->>V: Render Template
    V-->>C: Return HTML
    C-->>M: Return Response
    M-->>R: Forward Response
    R-->>U: HTTP Response
```

---

## Component Diagram

```mermaid
graph TD
    subgraph "Core Components"
        A[Laravel Framework<br/>v12.0]
        A1[Eloquent ORM]
        A2[Blade Engine]
        A3[Routing System]
        A4[Middleware System]
    end
    
    subgraph "Application Components"
        B[Controllers<br/>9 Controllers]
        B1[Models<br/>14 Models]
        B2[Views<br/>Blade Templates]
        B3[Middleware<br/>Auth, CSRF]
    end
    
    subgraph "Service Components"
        C[PDF Service<br/>DomPDF]
        C1[Excel Service<br/>Maatwebsite Excel]
        C2[QR Code Service<br/>SimpleSoftwareIO]
        C3[2FA Service<br/>Google2FA]
        C4[File Storage<br/>Laravel Storage]
        C5[Email Service<br/>Laravel Mail]
    end
    
    subgraph "Data Components"
        D[Database<br/>SQLite]
        D1[File Storage<br/>Local Storage]
        D2[Cache<br/>File Cache]
        D3[Sessions<br/>File Session]
    end
    
    A --> A1
    A --> A2
    A --> A3
    A --> A4
    
    A3 --> B
    A1 --> B1
    A2 --> B2
    A4 --> B3
    
    B --> C
    B --> C1
    B --> C2
    B --> C3
    B --> C4
    B --> C5
    
    B1 --> D
    C4 --> D1
    A --> D2
    A --> D3
    
    style A fill:#4caf50
    style A1 fill:#4caf50
    style A2 fill:#4caf50
    style A3 fill:#4caf50
    style A4 fill:#4caf50
    style B fill:#2196f3
    style B1 fill:#2196f3
    style B2 fill:#2196f3
    style B3 fill:#2196f3
    style C fill:#ff9800
    style C1 fill:#ff9800
    style C2 fill:#ff9800
    style C3 fill:#ff9800
    style C4 fill:#ff9800
    style C5 fill:#ff9800
    style D fill:#9c27b0
    style D1 fill:#9c27b0
    style D2 fill:#9c27b0
    style D3 fill:#9c27b0
```

---

## Deployment Architecture

```mermaid
graph TB
    subgraph "Client Side"
        A[User Browser]
    end
    
    subgraph "Web Server"
        B[Nginx/Apache<br/>HTTP Server]
        B1[PHP-FPM<br/>PHP Processor]
    end
    
    subgraph "Application Server"
        C[Laravel Application<br/>PHP Application]
        C1[Storage Directory<br/>File Storage]
        C2[Public Directory<br/>Assets]
    end
    
    subgraph "Database Server"
        D[(SQLite Database<br/>database.sqlite)]
    end
    
    subgraph "File System"
        E[storage/app/public<br/>Public Files]
        E1[storage/app/private<br/>Private Files]
        E2[storage/logs<br/>Log Files]
    end
    
    A -->|HTTP/HTTPS| B
    B -->|FastCGI| B1
    B1 -->|Execute| C
    C -->|Read/Write| D
    C -->|Read/Write| E
    C -->|Read/Write| E1
    C -->|Write| E2
    C -->|Serve| C2
    C -->|Store| C1
    
    style A fill:#e1f5ff
    style B fill:#fff4e1
    style B1 fill:#fff4e1
    style C fill:#e8f5e9
    style C1 fill:#e8f5e9
    style C2 fill:#e8f5e9
    style D fill:#fff9c4
    style E fill:#f3e5f5
    style E1 fill:#f3e5f5
    style E2 fill:#f3e5f5
```

---

## Technology Stack

| Layer | Technology | Version | Purpose |
|-------|-----------|---------|---------|
| **Framework** | Laravel | 12.0 | PHP Web Framework |
| **Database** | SQLite | 3.x | Primary Database |
| **Template Engine** | Blade | Laravel | Server-side Rendering |
| **CSS Framework** | Bootstrap | 5.x | UI Styling |
| **JavaScript** | Vanilla JS + Chart.js | Latest | Client-side Logic |
| **PDF Generation** | DomPDF | 3.1 | PDF Documents |
| **Excel Export** | Maatwebsite Excel | 3.1 | Excel Reports |
| **QR Code** | SimpleSoftwareIO QrCode | Latest | QR Code Generation |
| **2FA** | Google2FA (PragmaRX) | 9.0 | Two-Factor Authentication |
| **Build Tool** | Vite | Latest | Asset Bundling |
| **HTTP Server** | Nginx/Apache | Latest | Web Server |
| **PHP** | PHP | 8.2+ | Runtime |

---

**Dibuat**: 2024  
**Versi**: 1.0  
**Sistem**: Penerimaan Magang PT Telkom Indonesia

