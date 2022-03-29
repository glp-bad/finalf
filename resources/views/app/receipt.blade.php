<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Receipt</title>

    <style>
        html {
            margin: 100px 50px;
        }

        @page {
            margin: 0cm 0cm 0cm 0cm;
        }

        body {
            font-family: "Nunito", sans-serif;
            font-size: 12px;
            /** Define now the real margins of every page in the PDF **/
            margin-top: 6cm;
            margin-left: -1.5cm;
            margin-right: -1.5cm;
            margin-bottom: 0cm;
            /** Define the header rules **/
            /** Define the footer rules **/
        }

        body .line {
            border-collapse: collapse;
            border-top: 1px solid black;
            width: 100%;
        }

        body .line-dotted {
            border-collapse: collapse;
            border-top: 1px dotted black;
            width: 100%;
        }

        body .tr-blank {
            height: 10px;
        }

        body .tr-blank td {
            height: 10px;
        }

        body .td-label-right {
            text-align: right;
        }

        body header {
            position: fixed;
            top: -1cm;
            left: 0cm;
            right: 0cm;
            height: 6.5cm;
            background: #98dfb6;
        }

        body header .ff-receipt-antet {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        body header .ff-receipt-antet .td-label-right {
            text-align: right;
        }

        body header .ff-receipt-antet .td-label-right div {
            padding-right: 10px;
        }

        body footer {
            position: fixed;
            bottom: -2cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
        }
        /*# sourceMappingURL=receipt.css.map */
    </style>
</head>


<body>

<header>
    <div class="line"></div>

    <table class = 'ff-receipt-antet'>
        <tr>
            <td>{{$receipt['av_cabinet']}}</td>
            <td class="td-label-right"><div>{{$receipt['receipt_doc']}}</div></td>
        </tr>
    </table>
</header>
<!-- <footer></footer> -->
<main>
</main>

</body>
</html>

