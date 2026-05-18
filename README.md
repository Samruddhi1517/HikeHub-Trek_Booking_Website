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
| Local Development |  XAMPP |

---

## 📂 Project Structure

```
HikeHub/
│
├── admin/
│   ├── dashboard.php
│   ├── add_trek.php
│   ├── edit_trek.php
│   ├── delete_trek.php
│   ├── set_cover.php
│   ├── delete_image.php
│   ├── update_order.php
│   └── partials/
│
├── images/
├── partials/
├── css/
├── js/
│
├── db.php
├── index.php
├── list.php
├── detail.php
├── login.php
├── register.php
├── dashboard.php
└── logout.php
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

## 🎨 UI Highlights

- Airbnb-inspired design
- Modern responsive layout
- Interactive hover animations
- Drag & drop image upload
- Responsive gallery manager
- Soft blue theme UI

---

## 🔐 Authentication

* Passwords are securely hashed using `password_hash()`
* Login uses `password_verify()`

---

## 📸 Screenshots 
**Registration Page**

<img width="1343" height="645" alt="3" src="https://github.com/user-attachments/assets/20c14510-80ee-420a-b151-d0550fae08fc" />


---


**Login Page**

<img width="1345" height="644" alt="2" src="https://github.com/user-attachments/assets/9a3e6023-2b70-4d4c-aa09-62fa1891b2c0" />


---


**Trek List Page**

<img width="1339" height="644" alt="1" src="https://github.com/user-attachments/assets/42ea9c19-d5c5-4bf4-8f15-3859ea6476fc" />

---


**Trek Description with Gallery**

<img width="1343" height="643" alt="4" src="https://github.com/user-attachments/assets/bed52ad0-7f9b-4632-9767-616c38b26b7d" />


---


**Trek Booking Page**

<img width="1341" height="644" alt="5" src="https://github.com/user-attachments/assets/18168299-d94f-4220-bc7b-deb6343b0af0" />


---


**Payment Page**

<img width="1349" height="644" alt="6" src="https://github.com/user-attachments/assets/d9105365-c72d-4acc-bfe3-e82fdd562f66" />



---


**Booking Confirmed Page**

<img width="1347" height="644" alt="7" src="https://github.com/user-attachments/assets/9e27b806-2956-432e-8604-76f4c0f58529" />


---


**Invoice Page**

<img width="1345" height="644" alt="8" src="https://github.com/user-attachments/assets/90044c74-768a-4fb3-bcef-ec68d7560014" />


---


**Booking History Page**

<img width="1349" height="644" alt="9" src="https://github.com/user-attachments/assets/c37a7bc6-b98c-45bc-85f1-d520ea9a5c8d" />

 ---
 
 **Admin Login**

 <img width="1346" height="644" alt="10" src="https://github.com/user-attachments/assets/eb69e6f4-9eb5-4e01-a2bb-48e8e88b55e8" />

 ---
 
 **Admin Panel**
 
 <img width="1342" height="644" alt="11" src="https://github.com/user-attachments/assets/4a02785c-26e7-4159-a16c-1e0ffdc2dffc" />

 ---

 **Add New Trek**

 <img width="1358" height="644" alt="12" src="https://github.com/user-attachments/assets/3e509737-2c1d-4f20-b537-d5af91a27293" />

**Edit Trek**
<img width="1341" height="644" alt="13" src="https://github.com/user-attachments/assets/5d2c3034-554c-476d-af4d-70de5438c7fc" />




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





