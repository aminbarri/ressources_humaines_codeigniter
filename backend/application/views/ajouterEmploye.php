<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter employe</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div class="container">
<?php include('nav.html'); ?>

<form id="employeForm" >
<div class="mb-3">
    <label for="exampleInputnom1" class="form-label">Nom</label>
    <input type="text" class="form-control" id="exampleInputnom1" name='nom'>
   
  </div>
  <div class="mb-3">
    <label for="exampleInputPrenom1" class="form-label">Prenom</label>
    <input type="text" class="form-control" id="exampleInputPrenom1" name='prenom'>
   
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name='email'>
   
  </div>
  <div class="form-floating">
  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="address"></textarea>
  <label for="floatingTextarea">address</label>
    </div>
  <div class="mb-3">
    <label for="exampleInputTelephone1" class="form-label">Telephone</label>
    <input type="number" class="form-control" id="exampleInputTelephone1" name="telephone">
  </div>
  <div class="mb-3">
     <select class="form-select" aria-label="Default select example" name="poste">
 
  <option value="1">Gerant</option>
  <option value="2">Livreur</option>
  <option value="3">Cuisiner</option>
  </select>
  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<script>
    $(document).ready(function () {
        $('#employeForm').on('submit', function (e) {
            e.preventDefault(); // Prevent form submission

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request
            $.ajax({
                url: '<?= site_url("employe/create") ?>', // CI Controller method
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    sessionStorage.setItem('success_message', 'Employé créé avec succès !');
                    window.location.href = '<?= site_url("employe/") ?>';
                },
                error: function (xhr, status, error) {
                    console.log('Error occurred: ' + error);
                }
            });
        });
    });
    
</script>
</body>
</html>