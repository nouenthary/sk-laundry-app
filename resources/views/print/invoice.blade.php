<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <style>
        body {
            font-family: 'Nokora', serif !important;
            font-size: 12px !important;
        }

        td {
            padding: 2px !important;
        }

    </style>
    <!-- Bootstrap 3.3.7 -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nokora&display=swap" rel="stylesheet">
</head>

<body>

    {{-- {{ $data }} --}}    

    <div style="margin-left: 10px">
        <div style="background: #fff; width: 350px">
            <div class="text-header text-center">
                {{-- <h1 style="font-weight: bold;">ViewBag.Title</h1> --}}
                <h1 style="font-weight: bold;">បោកគក់ Online</h1>
            </div>
            <div class="text-center" style="margin-top: -10px; padding-bottom: 10px">
                <img src="/image/photo_2021-03-15_20-07-52.jpg" height="60px" alt="" style="padding-left: 55px">              
                
                <div style="float: right">
                    {{-- <img src="/image/qrcode.jpg" width="60px" alt="" > --}}
                    {{$qrCode}}    
                </div>                            

            </div>
            <div class="text-header">
                <span style="padding-left: 2px">ថ្ងៃខែឆ្នាំ : {{$date}}</span>
                <span style="float: right">អតិថិជន : {{$customer->agent_name}}</span>
            </div>
            <div class="text-header" style="padding-top: 5px">
                <span style="padding-left: 2px">វិក័យប័ត្រ : {{$invoice}}</span>
                <span style="float: right">ទូរស័ព្ទ : {{$customer->tel}}</span>
            </div>
            <br />
            <table class="table">
                <thead>
                    <tr style="border-top: 1.5px solid #000000;">
                        <td width="20%">ប្រភេទ</td>
                        <td width="20%">ចំនួនគីឡូ</td>
                        <td width="10%">ខ្នាត</td>
                        <td width="10%">ចំនួន</td>
                        <td width="20%">តម្លៃ</td>
                        <td width="20%" style="text-align: end">សរុប</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td style="border-top: 1.5px solid #000000"> {{ \App\Models\Service::where('id',$row->service_id)->select('service_name')->first()->service_name }}</td>
                            <td style="border-top: 1.5px solid #000000">{{$row->weight}}</td>
                            <td style="border-top: 1.5px solid #000000">គីឡូ</td>
                            <td style="border-top: 1.5px solid #000000">{{$row->qty}}</td>
                            <td style="border-top: 1.5px solid #000000"> {{$row->price}} R</td>
                            <td style="border-top: 1.5px solid #000000;text-align: end">{{$row->total}} R</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="border-top: 1.5px solid #000000">សរុបគីឡូ</td>
                        <td style="border-top: 1.5px solid #000000">{{$sum_weight}}</td>
                        <td style="border-top: 1.5px solid #000000">សរុប</td>
                        <td style="border-top: 1.5px solid #000000">{{$sum_qty}}</td>
                        <td style="border-top: 1.5px solid #000000">តំលៃសរុប(R)</td>
                        <td style="border-top: 1.5px solid #000000 ; text-align: end">{{$amount}} R</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #000000;">
                        <td style="border-top: 0"></td>
                        <td style="border-top: 0"></td>
                        <td style="border-top: 0"></td>
                        <td style="border-top: 0">
                            <?php 
                                $rate = App\Models\Config::where('key','currency')->select('value')->first()->value; 
                                $amount_dollar = $amount/$rate;                               
                            ?>
                            
                        </td>
                        <td style="border-top: 0; font-size: 11px">តំលៃសរុប($)</td>
                        <td style="border-top: 0; text-align: end; font-size: 11px">
                            <?php echo round($amount_dollar,2); ?> $
                        </td>
                    </tr>
                </tfoot>
            </table>

            {{-- @*<p style="padding-left: 2px; text-align: justify">ចំណាំ : ប្រសិនបើអតិថិជនបាត់សំលៀកបំពាក់ក្រុមហ៊ុននឺងសង១ទ្វេ ១០ នៃតំលៃបោកអ៊ុត ។ ប្រសិនបើអតិថិជនមិនបានមកយកសំលៀកបំពាក់ក្នុងរយះពេល១ខែទុកជាអសាបង់ ។</p>*@ --}}

            {{-- @*<p>ទូរស័ព្ទលេខ : 023 232 888, 092 900 991, 069 866 636</p>*@ --}}
            {{-- @* <p style="text-align: justify">អាសយដ្ឋាន : ផ្ទះលេខ 147 ផ្លូវលេខ​ 217, សង្កាត់​ដង្កោរ, ខណ្ឌដង្កោរ, រាជាធានីភ្នំពេញ</p>*@ --}}
            <p style="padding-left: 2px; text-align: justify">
                {{ $note->value }}
            </p>
            <p style="padding-left: 2px; text-align: justify; margin-top : -5px; font-size: 10px">
                {{ $phone->value }}
            </p>
            <p style="padding-left: 2px; text-align: justify;  margin-top : -5px;">
                {{ $address->value }}
            </p>
        </div>
    </div>    	        
    <script>
        window.print();
    </script>
</body>

</html>
