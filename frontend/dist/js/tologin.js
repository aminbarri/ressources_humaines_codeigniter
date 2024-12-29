$(document).ready(function () {
    const authToken = localStorage.getItem('authToken');

    if (!authToken) {
        window.location.href = 'login.html';
    } else {
        
        $.ajax({
            url: '../backend/index.php/auth/auth/verify_token',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ token: authToken }), 
            success: function(response) {
                if (response.status !== 'success') {
                    localStorage.removeItem('authToken');
                    window.location.href = 'login.html';
                }
            },
            error: function(xhr, status, error) {
                console.log('Error occurred: ' + error);
            }
        });
    }
});


$(document).ready(function () {
    $('#deconnexion').on('click', function () {
        $.ajax({
            url: '../backend/index.php/auth/auth/logout',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ token: localStorage.getItem('authToken') }),
            success: function (response) {
                console.log('Logout successful:', response);
                localStorage.clear();
                window.location.href = 'login.html';
            },
            error: function (xhr, status, error) {
                console.error('Error during logout:', error);
                alert('Error during logout. Please try again.');
            }
        });
    });
});
$(document).ready(function () {
    let userRole = localStorage.getItem('userRole');
    let prenom = localStorage.getItem('userPrenom')+' '+localStorage.getItem('userName');
    $('#nameprenom').html(prenom);
    setTimeout(function() {
        if (userRole !== '1') {
            $('.hidethisitem').hide();
        }
    }, 3000); 

});

function removeElementtd(userRole){
    
    if (userRole !== '1') {
        $('.hidethisitem').hide();
    }
}