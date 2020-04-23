<html>
    <head>
        <meta charset="utf-8">
        <style>
            @page {
                size: A5 portrait;
                margin: 0;
            }

            html {
                background: #ededed;
                font-family:Arial;
            }

            body {
                height: 210mm;
                width: 148.5mm;
                margin: 0;
            }

            .page {
                height: 50%;
                width: 100%;
                position: relative;
            }

            .page-top {
            }

            .page-bottom {
            }

            @media print and (orientation:landscape) {
                .printable {

                }
            }
            .printable {
                position:absolute;
                width:100%;
                height:100%;
            }
            .printable--content {
                position:relative;
                display:block;
            }
            .printable--content--logo {
                position:relative;
                display:block;
                max-width:30mm;
                margin:10mm auto 2mm;
            }
            .printable--content--qr {
                position:relative;
                display:block;
                max-width:50mm;
                margin:2mm auto 0mm;
            }
            .d-block {
                display:block;
            }
            .text-m {
                font-size:16px;
            }
            .text-align-center {
                text-align:center;
            }
        </style>
    </head>
    <body>
        <div class="page page-top">
            <div class="printable">
                <div class="printable--content">
                    <img class="printable--content--logo" src="{{ asset('business-logo/'.$data['business']['logo_url']) }}"/>
                    <div class="text-m text-align-center">
                        Scan the barcode below!
                    </div>
                    <img class="printable--content--qr" src="{{ route('qrcode.create', [
                            'data' => url()->route('tinyurl.redirect.label', ['id' => $data['id']]),
                            'width' => '300',
                            'height' => '300'
                        ]) }}"/>
                </div>
            </div>
        </div>
    </body>
</html>