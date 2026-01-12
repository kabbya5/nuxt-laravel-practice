let time = 60;

setInterval(() => {
    time--;
    $('#timer').text(time);

    if(time <= 0){
        generateResult();
        time = 60;
    }
},1000);

// BET
$('.bet').click(function(){
    $.post('/wingo/bet',{
        _token:$('meta[name="csrf-token"]').attr('content'),
        type:$(this).data('type'),
        value:$(this).data('value'),
        amount:10
    },()=>{
        alert('Bet placed');
        loadHistory();
    });
});

// RESULT
function generateResult(){
    $.get('/wingo/result',res=>{
        $('#resultText').html(`
            🎯 Number: ${res.number}<br>
            🎨 Color: ${res.color}<br>
            ⚫ Size: ${res.size}
        `).hide().fadeIn();
        loadChart();
    });
}

// PREDICTION
$('#predict').click(()=>{
    $.get('/wingo/predict',res=>{
        $('#prediction').text('Prediction: ' + res.prediction);
    });
});

// HISTORY
function loadHistory(){
    $.get('/wingo/history',res=>{
        let html='';
        res.forEach(r=>{
            html += `<tr>
                        <td>${r.type}</td>
                        <td>${r.value}</td>
                        <td>${r.amount}</td>
                    </tr>`;
        });
        $('#history').html(html);
    });
}

loadHistory();

function loadChart(){
    $.get('/api/chart-data',res=>{
        new Chart(document.getElementById('chart'),{
            type:'line',
            data:{
                labels:res.labels,
                datasets:[{
                    label:'Last Numbers',
                    data:res.data,
                    borderWidth:2
                }]
            }
        });
    });
}