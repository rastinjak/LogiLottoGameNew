<html>
    <head>
        <title>LogiLotto Game</title>
    </head>
       
    <body>      
        Client ID:          <input type="text" id="ime"><br>
        Bet:                <input type="flaot" id="bet"><br>
        Choose 7 numbers:   <input type="text" id="numbers"><br>
        <button onclick="submit()">Bet NOW!</button>

        <div id="rez"> </div>
        
        <a href="betsList.php">Look at the bets!</a>
        
        <script>
            function submit()
            {
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function()     
                {
                    if (this.readyState == 4 && this.status == 200)     // sve je ok
                    {
                        document.getElementById("rez").innerHTML = this.responseText;
                    }
                };

                clientID =  document.getElementById("ime").value;
                bet =  document.getElementById("bet").value;
                numbers =  document.getElementById("numbers").value;

                xhttp.open("GET", "../Controller/Izracunaj.php?id=" + clientID + "&bet=" + bet + "&numbers=" + numbers, true);
                xhttp.send();    
            }
        </script>       
    </body>
</html>
