# Electricity Bill Calculator (PHP)

A responsive PHP website to calculate electricity bills using slab rates:

- First 50 units: Rs. 3.50 per unit
- Next 100 units: Rs. 4.00 per unit
- Next 100 units: Rs. 5.20 per unit
- Above 250 units: Rs. 6.50 per unit

## Files

- `index.php` - UI + PHP bill logic
- `assets/css/style.css` - Custom responsive styling
- `assets/js/script.js` - jQuery client-side validation

## Run Options

### Option 1: XAMPP / WAMP

1. Copy project folder to your server root (for XAMPP: `htdocs`).
2. Start Apache.
3. Open in browser:

   `http://localhost/electricity_bill_using_php/`

### Option 2: PHP Built-in Server

If PHP is installed and added to PATH:

```bash
php -S localhost:8000
```

Then open:

`http://localhost:8000/`
