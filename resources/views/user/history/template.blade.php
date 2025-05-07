<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CIERA Score Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
            background-color: #fff;
            /* background-image: url("{{ public_path('images/watermark.png') }}"); */
            opacity: 1;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%;
            background-attachment: fixed;
            opacity: 1;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("{{ public_path('images/watermark.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 80%;
            opacity: 0.5;
            z-index: -1;
            filter: brightness(200%) contrast(50%) invert(100%) hue-rotate(180deg);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header-content {
            margin: 0 100px;
        }
        .logo-left {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: auto;
        }
        .logo-right {
            position: absolute;
            right: 0;
            top: 0;
            width: 80px;
            height: auto;
        }
        .institution-name {
            font-size: 16px;
            font-weight: bold;
            color: #000080;
            margin: 0;
            line-height: 1.4;
        }
        .institution-address {
            font-size: 12px;
            margin: 5px 0;
            color: #000;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .content {
            margin: 20px 0;
        }
        .score-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .score-table td {
            padding: 8px;
        }
        .score-table .label {
            width: 150px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
        .note {
            margin-top: 30px;
            font-size: 12px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo1.png') }}" alt="Logo PNB" class="logo-left">
        <img src="{{ public_path('images/logo1.jpg') }}" alt="Logo PNB" class="logo-right">
        <div class="header-content">
            <p class="institution-name">UNIT PENUNJANG AKADEMIK BAHASA<br>POLITEKNIK NEGERI BALI</p>
            <p class="institution-address">Jl. Raya Uluwatu No.45, Jimbaran, Kuta Selatan<br>Kabupaten Badung, Bali 80361</p>
        </div>
    </div>

    <div class="title">
        CIERA Score Report
    </div>

    <div class="content">
        <p>Dear {{ $user_name }},</p>
        <p>Congratulations for completing the CIERA (Computer-based Interactive English Rating Assessment) practice test.</p>
        <p>Please find below details of the test taken on {{ $test_date }}:</p>

        <table class="score-table">
            <tr>
                <td class="label">Test-taker's Name</td>
                <td>: {{ $user_name }}</td>
            </tr>
            <tr>
                <td class="label">Listening Score</td>
                <td>: {{ $listening_score }}</td>
            </tr>
            <tr>
                <td class="label">Reading Score</td>
                <td>: {{ $reading_score }}</td>
            </tr>
            <tr>
                <td class="label">Total Score</td>
                <td>: {{ $total_score }}</td>
            </tr>
            <tr>
                <td class="label">Level</td>
                <td>: {{ $level }}</td>
            </tr>
            <tr>
                <td class="label">Readiness</td>
                <td>: {{ $readiness }}</td>
            </tr>
        </table>

        <div class="note">
            <strong>Note:</strong><br>
            This document is generated as a practice test result and is considered valid for measuring test-taker's readiness
            on taking CIERA in the near future. This result is generated on {{ date('d F Y') }}.
        </div>
    </div>
</body>
</html> 