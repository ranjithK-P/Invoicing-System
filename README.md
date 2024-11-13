Here’s a `README.md` file to guide you through setting up and running the Symfony-based "Invoicing System" application, with features like cart operations, invoice generation, and multiple payment options.

---

# Invoicing System

This is a Symfony-based Invoicing System that includes Manage Products, Customer, Category, cart operations, invoice generation, and support for multiple payment options. This guide provides setup instructions, as well as usage and commands to run the application.

## Features
Product Management: Products can be managed easily.
Category Management: All categories can be managed easily.
Customer Management: All customer details can be managed easily.
Invoice Generation: Generate an invoice with all relevant details, Calculate the total amount after applying discounts and taxes

- **Cart Operations**: Add, update, and remove products from a cart, with availability checks.
- **Invoice Generation**:
  - Capture customer details.
  - List purchased products, quantities, prices, and apply discounts/taxes.
  - Generate invoices with total calculations.
- **Payment Options**: Support for cash, credit, and PayPal payments.

## Requirements

- PHP 8.0 or higher
- Composer
- Symfony CLI (optional but recommended)
- MySQL
- Ubuntu 22 (or any compatible OS)

## Setup

### 1. Clone the Repository

```bash
git clone https://github.com/ranjithK-P/Invoicing-System.git
cd invoicing-system
```

### 2. Install Dependencies

Make sure Composer is installed, then run:

```bash
composer install
```

### 3. Configure the `.env` File

Copy the `.env.example` file to create your `.env` file and update the database connection details.

```bash
cp .env.example .env
```

Edit the `.env` file to match your database configuration:

```
DATABASE_URL="mysql://username:password@127.0.0.1:3306/invoicing_system"
```

Replace `username`, `password`, and `invoicing_system` with your MySQL credentials and database name.

### 4. Create the Database

Run the following commands to create and migrate the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Create Fixtures (Optional)

If you have fixtures for sample data, load them with:

```bash
php bin/console doctrine:fixtures:load
```

### 6. Start the Symfony Server

You can use the Symfony CLI to start a local server:

```bash
symfony serve
```

Alternatively, you can use PHP’s built-in server:

```bash
php -S 127.0.0.1:8000 -t public
```

The application should now be accessible at `http://127.0.0.1:8000`.

## Usage

### Default Route

- Visit `http://localhost:8000` to view the homepage with key features involved in an application.

### Product Management
- Visit `/product` to view, add, update, or remove products.
- **Adding Products**: Add products by specifying the `name` and quantity.
- **Updating Products**: Adjust quantities as needed directly in the system.
- **Removing Products**: Remove unwanted products from the system.

### Category Management
- Visit `/category` to add, update, delete, and retrieve categories.
- **Adding Category**: Add category by specifying name of the category.
- **Updating Category**: Adjust category as needed directly in the system.
- **Removing Category**: Remove unwanted Category from the system.

### Customer Management
- Visit `/customer` to view, add, update, or remove prodcust category.
- **Adding Products**: Add products by specifying the `productId` and quantity.
- **Updating Quantity**: Adjust quantities as needed directly in the system.
- **Removing Products**: Remove unwanted products from the system.


### Cart Management

- Visit `/cart` to view, add, update, or remove products in your cart.
- **Adding Products**: Add products by specifying the `productId` and quantity.
- **Updating Quantity**: Adjust quantities as needed directly in the cart.
- **Removing Products**: Remove unwanted products from the cart.

**Postman request**: 
1. GET: http://localhost:8000/cart
2. POST: http://localhost:8000/cart/add

form-data:
product_id: "value",
quantity: "value"

OR CURL:
curl --location 'http://localhost:8000/cart/add' \
--header 'Cookie: PHPSESSID=d486odetbapjerk4f8ck9qf272' \
--form 'product_id="1"' \
--form 'quantity="2"'


### Generating an Invoice

- After adding products to the cart, proceed to checkout.
- At checkout, select payment options and confirm your purchase to generate an invoice.
- Visit http://localhost:8000/invoice/generate to view the generated invoice.
  Postman request:
  POST: {
    "customer_id": 1,
    "products": [
        {
            "id": 1,
            "quantity": 2,
            "discount": 500.0
        }
    ],
    "flat_discount": 10.0,
    "tax_rate": 5.0,
    "payment_method": "Credit"
}

 OR

 curl --location 'http://localhost:8000/invoice/generate' \
--header 'Content-Type: application/json' \
--header 'Cookie: PHPSESSID=d486odetbapjerk4f8ck9qf272' \
--data '{
    "customer_id": 1,
    "products": [
        {
            "id": 1,
            "quantity": 2,
            "discount": 500.0
        }
    ],
    "flat_discount": 10.0,
    "tax_rate": 5.0,
    "payment_method": "Credit"
}
'

## Endpoints and Routes

### Cart Routes

- **View Cart**: `/cart`
- **Add Product**: `/cart/add/{productId}`
- **Update Product Quantity**: `/cart/update/{productId}`
- **Remove Product**: `/cart/remove/{productId}`

### Invoice Routes

- **Generate Invoice**: `/checkout` (proceeds to create an invoice)
- **View Invoice**: `/invoice/{id}`

## Example Data Structure

### Entities

- **Customer**: Manages user-related information and includes a `getCart()` relationship with `Cart`.
- **Product**: Includes `id`, `name`, `description`, `price`, `quantity` and `category`.
- **Cart**: Stores items added by a user and has a `CartItem` relationship.
- **Invoice**: Contains generated invoice details, including items, customer info, taxes, and total calculations.

## Development Commands

- **Run Tests**:
  ```bash
  php bin/phpunit
  ```

- **Clear Cache**:
  ```bash
  php bin/console cache:clear
  ```

## Troubleshooting

1. **Database Errors**: Ensure your `.env` file is configured correctly, and the database exists.
2. **Missing Cart Variable**: Ensure the `CartController` is passing the `cart` object to the view.


--- 

Let me know if there are any adjustments or further clarifications you'd like to include.
