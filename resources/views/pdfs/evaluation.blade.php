<style>
    * {
        font-family: Helvetica;
    }

    table {
        border-collapse: collapse;
    }

    td {
        padding: 3px;
    }

    table,
    td {
        border: 1px solid black;
    }

    .page_break {
        page-break-before: always;
    }

    body {
        margin-left: 50px;
        margin-top: 120px;
        margin-bottom: 55px;
    }

    .header {
        position: fixed;
        top: -10px;
        left: 0px;
        right: 0px;
        margin-bottom: 10em;
        /* height: 50px; */

        /** Extra personal styles **/
        /* background-color: #03a9f4; */
        /* color: white; */
        text-align: center;
        /* line-height: 35px; */
    }

    thead {
        display: table-row-group;
    }

    /* footer {
        position: fixed;
        bottom: 40px;
        text-align: center;
        font-size: 11px;
        font-weight: bold;
    } */

    footer {
        position: fixed;
        bottom: -20px;
        left: 0px;
        right: 0px;
        height: 50px;

        /** Extra personal styles **/
        /* background-color: #03a9f4; */
        /* color: white; */
        text-align: center;
        line-height: 35px;
        font-size: 11px;
        font-weight: bold;
    }

    div {
        font-size: 14px;
        width: 90%;
    }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<body>
    <div align="center" style="margin-top: 12em; position: absolute">
        <img width="70%" src="{{asset('images/default/evaluation/1.jpg?2022-02-24')}}" /> <br />
        <br />{{__("messages.views.pdfs.evaluation.text1")}}<br /><br /><br /><br /><br /><br />
        <br /><br /><br /><br /><br />AUTOEVALUACIÓN DE {{strtoupper($repository->name)}}
        <br />
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        {{__("messages.views.pdfs.evaluation.text2")}}<br /><br />
        {{date('Y')}}<br /><br /><br /><br /><br /><br />
    </div>
	<footer>
    	    {{--{{env("INSTITUTE_ADDRESS", "Tu dirección")}}<br />--}}
            {{--correo: {{env("INSTITUTE_MAIL", "correo@ejemplo.com")}}<br />--}}
        </footer>
    <div class="page_break" syu></div>
    {{-- <div style="margin-top: 10em; text-align:justify;"> --}}
        <div class="header">
            <img width="10%"
                src="data:image/png;base64,' . {{ base64_encode( file_get_contents( url('images/default/evaluation/banner.jpeg') ) ) }} " /><br />
        </div>
    {{-- <div style="margin-top: 10em; text-align:justify;"> --}}
    <br><br>
    1. Presentación<br /><br />
    El presente informe tiene por objetivo remitirle el resultado de la autoevaluación que se
    realizó al REA.<br /><br />
    Los criterios fueron evaluados por {{getenv('APP_NAME')}} el {{\Carbon\Carbon::parse($repository->updated_at)->format('d-m-Y')}}; en la URL:<br />
    <a
        href="{{getenv('APP_URL')}}">{{getenv('APP_URL')}}</a><br /><br /><br />
    2. áreas consideradas<br /><br/>
    Para esta evaluación, han sido los siguientes rubros:<br /><br/>

    @foreach (\App\Models\Category::has('questions')->get() as $category)
        - {{$category->name}}<br>
    @endforeach
    <br>
    3. Resultados de la autoevaluación<br /><br />

    A continuaci&oacute;n se presenta los criterios evaluados del REA:<br /><br />


    @foreach ($categories as $category)
    <div>
        <h4>
            {{$category->name}}
        </h4>

        <table width="110%" class="table table-striped table-sm" style="table-layout: fixed">
            @foreach ($subcategories as $subcategory)
            {{-- @if ($subcategory->questions->pluck('answers')->flatten()->count()) --}}
            <thead>
                <tr>
                    <td width="42%" align="left"><b>{{$subcategory->name}}</b></td>
                    <td width="16%" align="center"><b>Resultado</b></td>
                    <td width="42%" align="left"><b>Observaciones</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategory->questions->where('category_id',$category->id)->all() as $question)
                <tr>
                    <td style="word-wrap: break-word">{!! $question->description !!}</td>
                    <td style="word-wrap: break-word">
                        {{ ($question->answers->first() && $question->answers->first()->choice ? $question->answers->first()->choice->description : 'N/A') }}
                    </td>
                        <td style="word-wrap: break-word">
                            {{ ($question->answers->first() && $question->answers->first()->observation ? $question->answers->first()->observation->description : '') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            {{-- @endif --}}
            @endforeach
        </table>

    </div>
    @endforeach

    {{--<br /><br />
    Para cualquier duda o aclaración enviar correo a: {{env("INSTITUTE_MAIL", "correo@ejemplo.com")}} <br>
    Sin otro particular, expreso a usted mi especial consideración.<br /><br />
    Atentamente,--}}
    </div>
</body>
