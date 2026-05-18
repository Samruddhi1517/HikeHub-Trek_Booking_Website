# 🏔️ HikeHub – Trek Booking System

HikeHub is a full-stack web application that enables users to explore trekking destinations, book trips, and complete secure online payments. The platform is designed with a clean, responsive interface and includes booking management, payment integration, and invoice generation.

The platform includes:
- Trek listings
- Booking system
- User authentication
- Multi-image trek galleries
- Responsive admin dashboard
- Drag & drop gallery management

---

## 🚀 Features

### 👤 User Features

- 🔍 Browse trekking adventures
- 🏕️ View trek details
- 🖼️ Trek image galleries
- 🔐 User registration & login
- 📖 Book trekking adventures
- 📱 Fully responsive design
- 🔎 Search & filter treks
- 📌 Trek details with pricing, duration & difficulty



### 🛠️ Admin Features

- 🔑 Secure admin login
- ➕ Add new treks
- ✏️ Edit trek details
- ❌ Delete treks
- 🖼️ Multi-image gallery management
- 📤 Drag & drop image upload
- ⭐ Set cover image
- 🗑️ Delete gallery images
- 🔄 Drag & reorder gallery images
- 📱 Responsive admin dashboard

---

## 🖼️ Gallery Management System

The project includes a dynamic gallery manager for each trek.

### Features:
- Multiple image uploads
- Drag & drop uploader
- Cover image selection
- Gallery reordering
- Responsive image cards
- Real-time gallery updates

---

## 🛠️ Tech Stack

| Layer    | Technology                      |
| -------- | --------------------------------|
| Frontend | HTML, CSS, JavaScript           |
| Backend  | PHP (Core PHP)                  |
| Database | MySQL                           |
| Payments | Card, NetBanking,  UPI,  Wallet |

---

## 📂 Project Structure

```
/project-root
│── list.php              # Trek listing page
│── trek.php              # Trek details page
│── book_form.php         # Booking form
│── book_action.php       # Booking handler
│── payment.php           # Razorpay payment page
│── payment_success.php   # Payment success handler
│── invoice.php           # Booking invoice
│── dashboard.php         # User bookings History
│── login.php             # User login
│── register.php          # User registration
│── logout.php            # Logout
│── db.php                # Database connection
│── header.php / footer.php
│── styles.css            # Main styles
│── /images               # Trek images
```

---

## ⚙️ Installation & Setup

### 1. Clone Repository

```bash
git clone https://github.com/Samruddhi1517/hikehub.git
cd hikehub
```

### 2. Setup Database

* Create a database:

```sql
CREATE DATABASE trek_site;
```

* Import tables (example structure):

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE treks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    location VARCHAR(100),
    duration VARCHAR(50),
    difficulty VARCHAR(50),
    price DECIMAL(10,2),
    short_desc TEXT,
    long_desc TEXT
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trek_id INT,
    user_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    travel_date DATE,
    seats INT,
    amount_paid DECIMAL(10,2),
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 3. Configure Database Connection

Edit `db.php`:

```php
$DB_HOST='localhost';
$DB_USER='root';
$DB_PASS='';
$DB_NAME='trek_site';
```

---

### 4. Run Project

* Place project in:

  * `htdocs` (XAMPP) OR
  * `www` (WAMP)

* Open in browser:

```
http://localhost/hikehub/list.php
```

---

## 🔐 Authentication

* Passwords are securely hashed using `password_hash()`
* Login uses `password_verify()`

---

## 📸 Screenshots 
**Registration Page**

<img width="1344" height="642" alt="1" src="https://github.com/user-attachments/assets/62ebfc90-5739-430a-9632-6ad400d049cd" />


---


**Login Page**

<img width="1343" height="644" alt="2" src="https://github.com/user-attachments/assets/2256f59b-2208-4495-a711-29dc4f6699a2" />


---


**Trek List Page**

<img width="1342" height="644" alt="3" src="https://github.com/user-attachments/assets/1565c51f-3109-437a-9cf0-458eac4bb9f6" />


---


**Trek Description with Gallery**

<img width="1342" height="644" alt="4" src="https://github.com/user-attachments/assets/6eab844d-6cf1-4ff1-8208-8ea883d97dc6" />


---


**Trek Booking Page**

<img width="1343" height="644" alt="5" src="https://github.com/user-attachments/assets/27112894-00f6-45ae-b409-0e298ce8af79" />


---


**Payment Page**

<img width="1341" height="644" alt="6" src="https://github.com/user-attachments/assets/497521b8-e768-4cbf-b96c-ba117fd0e9d1" />


---


**Booking Confirmed Page**

<img width="1351" height="644" alt="7" src="https://github.com/user-attachments/assets/50e6bbf4-f80b-4944-87dc-0f836b7b4b29" />


---


**Invoice Page**

<img width="1347" height="644" alt="9" src="https://github.com/user-attachments/assets/3af36eae-54ae-4e6a-91c2-fdaba0224fc9" />


---


**Booking History Page**

<img width="1358" height="644" alt="8" src="https://github.com/user-attachments/assets/dfee03bf-e09c-450a-8258-0fc7c51e2f60" />
 
---

# 🌐 Live Demo

```text
hikehub.infinityfreeapp.com
```

---

## 🚧 Future Improvements

* Booking cancellation system
* Email notifications
* API-based architecture (REST API)

---

## 👨‍💻 Author

**Samruddhi Shivtare**

* GitHub: [https://github.com/Samruddhi1517](https://github.com/samruddhi1517)





