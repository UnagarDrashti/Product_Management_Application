# Product_Management_Application

## Features
1. **Multiple Authentication Guards**
   - Separate login, registration, and dashboards for Admin and Customer users.
   - Routes protected via `auth:admin` and `auth:customer` middleware.

2. **Product Management**
   - Admin can perform CRUD operations on products.
   - Bulk import of up to 100k products using CSV/Excel (chunked processing + queues).
   - Default image applied if no image is provided.
   - Sample import file: `products_sample_import.csv`.
   - Customers can browse, search, and paginate product listings.
   - php artisan queue:work --queue=imports

3. **Order Management**
   - Customers can place orders for available products.
   - Admin can view and update order status (`Pending`, `Shipped`, `Delivered`).

4. **Real-Time Updates (WebSockets)**
   - Order status updates broadcast in real-time.


6. **Optimized Product Import**
   - Upload CSV/Excel with up to 100k products.
   - Chunked reading, validation, and queued processing to prevent timeouts.

---

## Setup Instructions

### 1. Clone Repository
- Clone the repo into your local environment.

### 2. Install Dependencies
- Install PHP dependencies using Composer.
- Install JS dependencies using NPM or Yarn.

### 3. Environment Setup
- Copy `.env.example` to `.env`.
- Configure database, Pusher (or any broadcasting service), and queue settings.
- Generate application key.

### 4. Database
- Run migrations and seeders to set up tables.

### 5. Queues
- Start queue worker for product import and order processing.
- php artisan queue:work

### 6. WebSockets
- Configure broadcasting (Pusher, Laravel WebSockets, or similar).
- Run WebSocket server if using Laravel WebSockets.

### 7. Storage
- Link storage for product images.

### 8. Run Application
- Start local development server.
- Access app via browser.

---

## Testing
- Use `php artisan test` to run the test suite.
- Includes feature and unit tests for product CRUD, order placement, and bulk import.

---

## Notes
- Ensure Supervisor or Horizon is configured in production for queues.
- Push notification service requires HTTPS in production.
- `products_sample_import.csv` must be generated and tested with actual demo data.
