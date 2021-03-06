  //  var deadline="2017-03-06";
        function getTimeRemaining(endtime){
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime){
  var clock = document.getElementById(id);
  var timeinterval = setInterval(function(){
    var t = getTimeRemaining(endtime);
    clock.innerHTML = 'Time left: '+ t.hours + ' hr ' +
                       + t.minutes + ' mins ' +
                      + t.seconds+' secs ';
    if(t.total<=0){
      clearInterval(timeinterval);
      clock.innerHTML = 'Time Elapsed: Delete Process initated';
    }
  },1000);
}


