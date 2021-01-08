<?php
session_start();

if((isset($_SESSION["type"]) && $_SESSION["type"] != 1) || !isset($_SESSION["type"]))
{
    header('Location:profile.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require "inc/navbar.php";?>

<div class="container">
      <div class="row">
        <div class="col">
            <h3>Ajouter ici les test</h3>
            <div class="form-group">
                <label for="test">Ajouter un Test</label>
                <input type="text" id="test" class="form-control"  placeholder="Entrer le nom du test ">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" col="15" class="form-control" row="20"></textarea>
            </div>
            <button type="submit" id="testAdd" class="btn btn-primary">Ajouter</button>
        </div>
          <div class="col">
              <h3>Ajouter ici les paires questions/réponses</h3>
              <div class="form-group">
                  <label for="testname">Choisir le test</label>
                  <select class="form-control" id="testname" >

                  </select>
              </div>
              <div class="form-group">
                  <label for="question">Question</label>
                  <textarea id="question" col="15" class="form-control" row="20"></textarea>
              </div>
              <div class="form-group">
                  <label for="answer">Réponse</label>
                  <input type="text" id="answer" class="form-control"  placeholder="Entrer la réponse ">
              </div>
              <div class="form-group">
                  <label for="note">Note</label>
                  <input type="number" id="point" class="form-control"  placeholder="Entrer la réponse ">
              </div>
              <button type="submit" id="addQa" class="btn btn-primary">Ajouter</button>
          </div>
          </div>
    <div class="row mt-5">
        <div class="col">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test</th>
                    <th scope="col">Nombre de question</th>
                    <th scope="col">Nombre de participants</th>
                </tr>
                </thead>
                <tbody id="fetchTable">
                </tbody>
            </table>
        </div>
    </div>
</div>





<script src="js/jquery-3.4.1.js"></script>
<script src="js/notify.js"></script>
<script>
    $(document).ready(function(){

        // Add Test
       $('#testAdd').on('click',function(){
           var testName = $('#test').val(),
               description = $('#description').val(),
               typeAction  = 'test';

           if (testName == '')
           {
               $.notify("le champ test name est vide","warn");
           }
           else
           {
               $.ajax({
                   url:'inc/new.php',
                   method:'post',
                   data:{testName:testName,description:description,typeAction:typeAction},
                   success: function(data){
                       if (data =="test ajouté...")
                       {
                           $.notify(data,"success");
                           fetchTest();
                           fetchTable();
                       }
                       else
                       {
                           $.notify(data,"info");
                       }

                   }
               });
           }

       });

       // Add question/Answer
        $('#addQa').on('click',function(){
        var testName = $('#testname').val(),
            question = $('#question').val(),
            answer   = $('#answer').val(),
            point    = $('#point').val();

        if( question=='' || answer=='' || point=='')
        {
            alert("il y'a des champs vides");
        }else{
            $.ajax({
                url:"inc/new.php",
                method:"post",
                beforeSend:function(){
                  $('#addQa').text("en cours...");
                },
                data:{testName:testName,question:question,answer:answer,point:point,typeAction:"qa"},
                success:function(data){
                    $('#addQa').text("ajouter");
                    $.notify(data,"info");
                    fetchTable();
                }
            });
        }
        });


        // Fetch Test
        fetchTest();
        function fetchTest()
        {
            var fetch = 'fetch';
            $.ajax({
                url:"inc/getTest.php",
                method:"post",
                data:{fetch:fetch},
                success:function(data){
                    $("#testname").html(data);

                }
            });
        }

        // Fetch data in the table
        fetchTable();
        function fetchTable()
        {
            var fetch = 'fetch';
            $.ajax({
                url:"inc/getTable.php",
                method:"post",
                data:{fetch:fetch},
                success:function(data){
                    $("#fetchTable").html(data);

                }
            });
        }


    });
</script>
</body>
</html>