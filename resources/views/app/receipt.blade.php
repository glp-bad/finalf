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

        body .td-label {
            font-weight: bold;
            vertical-align: top;
            width: 18%;
        }

        body .td-val {
            vertical-align: top;
            word-wrap: break-word;
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
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        body header .ff-receipt-antet .td-av-cabinet {
            text-align: left;
            width: 55%;
        }

        body header .ff-receipt-antet .td-av-cabinet div {
            background-color: coral;
            padding-left: 5mm;
        }

        body header .ff-receipt-antet .td-receipt-doc {
            text-align: right;
            width: 45%;
        }

        body header .ff-receipt-antet .td-receipt-doc div {
            background-color: lavenderblush;
            padding-right: 5mm;
        }

        body header .ff-receipt-antet .table-antet-receipt {
            border: 1px solid black;
        }

        body header .ff-receipt-antet .td-antet-receipt {
            background-color: greenyellow;
            vertical-align: top;
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
    <!--<div class="line"></div>-->

    <table class = 'ff-receipt-antet'>
        <tr>
            <td class="td-av-cabinet"><div>{{$receipt['av_cabinet']}}</div></td>
            <td class="td-receipt-doc"><div>{{$receipt['receipt_doc']}}</div></td>
        </tr>
        <tr>
            <td>
                <table class = 'table-antet-av'>
                    <tr>
                        <td class="td-label"><div>Aut:</div></td>
                        <td class="td-val">{{$receipt['av_decizia']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label"><div>Cod fiscal:</div></td>
                        <td class="td-val">{{$receipt['av_cui']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label"><div>Sediu:</div></td>
                        <td class="td-val">{{$receipt['av_adresa']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label"><div>Cont:</div></td>
                        <td class="td-val">{{$receipt['av_iban']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label"><div>Banca:</div></td>
                        <td class="td-val">{{$receipt['av_banca']}} - {{$receipt['av_sucursala']}}</td>
                    </tr>
                </table>
            </td>

            <td class="td-antet-receipt">
                <table class = 'table-antet-receipt'>
                    <tr>
                        <td class="td-label"><div>Nr.:</div></td>
                        <td class="td-val">{{$receipt['receipt_nr']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label"><div>Data:</div></td>
                        <td class="td-val">{{$receipt['receipt_date']}}</td>
                    </tr>
                </table>
             </td>
        </tr>

    </table>
</header>
<!-- <footer></footer> -->
<main>
</main>

</body>
</html>

