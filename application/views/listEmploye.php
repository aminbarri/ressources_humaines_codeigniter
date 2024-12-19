<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
<title>List Emplye</title>
</head>
<body>
   
   <div class="container">
        <?php include('nav.html'); ?>
        <div class="">
            <a href="<?php echo base_url(); ?>index.php/Employe/store" class=" mt-2 mb-2 ajouter-employe ">Ajouter Employe </a>
            
          
        </div>
        <h2 class="mt-5">List Employe</h2>
        <form  class="search">
                <input type="text" name="search" placeholder="rechercher" class="" id="search">
                <!-- <button type="submit">Rechercher</button> -->
             </form>
             <div id="successMessage" class="alert alert-success mt-2" style="display: none;">
               </div>

        <table class="table mt-5">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">nom</th>
            <th scope="col">prenom</th>
            <th scope="col">mail</th>
            <th scope="col">adress</th>

            <th scope="col">telephone</th>
            <th scope="col">post</th>
            <th scope="col">Modifie</th>
            <th scope="col">suprimer</th>



            </tr>
        </thead>
        <tbody id="employeeTableBody">

        </tbody>
        </table>
   </div>
   <script>$(document).ready(function () {
  
    function fetchAllEmployees() {
        $.ajax({
            url: '<?= site_url("employe/dataempl") ?>',
            type: 'GET',
            success: function (response) {
                let employees = JSON.parse(response);

                // Get the table body
                let tableBody = $("#employeeTableBody");
                tableBody.empty(); 

          
                employees.forEach(function (employee,index ) {
                    let posteTitle = "";
                    switch (employee.poste) {
                        case "1":
                            posteTitle = "Gerant";
                            break;
                        case "2":
                            posteTitle = "Livreur";
                            break;
                        case "3":
                            posteTitle = "Cuisiner";
                            break;
                        default:
                            posteTitle = "Unknown";  // Handle any unexpected values
                            break;
                    }
                    
                    let row = `
                        <tr>
                            <th scope="row">${index+1}</th>
                            <td>${employee.nom}</td>
                            <td>${employee.prenom}</td>
                            <td>${employee.mail}</td>
                            <td>${employee.adresse}</td>
                            <td>${employee.telephone}</td>
                            <td>${posteTitle}</td>
                            <td> 
                                <a href='<?= site_url("employe/edit/") ?>${employee.id}'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill archive-icon" viewBox="0 0 16 16" id='' data-id="${employee.id}">>
                                        <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                                </svg>
                               
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                  
                });
            },
            error: function (xhr, status, error) {
                console.log('Error occurred: ' + error);
            }
        });
    }

    function fetchCustomEmployees(){
        var searchData= $("#search").val().trim();
        $.ajax({
            url: '<?= site_url("employe/getEmploye") ?>',
            type: 'GET',
            data: { searchData: searchData },
            success: function (response) {
               
                let employees = JSON.parse(response);

                // Get the table body
                let tableBody = $("#employeeTableBody");
                tableBody.empty(); 
                if (employees.message || employees.error) {
                    // If there is a message or error, display it
                    tableBody.append(`
                        <tr>
                            <td colspan="9" class="text-center">${employees.message || employees.error}</td>
                        </tr>
                    `);
                } else {
          
                employees.forEach(function (employee) {
                    let posteTitle = "";
                    switch (employee.poste) {
                        case 1:
                            posteTitle = "Gerant";
                            break;
                        case 2:
                            posteTitle = "Livreur";
                            break;
                        case 3:
                            posteTitle = "Cuisiner";
                            break;
                        default:
                            posteTitle = "Unknown";  
                            break;
                    }
                    let row = `
                        <tr>
                            <th scope="row">${employee.id}</th>
                            <td>${employee.nom}</td>
                            <td>${employee.prenom}</td>
                            <td>${employee.mail}</td>
                            <td>${employee.adresse}</td>
                            <td>${employee.telephone}</td>
                            <td>${posteTitle}</td>
                            <td><a href='<?= site_url("employe/edit/") ?>${employee.id}'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square " viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill archive-icon" viewBox="0 0 16 16" id='' data-id="${employee.id}">>
                                        <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                                </svg>
                               
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });}
            },
            error: function (xhr, status, error) {
                console.log('Error occurred: ' + error);
            }
        });
    }

    function deleteEmploye() {
   
    $(document).on('click', '.archive-icon', function() {
        
        const employeeId = $(this).data('id');

   
        if (confirm("Are you sure you want to archive this employee?")) {
            
            $.ajax({
                url: '<?= site_url("employe/delete") ?>',
                type: 'POST',
                data: { id: employeeId },
                success: function(response) {
                    fetchAllEmployees();
                    if (response.status === 'success') {
                        
                        sessionStorage.setItem('success_message_delete', 'L employé a été supprimé avec succès !');
                        location.reload();
                    } else {
                        console.log(response.status);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText); 
                }
            });
        }
    });
}


deleteEmploye();
    // $("button[type='submit']").click(function (event) {
    //     event.preventDefault(); 

    //     let searchValue = $("#search").val().trim();
    //     if (searchValue === "") {
           
    //         fetchAllEmployees();
    //     }
    //     else{
    //         console.log('typing')
    //     }
      
    // });

    $("#search").on('input',function(){
        let searchValue = $("#search").val().trim();
        if (searchValue === "") {
           
            fetchAllEmployees();
        }
        else{
            fetchCustomEmployees();
        }
    })
   
    fetchAllEmployees();
});
    const successMessage = sessionStorage.getItem('success_message');
    if (successMessage) {
        
        const messageElement = document.getElementById('successMessage');
        messageElement.textContent = successMessage;
        messageElement.style.display = 'block'; 
        
      
        setTimeout(function() {
            messageElement.style.display = 'none'; 
            
            
            sessionStorage.removeItem('success_message');
        }, 4000); 
    }
    const deleteMessage = sessionStorage.getItem('success_message_delete');
if (deleteMessage) {
    const messageElement1 = document.getElementById('successMessage'); 
    messageElement1.textContent = deleteMessage;
    messageElement1.style.display = 'block'; 

    setTimeout(function() {
        messageElement1.style.display = 'none'; 
        sessionStorage.removeItem('success_message_delete'); 
    }, 4000); 
}
   </script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>