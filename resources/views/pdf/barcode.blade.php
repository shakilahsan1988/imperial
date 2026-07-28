<html>
    <head>
        <style>
            .label{
                display: inline-block;
                margin-right: 20px;
                margin-top: 20px;
                text-align: center;
                font-family: sans-serif;
            }
            .label img{
                display: block;
            }
            .label span{
                font-size: 11px;
                letter-spacing: 1px;
            }
        </style>
        <title>
            {{__('Barcode')}} - #{{$group['id']}}
        </title>
    </head>
    <body>
        @for ($i = 0; $i < $number; $i++)
            <div class="label">
                <img src="data:image/svg+xml;base64,{{$barcode_image}}" alt="barcode" width="150"/>
                <span>{{$group['barcode']}}</span>
            </div>
        @endfor
    </body>
</html>
