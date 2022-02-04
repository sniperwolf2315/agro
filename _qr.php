<? 				include('phpqrcode/qrlib.php'); 
    //$_GET['id'] = "https://www.agrocampo.com.co/catalogsearch/result/?q=nutra+nuggets";    
    $param = $_GET['busca']; // remember to sanitize that - it is user input! 
    $param = str_replace("|","+",$param); 
    // we need to be sure ours script does not output anything!!! 
    // otherwise it will break up PNG binary! 
     
    ob_start("callback"); 
     
    // here DB request or some processing 
    $codeText = $param; 
     
    // end of processing here 
    $debugLog = ob_get_contents(); 
    ob_end_clean(); 
     
    // outputs image directly into browser, as PNG stream 
    QRcode::png($codeText);					?>
