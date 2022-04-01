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
        }

        body header .ff-receipt-antet {
            border-top: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        body header .ff-receipt-antet .td-av-cabinet {
            text-align: left;
            width: 60%;
        }

        body header .ff-receipt-antet .td-av-cabinet div {
            padding-left: 5mm;
        }

        body header .ff-receipt-antet .td-receipt-doc {
            text-align: left;
            width: 40%;
        }

        body header .ff-receipt-antet .td-receipt-doc div {
            padding-left: 3mm;
        }

        body header .ff-receipt-antet .table-antet-receipt {
            width: 100%;
        }

        body header .ff-receipt-antet .table-antet-receipt .td-label-antet-recipt {
            font-weight: bold;
            vertical-align: top;
            width: 5%;
        }

        body header .ff-receipt-antet .td-antet-receipt {
            vertical-align: top;
            padding-left: 3mm;
        }

        body header .ff-receipt-antet .td-antet-receipt .td-signature {
            display: inline-block;
        }

        body header .ff-receipt-antet .td-antet-receipt .td-signature .signature {
            position: relative;
            width: 35mm;
            height: 15mm;
            border: 1px solid black;
            margin-left: 20mm;
        }

        body header .ff-receipt-antet .td-antet-receipt .td-signature .signature .div-text {
            position: absolute;
            bottom: 0;
            left: 2mm;
        }

        body header .ff-receipt-content {
            width: 100%;
        }

        body header .ff-receipt-content .td-label {
            font-weight: bold;
            vertical-align: top;
            width: 20%;
        }

        body header .ff-receipt-content .td-val {
            vertical-align: top;
            word-wrap: break-word;
        }

        body main {
            font-family: "Nunito", sans-serif;
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
                        <td class="td-val">{{$receipt['av_cuiro']}}</td>
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
                        <td class="td-label-antet-recipt"><div>Nr.:</div></td>
                        <td class="td-val">{{$receipt['receipt_nr']}}</td>
                    </tr>
                    <tr>
                        <td class="td-label-antet-recipt"><div>Data:</div></td>
                        <td class="td-val">{{$receipt['receipt_date']}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="td-signature">
                                <div class="signature">
                                    <div class="div-text">semnatura</div>
                                </div>
                            </div>
                        <td>
                    </tr>
                </table>
             </td>
        </tr>
    </table>

    <div class="line"></div>

    <table class = 'ff-receipt-content'>
        <tr>
            <td class="td-label"><div>Am primit de la:</div></td>
            <td class="td-val">{{$receipt['pa_nume']}}</td>
        </tr>
        <tr>
            <td class="td-label"><div>CUI\CNP:</div></td>
            <td class="td-val">{{$receipt['pa_cuiro']}}</td>
        </tr>
        <tr>
            <td class="td-label"><div>Reg. com:</div></td>
            <td class="td-val">{{$receipt['pa_regcom']}}</td>
        </tr>
        <tr>
            <td class="td-label"><div>Adresa:</div></td>
            <td class="td-val">{{$receipt['pa_adresa']}}</td>
        </tr>
        <tr>
            <td class="td-label"><div>Suma de:</div></td>
            <td class="td-val">{{$receipt['receipt_suma']}}</td>
        </tr>
        <tr>
            <td class="td-label"><div>contravaloare factura: </div></td>
            <td class="td-val">{{$receipt['invoice_nr']}} din data {{$receipt['invoice_date']}}</td>
        </tr>
    </table>

    <div class="line"></div>

</header>
<!-- <footer></footer> -->
<main>
</main>

</body>
</html>

