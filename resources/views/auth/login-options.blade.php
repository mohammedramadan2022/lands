<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خيارات تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: #333;
            font-weight: 600;
        }
        .login-options {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }
        .login-option {
            flex: 1;
            max-width: 300px;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .login-option:hover {
            transform: translateY(-5px);
        }
        .login-option h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .btn-login {
            background-color: #4e73df;
            border-color: #4e73df;
            color: #fff;
            font-weight: 600;
            padding: 10px 20px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            color: #fff;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-height: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <img src="{{get_file(setting()->logo_header)}}" alt="Logo">
            </div>

            <div class="login-header">
                <h2>مرحباً بك في {{setting()->app_name}}</h2>
                <p>الرجاء اختيار طريقة تسجيل الدخول</p>
            </div>

            <div class="login-options">
                <div class="login-option">
                    <h3>تسجيل دخول المدير</h3>
                    <p>تسجيل الدخول كمدير لإدارة النظام</p>
                    <a href="{{ route('admin.login') }}" class="btn btn-login">تسجيل الدخول كمدير</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
