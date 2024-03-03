function bookingPage() {
   window.location.href = "booking.php";
}
function accountPage() {
   window.location.href = "account.php";
}

function editPhotographerPage() {
   window.location.href = "../code/editing/edit-photographer.php";
}
function editPhotosessionPage() {
   window.location.href = "../code/editing/edit-photosession.php";
}

function editPhotostudioPage() {
   window.location.href = "../code/editing/edit-photostudio.php";
}

function editAccPage() {
   window.location.href = "../code/editing/edit-acc.php";
}

function bookingViewPage() {
    window.location.href = "../code/booking-info.php";
 }

$(document).ready(function() {
   // Обработчик кнопки "Удалить"
   $(".delete-btn").click(function() {
       var photographerId = $(this).data('id');
       if (confirm("Вы уверены, что хотите удалить фотографа?")) {
           $.ajax({
               type: "POST",
               url: "delete.php",
               data: {id: photographerId},
               success: function(response) {
                   location.reload();
               }
           });
       }
   });

   // Обработчик кнопки "Изменить"
   $(".edit-btn").click(function() {
       var photographerId = $(this).data('id');
       var newName = prompt("Введите новое имя фотографа:");
       if (newName !== null) {
           $.ajax({
               type: "POST",
               url: "update.php",
               data: {id: photographerId, name: newName},
               success: function(response) {
                   location.reload();
               }
           });
       }
   });

   // Обработчик формы добавления нового фотографа
   $("#addForm").submit(function(event) {
       event.preventDefault();
       var firstName = $("#firstName").val();
       var lastName = $("#lastName").val();
       var experience = $("#experience").val();
       $.ajax({
           type: "POST",
           url: "add.php",
           data: {firstName: firstName, lastName: lastName, experience: experience},
           success: function(response) {
               location.reload();
           }
       });
   });
});
