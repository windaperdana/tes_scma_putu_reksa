# Purchasing Management System

A complete purchasing management system built with Laravel 11, MySQL, and Bootstrap 5.

## Features

### Master Data Modules
- **Branches**: Manage company branches
- **Suppliers**: Manage supplier information
- **Items**: Manage inventory items

### Transaction Modules
- **Purchase Requests (PR)**: Create and manage purchase requests from branches
- **Purchase Orders (PO)**: Process purchase orders to suppliers
- **Purchase Receipts (PB)**: Record goods received and automatically update stock

## Tech Stack

- **Backend**: Laravel 11.x
- **Database**: MySQL
- **Frontend**: Bootstrap 5.3.0 with Bootstrap Icons
- **PHP**: 8.2+

## Installation

1. **Clone the repository**
   ```bash
   cd /Users/windaperdana/WORK/REKSA/tes_scma_putu_reksa
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in `.env`**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=purchasing_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Open your browser and visit: `http://localhost:8000`

## Database Structure

### Master Data Tables
- `branches` - Company branch information
- `suppliers` - Supplier information
- `items` - Inventory items with stock tracking

### Transaction Tables
- `purchase_requests` - Purchase request headers
- `purchase_request_details` - PR line items
- `purchase_orders` - Purchase order headers
- `purchase_order_details` - PO line items
- `purchase_receipts` - Goods receipt headers
- `purchase_receipt_details` - Receipt line items

## Sample Data

The system includes sample data:
- 3 Branches (Jakarta, Surabaya, Bandung)
- 3 Suppliers
- 6 Items (Laptops, Mouse, Keyboard, Monitor, Printer, Paper)
- 2 Purchase Requests with details
- 2 Purchase Orders with details
- 1 Purchase Receipt with stock updates

## Key Features

### Stock Management
- Automatic stock updates when creating purchase receipts
- Stock reversal when deleting purchase receipts
- Real-time stock tracking for all items

### Master-Detail Transactions
- Dynamic item entry in PR, PO, and PB forms
- Add/remove items dynamically with JavaScript
- Validation for all required fields

### User Interface
- Responsive Bootstrap 5 design
- Icon-based navigation with Bootstrap Icons
- Color-coded status badges
- Alert notifications for success/error messages

## Routes

### Master Data
- `/branches` - Branch management (CRUD)
- `/suppliers` - Supplier management (CRUD)
- `/items` - Item management (CRUD)

### Transactions
- `/purchase-requests` - Purchase Request management
- `/purchase-orders` - Purchase Order management
- `/purchase-receipts` - Purchase Receipt management

## Models & Relationships

### Branch
- Has many Purchase Requests

### Supplier
- Has many Purchase Orders

### Item
- Has many PR Details, PO Details, PB Details
- Tracks stock quantity

### Purchase Request
- Belongs to Branch
- Has many Details
- Has many Purchase Orders

### Purchase Order
- Belongs to Purchase Request
- Belongs to Supplier
- Has many Details
- Has many Purchase Receipts

### Purchase Receipt
- Belongs to Purchase Order
- Has many Details
- Updates item stock on create/delete

## Business Logic

1. **Purchase Request Flow**
   - Branch creates PR with requested items
   - PR can have status: draft, pending, approved, rejected, completed

2. **Purchase Order Flow**
   - PO is created based on approved PR
   - Supplier is assigned to PO
   - Items and prices are confirmed
   - PO calculates total amount automatically

3. **Purchase Receipt Flow**
   - PB records goods received from PO
   - Automatically updates item stock quantities
   - Can handle partial receipts
   - Stock is reverted when PB is deleted

## Development Notes

- All CRUD operations include validation
- Foreign key constraints ensure data integrity
- Timestamps track creation and modification dates
- Soft delete can be implemented if needed
- Bootstrap 5 provides responsive design

## Future Enhancements

- User authentication and authorization
- Role-based access control
- PDF report generation
- Email notifications
- Approval workflow
- Dashboard statistics
- Search and filtering capabilities
- Audit trail logging

## License

This project is created for internal use.

## Support

For questions or issues, please contact the development team.

---

**Built with ❤️ using Laravel & Bootstrap**
