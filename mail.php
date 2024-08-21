<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$stato =  'display:none;';
$__invia="";

if(isset($_GET['_invia'])) {
    $__invia= "ok";
}

// Crea una nuova istanza 
$mail = new PHPMailer\PHPMailer\PHPMailer();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$emailUtente =(isset($_GET['email']));

// Array per salvare le righe 
$rows = [];
if(isset($_GET['code'])) {

// Ciclo sui codici per popolare l'array $rows
    foreach ($_GET['code'] as $i => $codice) {

    $row = [];
    $row['code'] = $codice;
    $row['var'] = $_GET['var'][$i]; 
    $row['quantita'] = $_GET['quantita'][$i];

    $rows[]=$row;

    }
}


// $mail = new PHPMailer\PHPMailer\PHPMailer();
// $db = new Database();

// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'waleed.khalid@studenti.unicam.it';
// $mail->Password = 'hnph jqfm ptzf ezwd';
// $mail->SMTPSecure = 'tls'; // o 'ssl'
// $mail->Port = 587; // o 465 per SSL

// $mail->setFrom('from@example.com', 'Nome Mittente');
// $mail->addAddress('waleed.khalid@studenti.unicam.it', 'Nome Destinatario');
// $mail->Subject = 'Oggetto dell\'email';
// $mail->Body = 'Contenuto dell\'email';

// if (!$mail->send()) {
//   echo 'Errore durante l\'invio dell\'email: ' . $mail->ErrorInfo;
// } else {
//   echo 'Email inviata correttamente!';
// }





if($__invia == 'ok') {

 echo "dentro";
    $mail->IsSMTP(); 
$mail->SMTPSecure = 'tls'; 
$mail->Port = 587;
$mail->Host = "smtp.gmail.com"; 
$mail->SMTPAuth = true;
$mail->isHTML(true);
$mail->Username = "slvtr.lorenzo01@gmail.com";  
$mail->Password = "sdnp lnie tvvk gsmu";

   $mail->setFrom('mittente@email.com', 'paolor@gmail.com');
$mail->addAddress('lorenzo.salvatori01@gmail.com');  

$mail->Subject = 'aaaa';

// Corpo email
$body = "<h1>Riepilogo Ordine</h1>"; 

$body.=$emailUtente;

foreach ($rows as $row) {
  $body .= "<p><strong>Codice:</strong> {$row['code']}";
  $body .= "<br><strong>Variazione:</strong> {$row['var']}"; 
  $body .= "<br><strong>Qtà:</strong> {$row['quantita']}</p>";
}



// Imposta corpo email
$mail->Body=$body;



    if($mail->send()){

        echo "send mail";
        $stato =  'display:block;';

    }else{
        echo "error";
        $stato =  'display:none;';

    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Bootstrap</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
</head>
<body>
<div class="container mt-5">
  


  <form action="mail.php" method="GET" id="myForm">


  <center><div class="form-group col-md-4">
          <label for="code">Email</label>
          <input type="text" class="form-control" name="mail" placeholder="Inserisci la tua mail">
        </div></center>

        <div class="alert alert-danger" role="alert" id="alertDiv"  style="display:none;" >
    This is a danger alert—check it out!
  </div>
  <div class="alert alert-success" role="alert"  id="successDiv" style="<?php echo $stato ?>">
  Ordine inviato!
</div>
    <div id="rows-container">
      <!-- Prima riga -->
      <div class="form-row mb-3">

        <div class="form-group col-md-4">
          <label for="code">Codice</label>
          <input type="text" class="form-control" name="code[]" placeholder="Inserisci codice">
        </div>

        <div class="form-group col-md-4">
          <label for="var">Variazione</label>
          <input type="text" class="form-control" name="var[]" placeholder="Inserisci variazione">
        </div>

        <div class="form-group col-md-2">
          <label for="quantita">Quantità</label>  
          <input type="number" class="form-control" name="quantita[]" placeholder="Inserisci quantità" required> 
        </div>

        <div class="form-group col-md-2">
          <button type="button" class="btn btn-outline-danger mt-4 ml-0" onclick="removeRow(this)">X</button>
        </div>


      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <button type="button" class="btn btn-danger btn-lg" onclick="addRow()">Aggiungi Riga</button>
        <button type="button" class="btn btn-danger btn-sm" id="invia" name="invia" value="true" onclick="checkAndSubmit()">Invia</button>
      </div>
    </div>

    <input type="hidden" id="_invia" name="_invia" value="ok">

  </form>
    

</div>
</body>
</html>

<script>
   

    function addRow() {
      
      var container = document.getElementById("rows-container");
      var newRow = container.children[0].cloneNode(true);

      // Clear input values in the new row
      newRow.querySelectorAll('input').forEach(function (input) {
        input.value = '';

      
      });

      container.appendChild(newRow);
    }

    function removeRow(button) {
      var container = document.getElementById("rows-container");
      if (container.children.length > 1) {
        var rowToRemove = button.parentNode.parentNode;
        container.removeChild(rowToRemove);
      }
    }


function checkAndSubmit() {
  var form = document.getElementById("myForm");
  var formData = new FormData(form);
  var arrayCodici = ['ab', 'ac', 'ad'];
  var arrayCaratteri = ['hi', 'ciao'];
  var invalidCodes = [];
  var alertDiv = document.getElementById("alertDiv");
  var successDiv = document.getElementById("successDiv");
  var quantitaError = false;



  formData.getAll('quantita[]').forEach(function (quantitaValue) {
      if (quantitaValue.trim() === '') {
        quantitaError = true;
      }
    });

  formData.getAll('code[]').forEach(function (codeValue) {
    if (arrayCodici.includes(codeValue)) {
      // Codice presente in arrayCodici, verifica la presenza della quantità
      var index = formData.getAll('code[]').indexOf(codeValue);
      var quantitaValue = formData.getAll('quantita[]')[index].trim();
      if (quantitaValue === '') {
        quantitaError = true;
      }
    } else if (arrayCaratteri.includes(codeValue)) {
      // Codice presente in arrayCaratteri, verifica la presenza della variazione
      var index = formData.getAll('code[]').indexOf(codeValue);
      var variazioneValue = formData.getAll('var[]')[index].trim();
      if (variazioneValue === '') {
        invalidCodes.push(codeValue);
      }
    } else {
      // Codice non presente in arrayCodici né in arrayCaratteri
      invalidCodes.push(codeValue);
    }
  });

  // Se c'è un errore nella quantità, visualizza il messaggio di errore e interrompi
  if (quantitaError) {
    alertDiv.innerHTML = 'La Quantità non può essere vuota.';
    alertDiv.style.display = 'block';
    return;
  }

  if (invalidCodes.length === 0) {
    // alert('Inviato');
    document.getElementById('_invia').value = 'ok';
    // Puoi anche inviare il form qui se necessario:
    form.submit();
  } else {
    alertDiv.innerHTML = 'Codici errati o variazioni vuote: ' + invalidCodes.join(', ');
    alertDiv.style.display = 'block';
    successDiv.style.display = 'none';

  }
}

</script>