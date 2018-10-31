
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>

        * {
            margin: 0;
            font-family: helvetica neue, Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 13px;
            color: #616161
        }

        img {
            max-width: 100%
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6em
        }

        table td {
            vertical-align: top
        }

        body {
            background-color: #f0f0f0
        }

        .body-wrap {
            background-color: #f0f0f0;
            width: 100%
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px
        }

        .main {
            background-color: #fff;
            border-radius: 2px
        }

        .content-wrap {
            padding: 20px
        }

        .content-block {
            padding: 0 0 20px
        }

        .header {
            width: 100%;
            margin-bottom: 20px
        }

        .footer {
            width: 100%;
            clear: both;
            color: #999;
            padding: 20px
        }

        .footer p, .footer a, .footer td {
            color: #999;
            font-size: 12px
        }

        h1, h2, h3 {
            font-family: helvetica neue, Helvetica, Arial, lucida grande, sans-serif;
            color: #000;
            margin: 40px 0 0;
            line-height: 1.2em;
            font-weight: 400
        }

        h1 {
            font-size: 32px;
            font-weight: 500
        }

        h2 {
            font-size: 24px
        }

        h3 {
            font-size: 18px
        }

        h4 {
            font-size: 14px;
            font-weight: 600
        }

        p, ul, ol {
            margin-bottom: 10px;
            font-weight: 400
        }

        p li, ul li, ol li {
            margin-left: 5px;
            list-style-position: inside
        }

        a {
            color: #348eda;
            text-decoration: underline
        }

        .btn-primary {
            text-decoration: none;
            color: #fff;
            background-color: #09c;
            border: solid #09c;
            border-width: 10px 20px;
            line-height: 2em;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 2px;
            text-transform: capitalize
        }

        .last {
            margin-bottom: 0
        }

        .first {
            margin-top: 0
        }

        .aligncenter {
            text-align: center
        }

        .alignright {
            text-align: right
        }

        .alignleft {
            text-align: left
        }

        .clear {
            clear: both
        }

        .radius-top-left {
            border-radius: 2px 0 0 0
        }

        .radius-top-right {
            border-radius: 0 2px 0 0
        }

        .alert {
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            padding: 20px;
            text-align: center;
            border-radius: 2px 2px 0 0
        }

        .alert a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px
        }

        .alert.alert-warning {
            background-color: #E98531;
        }

        .alert.alert-bad {
            background-color: #d96557
        }

        .alert.alert-good {
            background-color: #2ecc71
        }

        .invoice {
            margin: 40px auto;
            text-align: left;
            width: 80%
        }

        .invoice td {
            padding: 5px 0
        }

        .invoice .invoice-items {
            width: 100%
        }

        .invoice .invoice-items td {
            border-top: #eee 1px solid
        }

        .invoice .invoice-items .total td {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            font-weight: 700
        }

        .status {
            border-collapse: collapse
        }

        .status .status-cell {
            height: 50px
        }

        .status .status-cell.success, .status .status-cell.active {
            height: 65px;
            vertical-align: middle
        }

        .status .status-cell.success {
            background: #2ecc71;
            color: #fff;
            border-right: 1px solid #45d080
        }

        .status .status-cell.active {
            background: #fff;
            width: 135px
        }

        .status .status-image {
            vertical-align: text-bottom
        }

        .status .white {
            color: #fff
        }

        @media only screen and (max-width: 640px) {
            body {
                padding: 0 !important
            }

            h1, h2, h3, h4 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important
            }

            h1 {
                font-size: 22px !important
            }

            h2 {
                font-size: 18px !important
            }

            h3 {
                font-size: 16px !important
            }

            .container {
                padding: 0 !important;
                width: 100% !important
            }

            .content {
                padding: 0 !important
            }

            .content-wrap {
                padding: 10px !important
            }

            .invoice {
                width: 100% !important
            }
        }

    </style>

</head>
<body>
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="alert alert-warning">
                            Alteração de Senha
                        </td>
                    </tr>
                    <tr>
                        <td class="content-wrap">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                {!! $data['text_mail'] !!}
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>