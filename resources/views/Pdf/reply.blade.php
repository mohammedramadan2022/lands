<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>anlysis</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        .flex-container {
            margin-bottom: 130px;
        }

        .flex-container div {
            display: inline;
        }

        .flex-container h3 {
            display: inline-block;
            margin: 10px;
        }

        .text-right {
            display: flex !important;
            justify-content: end;
            padding: 0;
            margin: 0;
        }

        ul li {
            font-size: 17px;
            padding: 8px;
        }

        .diagnosis, .diagnosis th, .diagnosis td {
            border: 1px solid black;
        }

        .diagnosis th, .diagnosis td {
            padding: 10px;
        }
    </style>
</head>
<body>
<header class="flex-container">
    <div style="width: 50%; float: left;">
        <h3 style="display: block;">Doctoria</h3>
        <h3>Analysis & Imaging Study</h3>
    </div>
    <div style="width: 50%; float: right;">
        <h3 class="text-right">دكتوريا</h3>
        <h3 class="text-right">تحليل & وصور اشعة طيبة</h3>
    </div>
</header>

<div style="margin-left: 20px;">
    <table style="width: 90%; font-weight: 400;">
        <tr>
            <th style="text-align: left;">Physician Name</th>
            <th>الجنس</th>
            <th style="text-align: left;">Dr Sharef Ahmed</th>
        </tr>
        <tr>
            <th style="text-align: left;">Patient Name</th>
            <th>اسم المراجع</th>
            <th style="text-align: left;">...... .....</th>
        </tr>
        <tr>
            <th style="text-align: left;">Date Of Birth</th>
            <th>تاريخ الميلاد</th>
            <th style="text-align: left;">May, 31, 200</th>
        </tr>
        <tr>
            <th style="text-align: left;">Visit Date</th>
            <th>تاريخ الزيارة</th>
            <th style="text-align: left;">Jan, 15. 2024</th>
        </tr>
        <tr>
            <th style="text-align: left;">Gender</th>
            <th>الجنس</th>
            <th style="text-align: left;">Male</th>
        </tr>
    </table>
</div>

<div>
    <table class="diagnosis" style="width: 100%;">
        <h3>Analytics:</h3>

        <tr>
            <th>Name</th>
            <th>Due date</th>
            <th>Supporing info</th>
            <th>Priority</th>
            <th>reason</th>
            <th>Notes</th>
        </tr>
        <tr>
            <td>تحليل الدهون</td>
            <td>2024/01/25</td>
            <td>test</td>
            <td>عالية</td>
            <td>test</td>
            <td>test</td>
        </tr>
        <tr>
            <td>تحليل الدهون</td>
            <td>2024/01/25</td>
            <td>test</td>
            <td>عالية</td>
            <td>test</td>
            <td>test</td>
        </tr>
    </table>
</div>


<div style="text-align: center;">
    <h4>اسم الطبيب و توقعيه</h4>
    <h4>Physician name and signature</h4>
    <h4>د.شادي سعد</h4>
</div>
</body>
</html>
