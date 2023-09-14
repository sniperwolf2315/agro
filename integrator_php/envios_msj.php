<!DOCTYPE html>
 <head>
   <meta charset="utf-8" />
  </head>
  <body>
   <div id="container">
    <h1>Sending SMS with PHP</h1>
    <form action="envio.php" method="post">
     <ul>
      <li>
       <label for="phoneNumber">Phone Number</label>
       <input type="text" name="phoneNumber" id="phoneNumber" placeholder="3855550168" /></li>
      <li>
      <label for="carrier">Carrier</label>
       <input type="text" name="carrier" id="carrier" />
      </li>
      <li>
       <label for="smsMessage">Message</label>
       <textarea name="smsMessage" id="smsMessage" cols="45" rows="15"></textarea>
      </li>
     <li><input type="submit" name="sendMessage" id="sendMessage" value="Send Message" /></li>
    </ul>
   </form>
  </div>
 </body>
</html>