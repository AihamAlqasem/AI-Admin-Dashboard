$(document).ready(function () {
	// Handle the confirmation dialog
	$('.confirm').click(function (event) {
	  event.preventDefault(); // Prevent the default click behavior

	  var deleteURL = $(this).attr('href'); // Get the delete URL from the button's href attribute

	  $('#confirmModal').modal('show'); // Show the confirmation modal

	  // Handle the delete action if confirmed
	  $('#confirmDelete').click(function () {
		window.location.href = deleteURL; // Redirect to the delete URL
	  });
	});
  });