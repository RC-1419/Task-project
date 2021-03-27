<html>
    <head>
        <title>Task project</title>
        <script src="jquery-3.6.0.min.js"></script>
        <!-- <script src="jquery.js"></script> -->
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body style="background-color: grey;margin: 0px;">
    <?php
    $conn = new mysqli("localhost", "root", "", "saas_task");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $triggr_array = array();
    if(isset($_POST['submit'])){
        $triggers = $_REQUEST['triggers'];
        if((strpos($triggers, 'AND') !== false) || (strpos($triggers, 'OR') !== false)){
            if(strpos($triggers, 'AND') !== false){
                $trigger_separate = explode('AND', $triggers);
                if(in_array($trigger_separate, $triggr_array)){
                    continue;
                }
                else{
                    array_push($triggr_array, $trigger_separate);
                }    
            }
            elseif(strpos($triggers, 'OR') !== false){
                $trigger_separate = explode('OR', $triggers);
                if(in_array($trigger_separate, $triggr_array)){
                    continue;
                }
                else{
                    array_push($triggr_array, $trigger_separate);
                }   
            }
        }    
        else{
            if (strcmp($triggers, 'Send/Receive a message')==0)
            {
                //echo $triggers;
                $val = 1;
            }
            elseif (strcmp($triggers, 'Make/Receive a call')==0)
            {
                //echo $triggers;
                $val = 2;
            }
            elseif (strcmp($triggers, 'Schedule an appointment')==0)
            {
                //echo $triggers;
                $val = 3;
            }
        }
    }
    if($triggr_array){
        print_r($triggr_array);
    }
    for ($i=0;$i < count($triggr_array); $i++) {
        $triggr_array[0][$i] =  trim($triggr_array[0][$i]); 
        echo $triggr_array[0][$i];
        if (strcmp($triggr_array[0][$i], 'Send/Receive a message')==0)
        {
            echo $triggr_array[0][$i];
            $val = 1;
        }
        elseif (strcmp($triggr_array[0][$i], 'Make/Receive a call')==0)
        {
            echo $triggr_array[0][$i];
            $val = 2;
        }
        elseif (strcmp($triggr_array[0][$i], 'Schedule an appointment')==0)
        {
            echo $triggr_array[0][$i];
            $val = 3;   
        }
    }    

    if(isset($_POST['submit1'])){
        $sender = $_POST['m_sender'];
        $receiver = $_POST['m_receiver'];
        $date = $_POST['m_date'];
        $curr_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO messages (Sender, Receiver, Date_ins, Crnt_Date) VALUES ('$sender', '$receiver', '$date', '$curr_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<h2 id='msg'>Message automated successfully</h2>";
            $_POST = array();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if(isset($_POST['submit2'])){
        $caller = $_POST['c_sender'];
        $receiver = $_POST['c_receiver'];
        $date = $_POST['c_date'];
        $duration = $_POST['c_duration'];
        $curr_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO calls (Caller, Receiver, Date_ins, Call_Duration, Crnt_Date) VALUES ('$caller', '$receiver', '$date', '$duration', '$curr_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<h2 id='msg'>Call automated successfully</h2>";
            $_POST = array();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if(isset($_POST['submit3'])){
        $date = $_POST['a_date'];
        $email = $_POST['a_email'];
        $curr_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO appointments (Date_ins, Email, Crnt_Date) VALUES ('$date', '$email', '$curr_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<h2 id='msg'>Appointment automated successfully</h2>";
            $_POST = array();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
        <div id="heading_box" align="center">Workflow automations</div><br>
        <center>
        <h2>
            Select among the following options:<br><br>
            1. Send/Receive a message<br>
            2. Make/Receive a call<br>
            3. Schedule an appointment<br><br>
            [* input something like "Send/Receive a message AND Make/Receive a call", etc. *]
        </h2>
            <form method="POST">
                <input id="inp" type="text" name="triggers" placeholder="Enter triggers separated by 'AND' or 'OR'">
                <input id="btn" type="submit" name="submit" value="Submit the values">   
            </form><br>
        <div id="trigger_1_box" style="display: none;">
            <form method="POST">
                <h1><u>Enter the details for message</u></h1>
                <span id="text">Sender</span><input id="trigger_input" type="text" name="m_sender" placeholder="Enter sender's mobile number"><br>
                <span id="text">Receiver</span><input id="trigger_input" type="text" name="m_receiver" placeholder="Enter receiver's mobile number"><br>
                <span id="text">Date of the Message</span><input id="trigger_input" type="text" name="m_date" placeholder="Enter date of the message sent or received"><br>
                <input id="btn1" type="submit" name="submit1" value="Submit message details">
            </form>
        </div>
        <div id="trigger_2_box" style="display: none;">
            <form method="POST">
                <h1><u>Enter the details for call</u></h1>
                <span id="text">Caller</span><input id="trigger_input" type="text" name="c_sender" placeholder="Enter caller's mobile number"><br>
                <span id="text">Receiver</span><input id="trigger_input" type="text" name="c_receiver" placeholder="Enter receiver's mobile number"><br>
                <span id="text">Date of the Call</span><input id="trigger_input" type="text" name="c_date" placeholder="Enter date of the call made or received"><br>
                <span id="text">Call duration</span><input id="trigger_input" type="text" name="c_duration" placeholder="Enter call duration"><br>
                <input id="btn2" type="submit" name="submit2" value="Submit call details">
            </form>
        </div>
        <div id="trigger_3_box" style="display: none;">
            <form method="POST">
                <h1><u>Enter the details to schedule an appointment</u></h1>
                <span id="text">Appointment date</span><input id="trigger_input" type="text" name="a_date" placeholder="Enter date of appointment"><br>
                <span id="text">Email address of the person</span><input id="trigger_input" type="text" name="a_email" placeholder="Enter the email"><br>
                <input id="btn3" type="submit" name="submit3" value="Submit appointment details">
            </form>
        </div>
        </center>
        <script>
            if(window.history.replaceState){
                window.history.replaceState( null, null, window.location.href);
            }

            var val = <?php echo $val; ?>;
            var buttonclicked = false;
            if(val==1)
            {
                document.getElementById('trigger_1_box').style = "display: block";
                $("#btn1").click(function(){ 
                if( buttonclicked!= true ) { 
                    buttonclicked= true; 
                    alert('Data saved successfully');
                }else{ 
                    alert("Button was clicked before"); 
                } 
                });
            }
            else if(val==2)
            {
                document.getElementById('trigger_2_box').style = "display: block";
                $("#btn2").click(function(){ 
                if( buttonclicked!= true ) { 
                    buttonclicked= true;
                    alert('Data saved successfully'); 
                }else{ 
                    alert("Button was clicked before"); 
                } 
                });     
            }
            else if(val==3)
            {
                document.getElementById('trigger_3_box').style = "display: block";
                $("#btn3").click(function(){ 
                if( buttonclicked!= true ) { 
                    buttonclicked= true;
                    alert('Data saved successfully');
                    document.getElementById('trigger_3_box').style = "display: none"; 
                }else{ 
                    alert("Button was clicked before"); 
                } 
                });      
            }
        </script>
    </body>
</html>