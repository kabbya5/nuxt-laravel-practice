<!DOCTYPE html>
<html>
<head>
    <title>Wingo Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/wingo.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="wingo">
    <div class="wingo-body">
         <!-- HEADER -->
       
        <div class="header">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="title"> Quaomiuzzaman Kabbya </h4>
                    <span class="badge bg-success">Balance: {{ 40 }}</span>
                </div>
            </div>
       
        </div>
        <div class="container">
            <div class="wingo-body-surface">
                <div class="time-rounds d-flex align-items-center">
                    <div class="time time-30s">
                        <div class="clock">
                            <i class="fa-solid fa-alarm-clock icon"></i>
                        </div>
                        
                        <p> 30 Secounds</p>

                    </div>

                    <div class="time time-1min ">
                        <div class="clock">
                            <i class="fa-solid fa-alarm-clock icon"></i>
                        </div>
                        
                        <p> 1 Minute</p>
                    </div>

                    <div class="time time-1 5min">
                        <div class="clock">
                            <i class="fa-solid fa-alarm-clock icon"></i>
                        </div>
                        
                        <p> 1.5 Minute</p>
                    </div>
                </div>

                <!-- BET OPTIONS -->
                <div class="p-3">
                    <h5>Color</h5>
                    <button class="btn btn-danger bet" data-type="color" data-value="Red">Red</button>
                    <button class="btn btn-success bet" data-type="color" data-value="Green">Green</button>

                    <hr>
                    <h5>Number</h5>
                    @for($i=0;$i<=9;$i++)
                        <button class="btn btn-outline-light bet m-1" data-type="number" data-value="{{$i}}">
                            {{$i}}
                        </button>
                    @endfor

                    <hr>
                    <h5>Size</h5>
                    <button class="btn btn-warning bet" data-type="size" data-value="Big">Big</button>
                    <button class="btn btn-info bet" data-type="size" data-value="Small">Small</button>
                </div>

        <!-- RESULT -->
        <div class="card bg-black mt-3 p-3 text-center">
            <h5>Result</h5>
            <div id="resultText">Waiting...</div>
        </div>
            </div>
           

        <!-- TIMER -->
        <div class="alert alert-warning text-center mt-3">
            ⏱ Time Left: <span id="timer">60</span>s
        </div>

        <!-- BET OPTIONS -->
        <div class="card bg-secondary p-3">
            <h5>Color</h5>
            <button class="btn btn-danger bet" data-type="color" data-value="Red">Red</button>
            <button class="btn btn-success bet" data-type="color" data-value="Green">Green</button>

            <hr>
            <h5>Number</h5>
            @for($i=0;$i<=9;$i++)
                <button class="btn btn-outline-light bet m-1" data-type="number" data-value="{{$i}}">
                    {{$i}}
                </button>
            @endfor

            <hr>
            <h5>Size</h5>
            <button class="btn btn-warning bet" data-type="size" data-value="Big">Big</button>
            <button class="btn btn-info bet" data-type="size" data-value="Small">Small</button>
        </div>

        <!-- RESULT -->
        <div class="card bg-black mt-3 p-3 text-center">
            <h5>Result</h5>
            <div id="resultText">Waiting...</div>
        </div>

        <!-- PREDICTION -->
        <div class="mt-3 text-center">
            <button id="predict" class="btn btn-outline-info">🔮 Prediction</button>
            <h5 id="prediction"></h5>
        </div>

        <!-- HISTORY -->
        <div class="mt-4">
            <h5>📜 Bet History</h5>
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Type</th><th>Value</th><th>Amount</th>
                    </tr>
                </thead>
                <tbody id="history"></tbody>
            </table>
        </div>

        <!-- CHART -->
        <canvas id="chart" height="100"></canvas>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('/js/wingo.js')}}"></script>
</body>
</html>
