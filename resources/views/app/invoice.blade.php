<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura</title>

    <style>
        html {
            margin: 100px 50px;
        }

        @page {
            margin: 0cm 0cm 0cm 0cm;
        }

        body {
            font-family: "Nunito-Regular", sans-serif;
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
        }

        body header .ff-invoice-antet {
            border-collapse: collapse;
        }

        body header .ff-invoice-antet .tr-antet {
            text-align: left;
        }

        body header .ff-invoice-antet .tr-antet .td-title {
            margin-left: 20px;
        }

        body header .ff-invoice-antet .tr-antet .td-label {
            font-weight: bold;
            vertical-align: top;
        }

        body header .ff-invoice-antet .tr-antet .td-val {
            vertical-align: top;
        }

        body header .line70 {
            border-collapse: collapse;
            border-top: 1px solid black;
            width: 70%;
        }

        body header .nr-data-factura {
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }

        body header .nr-data-factura .nr {
            font-weight: bold;
            text-align: center;
            font-size: 20px;
        }

        body main {
            margin-left: 1.5cm;
            margin-right: 1.5cm;
        }

        body main .ff-detaliu {
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }

        body main .ff-detaliu tr th {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            font-weight: normal;
            padding: 5px;
        }

        body main .ff-detaliu tr .th-center {
            text-align: center;
        }

        body main .ff-detaliu tr .th-left {
            text-align: left;
        }

        body main .ff-detaliu tr .th-right {
            text-align: right;
        }

        body main .ff-detaliu tr .th-right-border {
            border-right: 1px solid black;
        }

        body main .ff-detaliu tr td {
            vertical-align: top;
            word-wrap: break-word;
        }

        body main .ff-detaliu tr .td-right {
            text-align: right;
        }

        body main .ff-detaliu tr .td-left {
            text-align: left;
        }

        body main .ff-detaliu tr .td-center {
            text-align: center;
        }

        body main .ff-detaliu tr .nr-column {
            padding: 7px;
            width: 20px;
        }

        body main .ff-detaliu tr .serviciu-column {
            padding: 7px;
            width: 400px;
        }

        body main .ff-detaliu tr .valoare-column {
            padding: 7px;
            width: 70px;
        }

        body main .ff-detaliu tr .tva-column {
            padding: 7px;
            width: 70px;
        }

        body main .tr-total-plata .td-label-right {
            font-weight: bold;
            font-size: 16px;
        }

        body main .tr-total-plata .td-value-right {
            font-weight: bold;
            font-size: 16px;
            padding-left: 10px;
        }

        body footer {
            position: fixed;
            bottom: -2cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
        }



    </style>
</head>



<body>

<header>
    <table class="ff-invoice-antet">
        <tr class="tr-antet" >
            <td class="td-title" colspan="2">
                Furnizor
                <table class="line70"><tr><td></td></tr></table>
            </td>
            <td class="td-title" colspan="2">
                Cumparator
                <table class="line70"><tr><td></td></tr></table>
            </td>
        </tr>
        <tr class="tr-antet" >
            <td class="td-label" colspan="2">{{$antet["cNumeCabinet"]}}</td>
            <td class="td-label" colspan="2">{{$antet["cClient"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Aut:</div></td>
            <td class="td-val">{{$antet["cDecizia"]}}</td>
            <td class="td-label"><div>Reg. Com:</div></td>
            <td class="td-val">{{$antet["regcom"]}}</td>

        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Cod fiscal:</div></td>
            <td class="td-val"> {{$antet["cui_av"]}}</td>
            <td class="td-label"><div>Cod fiscal:</div></td>
            <td class="td-val">{{$antet["cui"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Sediu:</div></td>
            <td class="td-val"> {{$antet["cAdresa_av"]}}</td>
            <td class="td-label"><div>Sediu:</div></td>>
            <td class="td-val"> {{$antet["cAdresa_pa"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Oras/Judet:</div></td>
            <td class="td-val"> {{$antet["cOras_av"]}}</td>
            <td class="td-label"><div>Oras/Judet:</div></td>
            <td class="td-val">{{$antet["cOras_pa"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Cont:</div></td>
            <td class="td-val"> {{$antet["cIBAN_av"]}}</td>
            <td class="td-label"><div>Cont:</div></td>
            <td class="td-val"> {{$antet["cIBAN_pa"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label"><div>Banca:</div></td>
            <td class="td-val">  {{$antet["cDecizia"]}}</td>
            <td class="td-label"><div>Banca:</div></td>
            <td class="td-val">  {{$antet["cBanca_pa"]}}</td>
        </tr>

    </table>

    <br>
    <table class="line"><tr><td></td></tr></table>
    <br>

    <table class="nr-data-factura">
        <tr class="nr">
            <td colspan="2"><div>FACTURA</div></td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label-right"><div>Nr:</div></td>
            <td class="td-val">  {{$antet["cNr"]}}</td>
        </tr>
        <tr class="tr-antet">
            <td class="td-label-right"><div>Data:</div></td>
            <td class="td-val">{{$antet["dataf"]}}</td>

        </tr>
    </table>

</header>

<!-- <footer></footer> -->



<main>

        <table class="ff-detaliu">
            <tr>
                <th class="th-right-border th-center">Nr.</th>
                <th class="th-right-border th-left">Denumire servicii</th>
                <th class="th-right-border th-right">Valoare</th>
                <th class="th-right">Valoare TVA</th>
            </tr>

            @foreach ($servicii as $s)
                <tr>
                    <td class="td-center nr-column">{{$s['nro']}}</td>
                    <td class="td-left serviciu-column">{{$s['cExplicf']}}</td>
                    <td class="td-right valoare-column">{{ number_format($s['nSuma'],2,'.',',')}}</td>
                    <td class="td-right tva-column">{{ number_format($s['nTVA'],2,'.',',')}}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="4">
                    <table class="line-dotted"><tr><td></td></tr></table>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="td-right">Total:</td>
                <td class="td-right">{{number_format($plata['suma'],2,'.',',')}}</td>
                <td class="td-right">{{number_format($plata['tva'],2,'.',',')}}</td>
            </tr>


            <tr class="tr-blank" >
                <td colspan="4"></td>
            </tr>

            <tr class="tr-total-plata" >
                <td colspan="3" class="td-label-right">Total plata:</td>
                <td class="td-value-right">{{number_format($plata['totalPlata'],2,'.',',')}}</td>
            </tr>


        </table>
</main>

</body>
</html>

