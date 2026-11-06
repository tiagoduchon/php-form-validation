# PHP Form Validation

A responsive registration form built with **HTML5, CSS3, JavaScript and PHP**. Originally developed as a Programming I coursework project and refined for a software-development portfolio.

## Features

- Responsive form layout and accessible field labels.
- Client-side validation using JavaScript, including required fields and email format.
- Server-side validation in PHP (required fields, allowed options, length limits, email validation).
- Output escaping with `htmlspecialchars()` to reduce HTML injection risks.
- Form submission through HTTP POST and a structured results page.
- PHP learning examples: `isset`, `empty`, type checks, `intval`, `floatval`, `strval`, and `settype`.

## Tech stack

HTML5 · CSS3 · JavaScript · PHP 8+

## Run locally with XAMPP

1. Install XAMPP and start **Apache**.
2. Copy this project folder into `C:\xampp\htdocs\php-form-validation` on Windows.
3. Open `http://localhost/php-form-validation/TP.html` in your browser.
4. Complete the form and submit it to see the PHP processing results.

> PHP processing requires a PHP-enabled web server. Opening `TP.html` directly from your file system is not enough to test submission.

## Project structure

```text
php-form-validation/
├── TP.html                  # Registration form
├── recibe.php               # Server-side validation and results
├── css/estilo.css           # Responsive styling
├── JS/miscript.js           # Client-side validation
└── images/                  # Original assignment reference images
```

## Notes

This is an educational demonstration, not a production-ready registration system. It does not create user accounts or store submitted data in a database. Form submissions are processed and displayed for demonstration purposes.

## Author

**Tiago Duchon** — Software Development student (expected graduation: 2027)  
[GitHub](https://github.com/tiagoduchon)
